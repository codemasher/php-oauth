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

	protected $db;
	protected $token_table;
	protected $user_id;

	public function __construct(Connection $db, string $token_table, int $user_id){
		$this->db          = $db;
		$this->token_table = $token_table;
		$this->user_id     = $user_id;
	}

	protected function getProviders():array {
		return $this->db->select
			->cached()
			->from([$this->token_table.'_providers'])
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
			$this->db->update->table($this->token_table)->set($values)->where('label', $this->getLabel($service))->execute();
		}
		else{
			$values['label'] = $this->getLabel($service);
			$this->db->insert->into($this->token_table)->values($values)->execute();
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

	/**
	 * @todo: WIP
	 */
	public function createTable(){

		$this->db->raw('DROP TABLE IF EXISTS '.$this->token_table);
		$this->db->create
			->table($this->token_table)
			->primaryKey('label')
			->varchar('label', 32, null, false)
			->int('user_id',10, null, false)
			->varchar('provider_id', 30, '', false)
			->text('token', null, true)
			->text('state')
			->int('expires',10, null, false)
			->execute();

		$this->db->raw('DROP TABLE IF EXISTS '.$this->token_table.'_providers');
		$this->db->create
			->table($this->token_table.'_providers')
			->primaryKey('provider_id')
			->tinyint('provider_id',10, null, false, 'UNSIGNED AUTO_INCREMENT')
			->varchar('servicename', 30, '', false)
			->execute();

		$providers = [
			['provider_id' => 1,  'servicename' => 'Spotify',],
			['provider_id' => 2,  'servicename' => 'LastFM',],
			['provider_id' => 3,  'servicename' => 'Discogs',],
			['provider_id' => 4,  'servicename' => 'Twitter',],
			['provider_id' => 5,  'servicename' => 'Instagram',],
			['provider_id' => 6,  'servicename' => 'Vimeo',],
			['provider_id' => 7,  'servicename' => 'MusicBrainz',],
			['provider_id' => 8,  'servicename' => 'SoundCloud',],
			['provider_id' => 9,  'servicename' => 'Twitch',],
			['provider_id' => 10, 'servicename' => 'GuildWars2',],
		];

		$this->db->insert->into($this->token_table.'_providers')->values($providers)->execute();

	}

}
