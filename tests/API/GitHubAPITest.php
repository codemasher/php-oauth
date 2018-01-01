<?php
/**
 * Class GitHubAPITest
 *
 * @filesource   GitHubAPITest.php
 * @created      18.07.2017
 * @package      chillerlan\OAuthTest\API
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\API;

use chillerlan\OAuth\Providers\GitHub;

/**
 * @property  \chillerlan\OAuth\Providers\GitHub $provider
 */
class GitHubAPITest extends APITestAbstract{

	const USER = '<GITHUB_USERNAME>'; // @todo: change this to your username

	protected $FQCN   = GitHub::class;
	protected $envvar = 'GITHUB';

	public function testLogin(){
		$this->assertSame(self::USER, $this->provider->me()->json->login);
	}

}
