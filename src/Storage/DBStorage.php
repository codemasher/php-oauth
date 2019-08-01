<?php
/**
 * Class DBStorage
 *
 * @filesource   DBStorage.php
 * @created      31.07.2019
 * @package      chillerlan\OAuthApp\Storage
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthApp\Storage;

use chillerlan\Database\Database;
use chillerlan\OAuth\Core\AccessToken;
use chillerlan\OAuth\Storage\{OAuthStorageAbstract, OAuthStorageException, OAuthStorageInterface};
use chillerlan\Settings\SettingsContainerInterface;
use Psr\Log\LoggerInterface;

/**
 * @property \chillerlan\OAuthApp\OAuthAppOptions $options
 */
class DBStorage extends OAuthStorageAbstract{

	/** @var \chillerlan\Database\Database */
	protected $db;

	protected $providers;

	/**
	 * DBStorage constructor.
	 *
	 * @param \chillerlan\Database\Database                   $db
	 * @param \chillerlan\Settings\SettingsContainerInterface $options
	 * @param \Psr\Log\LoggerInterface|null                   $logger
	 *
	 * @throws \chillerlan\OAuth\Storage\OAuthStorageException
	 */
	public function __construct(Database $db, SettingsContainerInterface $options, LoggerInterface $logger = null){

		if(!\extension_loaded('sodium')){
			throw new OAuthStorageException('sodium extension missing'); // @codeCoverageIgnore
		}

		parent::__construct($options, $logger);

		if(!$this->options->db_table_token || !$this->options->db_table_provider){
			throw new OAuthStorageException('invalid table config');
		}

		$this->db = $db;

		$db->connect();

		$this->providers = $this->db->select
			->cached()
			->from([$this->options->db_table_provider])
			->query('name')
			->__toArray();
	}

	/**
	 * @param string                             $service
	 * @param \chillerlan\OAuth\Core\AccessToken $token
	 *
	 * @return \chillerlan\OAuth\Storage\OAuthStorageInterface
	 * @throws \chillerlan\OAuth\Storage\OAuthStorageException
	 */
	public function storeAccessToken(string $service, AccessToken $token):OAuthStorageInterface{

		if(!isset($this->providers[$service])){
			throw new OAuthStorageException('unknown service');
		}

		// @todo: token type (cc/ac), refreshable
		$values = [
			'user_id'     => $this->options->db_user_id,
			'provider_id' => $this->providers[$service]['provider_id'],
			'token'       => $this->toStorage($token),
			'expires'     => $token->expires,
			'refreshable' => (int)!empty($token->refreshToken),
		];

		$label = $this->getLabel($service);

		if($this->hasAccessToken($service)){
			$this->db->update
				->table($this->options->db_table_token)
				->set($values)
				->where('label', $label)
				->query();

			return $this;
		}

		$values['label'] = $label;

		$this->db->insert
			->into($this->options->db_table_token)
			->values($values)
			->query();

		return $this;
	}

	/**
	 * @param string $service
	 *
	 * @return \chillerlan\OAuth\Core\AccessToken
	 * @throws \chillerlan\OAuth\Storage\OAuthStorageException
	 */
	public function getAccessToken(string $service):AccessToken{

		$r = $this->db->select
			->cols(['token'])
			->from([$this->options->db_table_token])
			->where('label', $this->getLabel($service))
			->limit(1)
			->query();

		if(\is_bool($r) || $r->length < 1){
			throw new OAuthStorageException('token not found');
		}

		return $this->fromStorage($r[0]->token);
	}

	/**
	 * @param string $service
	 *
	 * @return bool
	 */
	public function hasAccessToken(string $service):bool{

		return (bool)$this->db->select
			->cols(['token'])
			->from([$this->options->db_table_token])
			->where('label', $this->getLabel($service))
			->limit(1)
			->count();
	}

