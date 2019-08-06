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
use chillerlan\OAuth\Storage\{OAuthStorageAbstract, OAuthStorageException};
use chillerlan\Settings\SettingsContainerInterface;
use Psr\Log\LoggerInterface;

use function extension_loaded, is_bool, sha1, sodium_bin2hex, sodium_crypto_secretbox,
	sodium_crypto_secretbox_open, sodium_hex2bin, sprintf, trim;

/**
 * @property \chillerlan\OAuthApp\OAuthAppOptions $options
 */
class DBStorage extends OAuthStorageAbstract{

	/** @var \chillerlan\Database\Database */
	protected $db;
	/** @var array */
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

		if(!extension_loaded('sodium')){
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
	 * @inheritDoc
	 */
	public function storeAccessToken(string $service, AccessToken $token):bool{

		if(!isset($this->providers[$service])){
			throw new OAuthStorageException('unknown service');
		}

		$values = [
			'user_id'     => $this->options->db_user_id,
			'provider_id' => $this->providers[$service]['provider_id'],
			'token'       => $this->toStorage($token),
			'expires'     => $token->expires,
			'refreshable' => (int)!empty($token->refreshToken),
		];

		$label = $this->getLabel($service);

		if($this->hasAccessToken($service)){
			return (bool)$this->db->update
				->table($this->options->db_table_token)
				->set($values)
				->where('label', $label)
				->query();
		}

		$values['label'] = $label;

		return (bool)$this->db->insert
			->into($this->options->db_table_token)
			->values($values)
			->query();
	}

	/**
	 * @inheritDoc
	 */
	public function getAccessToken(string $service):AccessToken{

		$r = $this->db->select
			->cols(['token'])
			->from([$this->options->db_table_token])
			->where('label', $this->getLabel($service))
			->limit(1)
			->query();

		if(is_bool($r) || $r->length < 1){
			throw new OAuthStorageException('token not found');
		}

		return $this->fromStorage($r[0]->token);
	}

	/**
	 * @inheritDoc
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
	 * @inheritDoc
	 */
	public function clearAccessToken(string $service):bool{

		return (bool)$this->db->delete
			->from($this->options->db_table_token)
			->where('label', $this->getLabel($service))
			->query();
	}

	/**
	 * @inheritDoc
	 */
	public function clearAllAccessTokens():bool{

		return (bool)$this->db->delete
			->from($this->options->db_table_token)
			->where('user_id', $this->options->db_user_id)
			->query();
	}

	/**
	 * @inheritDoc
	 */
	public function storeCSRFState(string $service, string $state):bool{

		return (bool)$this->db->update
			->table($this->options->db_table_token)
			->set(['state' => $state])
			->where('label', $this->getLabel($service))
			->query();
	}

	/**
	 * @inheritDoc
	 */
	public function getCSRFState(string $service):string{

		$r = $this->db->select
			->cols(['state'])
			->from([$this->options->db_table_token])
			->where('label', $this->getLabel($service))
			->limit(1)
			->query();

		if(is_bool($r) || $r->length < 1){
			throw new OAuthStorageException('state not found');
		}

		return trim($r[0]->state);
	}

	/**
	 * @inheritDoc
	 */
	public function hasCSRFState(string $service):bool{

		$r = $this->db->select
			->cols(['state'])
			->from([$this->options->db_table_token])
			->where('label', $this->getLabel($service))
			->limit(1)
			->query();

		if(is_bool($r) || $r->length < 1 || empty(trim($r[0]->state))){
			return false;
		}

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function clearCSRFState(string $service):bool{

		return (bool)$this->db->update
			->table($this->options->db_table_token)
			->set(['state' => null])
			->where('label', $this->getLabel($service))
			->query();
	}

	/**
	 * @inheritDoc
	 */
	public function clearAllCSRFStates():bool{

		return (bool)$this->db->update
			->table($this->options->db_table_token)
			->set(['state' => null])
			->where('user_id', $this->options->db_user_id)
			->query();
	}

	/**
	 * @param string $service
	 *
	 * @return string
	 */
	protected function getLabel(string $service):string{
		return sha1(sprintf('%s@%s', $this->options->db_user_id, $service));
	}

	/**
	 * @inheritDoc
	 */
	public function toStorage(AccessToken $token):string{
		$data = $token->toJSON();

		if($this->options->storageEncryption === true){
			return $this->encrypt($data);
		}

		return $data;
	}
	/**
	 * @inheritDoc
	 */
	public function fromStorage($data):AccessToken{

		if($this->options->storageEncryption === true){
			$data = $this->decrypt($data);
		}

		/** @noinspection PhpIncompatibleReturnTypeInspection */
		return (new AccessToken)->fromJSON($data);
	}

	/**
	 * @param string $data
	 *
	 * @return string
	 */
	protected function encrypt(string $data):string {
		$box = sodium_crypto_secretbox($data, $this->options->storageCryptoNonce, $this->options->storageCryptoKey);

		return sodium_bin2hex($box);
	}

	/**
	 * @param string $box
	 *
	 * @return string
	 */
	protected function decrypt(string $box):string {
		return sodium_crypto_secretbox_open(sodium_hex2bin($box), $this->options->storageCryptoNonce, $this->options->storageCryptoKey);
	}

}
