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
use chillerlan\OAuth\{OAuthException, Token};

class DBTokenStorage extends TokenStorageAbstract{

	const LABEL_HASH_ALGO = 'md5';

	/**
	 * @var \chillerlan\Database\Connection
	 */
	protected $db;

	/**
	 * @var string
	 */
	protected $token_table;

	/**
	 * @var string
	 */
	protected $provider_table;

	/**
	 * @var int
	 */
	protected $user_id;

	/**
	 * DBTokenStorage constructor.
	 *
	 * @param \chillerlan\Database\Connection $db
	 * @param string                          $token_table
	 * @param string                          $provider_table
	 * @param int                             $user_id
	 */
	public function __construct(Connection $db, string $token_table, string $provider_table, int $user_id){
		$this->db             = $db;
		$this->token_table    = $token_table;
		$this->provider_table = $provider_table;
		$this->user_id        = $user_id;

		$this->db->connect();
	}

	/**
	 * @return array
	 */
	protected function getProviders():array {
		return $this->db->select
			->cached()
			->from([$this->provider_table])
			->execute('servicename')
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
			'user_id'     => $this->user_id,
			'provider_id' => $this->getProviders()[$service]['provider_id'],
			'token'       => serialize($token),
			'expires'     => $token->expires,
		];

		if($this->hasAccessToken($service) === true){
			$this->db->update
				->table($this->token_table)
				->set($values)
				->where('label', $this->getLabel($service))
				->execute();
		}
		else{
			$values['label'] = $this->getLabel($service);

			$this->db->insert
				->into($this->token_table)
				->values($values)
				->execute();
		}

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
			->cols(['token'])
			->from([$this->token_table])
			->where('label', $this->getLabel($service))
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
			->cols(['token'])
			->from([$this->token_table])
			->where('label', $this->getLabel($service))
			->count();
	}

	/**
	 * @param string $service
	 *
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function clearAccessToken(string $service):TokenStorageInterface{

		$this->db->delete
			->from($this->token_table)
			->where('label', $this->getLabel($service))
			->execute();

		return $this;
	}

	/**
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function clearAllAccessTokens():TokenStorageInterface{

		$this->db->delete
			->from($this->token_table)
			->where('user_id', $this->user_id)
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
			->table($this->token_table)
			->set(['state' => $state])
			->where('label', $this->getLabel($service))
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
			->cols(['state'])
			->from([$this->token_table])
			->where('label', $this->getLabel($service))
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
			->cols(['state'])
			->from([$this->token_table])
			->where('label', $this->getLabel($service))
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
			->table($this->token_table)
			->set(['state' => null])
			->where('label', $this->getLabel($service))
			->execute();

		return $this;
	}

	/**
	 * @return \chillerlan\OAuth\Storage\TokenStorageInterface
	 */
	public function clearAllAuthorizationStates():TokenStorageInterface{

		$this->db->update
			->table($this->token_table)
			->set(['state' => null])
			->where('user_id', $this->user_id)
			->execute();

		return $this;
	}

	/**
	 * @param string $service
	 *
	 * @return string
	 */
	protected function getLabel(string $service):string{
		return hash(self::LABEL_HASH_ALGO, $this->user_id.'#'.$service);
	}

}