	/**
	 * @param string $service
	 *
	 * @return \chillerlan\OAuth\Storage\OAuthStorageInterface
	 */
	public function clearAccessToken(string $service):OAuthStorageInterface{

		$this->db->delete
			->from($this->options->db_table_token)
			->where('label', $this->getLabel($service))
			->query();

		return $this;
	}

	/**
	 * @return \chillerlan\OAuth\Storage\OAuthStorageInterface
	 */
	public function clearAllAccessTokens():OAuthStorageInterface{

		$this->db->delete
			->from($this->options->db_table_token)
			->where('user_id', $this->options->db_user_id)
			->query();

		return $this;
	}

	/**
	 * @param string $service
	 * @param string $state
	 *
	 * @return \chillerlan\OAuth\Storage\OAuthStorageInterface
	 */
	public function storeCSRFState(string $service, string $state):OAuthStorageInterface{

		$this->db->update
			->table($this->options->db_table_token)
			->set(['state' => $state])
			->where('label', $this->getLabel($service))
			->query();

		return $this;
	}

	/**
	 * @param string $service
	 *
	 * @return string
	 * @throws \chillerlan\OAuth\Storage\OAuthStorageException
	 */
	public function getCSRFState(string $service):string{

		$r = $this->db->select
			->cols(['state'])
			->from([$this->options->db_table_token])
			->where('label', $this->getLabel($service))
			->limit(1)
			->query();

		if(\is_bool($r) || $r->length < 1){
			throw new OAuthStorageException('state not found');
		}

		return trim($r[0]->state);
	}

	/**
	 * @param string $service
	 *
	 * @return bool
	 */
	public function hasCSRFState(string $service):bool{

		$r = $this->db->select
			->cols(['state'])
			->from([$this->options->db_table_token])
			->where('label', $this->getLabel($service))
			->limit(1)
			->query();

		if(\is_bool($r) || $r->length < 1 || empty(\trim($r[0]->state))){
			return false;
		}

		return true;
	}

	/**
	 * @param string $service
	 *
	 * @return \chillerlan\OAuth\Storage\OAuthStorageInterface
	 */
	public function clearCSRFState(string $service):OAuthStorageInterface{

		$this->db->update
			->table($this->options->db_table_token)
			->set(['state' => null])
			->where('label', $this->getLabel($service))
			->query();

		return $this;
	}

	/**
	 * @return \chillerlan\OAuth\Storage\OAuthStorageInterface
	 */
	public function clearAllCSRFStates():OAuthStorageInterface{

		$this->db->update
			->table($this->options->db_table_token)
			->set(['state' => null])
			->where('user_id', $this->options->db_user_id)
			->query();

		return $this;
	}

	/**
	 * @param string $service
	 *
	 * @return string
	 */
	protected function getLabel(string $service):string{
		return \sha1(\sprintf('%s@%s', $this->options->db_user_id, $service));
	}

	/**
	 * @param \chillerlan\OAuth\Core\AccessToken $token
	 *
	 * @return string
	 */
	public function toStorage(AccessToken $token):string {
		$data = $token->toJSON();

		if($this->options->storageEncryption === true){
			return $this->encrypt($data);
		}

		return $data;
	}
	/**
	 * @param string $data
	 *
	 * @return \chillerlan\OAuth\Core\AccessToken
	 */
	public function fromStorage(string $data):AccessToken{

		if($this->options->storageEncryption === true){
			$data = $this->decrypt($data);
		}

		return (new AccessToken)->fromJSON($data);
	}
	/**
	 * @param string $data
	 *
	 * @return string
	 */
	protected function encrypt(string $data):string {
		$box = \sodium_crypto_secretbox($data, $this->options->storageCryptoNonce, $this->options->storageCryptoKey);

		return \sodium_bin2hex($box);
	}
	/**
	 * @param string $box
	 *
	 * @return string
	 */
	protected function decrypt(string $box):string {
		return \sodium_crypto_secretbox_open(\sodium_hex2bin($box), $this->options->storageCryptoNonce, $this->options->storageCryptoKey);
	}
}
