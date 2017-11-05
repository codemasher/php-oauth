<?php
/**
 * Class DBTokenStorage
 *
 * @filesource   DBTokenStorage.php
 * @created      16.07.2017
 * @package      chillerlan\OAuth\Storage
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Storage;

use chillerlan\Database\Connection;
use chillerlan\OAuth\{
	OAuthException, OAuthOptions, Token
};

class DBTokenStorage extends TokenStorageAbstract{

	/**
	 * @var \chillerlan\Database\Connection
	 */
	protected $db;

	/**
	 * @var int|string
	 */
	protected $user_id;

	/**
	 * DBTokenStorage constructor.
	 *
	 * @param \chillerlan\OAuth\OAuthOptions   $options
	 * @param \chillerlan\Database\Connection  $db
	 * @param string|int                       $user_id
	 */
	public function __construct(OAuthOptions $options, Connection $db, $user_id){
		parent::__construct($options);

		if(!$this->options->dbTokenTable || !$this->options->dbProviderTable){
			throw new OAuthException('invalid table config');
		}

		$this->db      = $db;
		$this->user_id = $user_id;

		$this->db->connect();
	}

	/**
	 * @return array
	 */
	protected function getProviders():array {
		return $this->db->select
			->cached()
			->from([$this->options->dbProviderTable])
			->execute($this->options->dbProviderTableName)
			->__toArray();
	}

	/**
	 * @param string                  $service
	 * @param \chillerlan\OAuth\Token $token
	 *
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function storeAccessToken(string $service, Token $token):TokenStorageInterface{

		if(!isset($this->getProviders()[$service])){
			throw new OAuthException('unknown service');
		}

		$values = [
			$this->options->dbTokenTableUser       => $this->user_id,
			$this->options->dbTokenTableProviderID =>
				$this->getProviders()[$service][$this->options->dbProviderTableID],
			$this->options->dbTokenTableToken      => serialize($token),
			$this->options->dbTokenTableExpires    => $token->expires,
		];

		if($this->hasAccessToken($service) === true){
			$this->db->update
				->table($this->options->dbTokenTable)
				->set($values)
				->where($this->options->dbTokenTableLabel, $this->getLabel($service))
				->execute();

			return $this;
		}

		$values[$this->options->dbTokenTableLabel] = $this->getLabel($service);

		$this->db->insert
			->into($this->options->dbTokenTable)
			->values($values)
			->execute();

		return $this;
	}

	/**
	 * @param string $service
	 *
	 * @return \chillerlan\OAuth\Token
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function retrieveAccessToken(string $service):Token{

		$r = $this->db->select
			->cols([$this->options->dbTokenTableToken])
			->from([$this->options->dbTokenTable])
			->where($this->options->dbTokenTableLabel, $this->getLabel($service))
			->execute();

		if(is_bool($r) || $r->length < 1){
			throw new OAuthException('token not found');
		}

		return $r[0]->token('unserialize');
	}

	/**
	 * @param string $service
	 *
	 * @return bool
	 */
	public function hasAccessToken(string $service):bool{

		return (bool)$this->db->select
			->cols([$this->options->dbTokenTableToken])
			->from([$this->options->dbTokenTable])
			->where($this->options->dbTokenTableLabel, $this->getLabel($service))
			->count();
	}

	/**
	 * @param string $service
	 *
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function clearAccessToken(string $service):TokenStorageInterface{

		$this->db->delete
			->from($this->options->dbTokenTable)
			->where($this->options->dbTokenTableLabel, $this->getLabel($service))
			->execute();

		return $this;
	}

	/**
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function clearAllAccessTokens():TokenStorageInterface{

		$this->db->delete
			->from($this->options->dbTokenTable)
			->where($this->options->dbTokenTableUser, $this->user_id)
			->execute();

		return $this;
	}

	/**
	 * @param string $service
	 * @param string $state
	 *
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function storeAuthorizationState(string $service, string $state):TokenStorageInterface{

		$this->db->update
			->table($this->options->dbTokenTable)
			->set([$this->options->dbTokenTableState => $state])
			->where($this->options->dbTokenTableLabel, $this->getLabel($service))
			->execute();

		return $this;
	}

	/**
	 * @param string $service
	 *
	 * @return string
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function retrieveAuthorizationState(string $service):string{

		$r = $this->db->select
			->cols([$this->options->dbTokenTableState])
			->from([$this->options->dbTokenTable])
			->where($this->options->dbTokenTableLabel, $this->getLabel($service))
			->execute();

		if(is_bool($r) || $r->length < 1){
			throw new OAuthException('state not found');
		}

		return (string)$r[0]->state('trim');
	}

	/**
	 * @param string $service
	 *
	 * @return bool
	 */
	public function hasAuthorizationState(string $service):bool{

		$r = $this->db->select
			->cols([$this->options->dbTokenTableState])
			->from([$this->options->dbTokenTable])
			->where($this->options->dbTokenTableLabel, $this->getLabel($service))
			->execute();

		if(is_bool($r) || $r->length < 1 || empty($r[0]->state('trim'))){
			return false;
		}

		return true;
	}

	/**
	 * @param string $service
	 *
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function clearAuthorizationState(string $service):TokenStorageInterface{

		$this->db->update
			->table($this->options->dbTokenTable)
			->set([$this->options->dbTokenTableState => null])
			->where($this->options->dbTokenTableLabel, $this->getLabel($service))
			->execute();

		return $this;
	}

	/**
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function clearAllAuthorizationStates():TokenStorageInterface{

		$this->db->update
			->table($this->options->dbTokenTable)
			->set([$this->options->dbTokenTableState => null])
			->where($this->options->dbTokenTableUser, $this->user_id)
			->execute();

		return $this;
	}

	/**
	 * @param string $service
	 *
	 * @return string
	 */
	protected function getLabel(string $service):string{
		return hash($this->options->dbLabelHashAlgo, sprintf($this->options->dbLabelFormat, $this->user_id, $service));
	}

}
