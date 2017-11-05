<?php
/**
 *
 * @filesource   TokenTest.php
 * @created      09.07.2017
 * @package      chillerlan\OAuthTest
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest;

use chillerlan\OAuth\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase{

	/**
	 * @var \chillerlan\OAuth\Token
	 */
	private $token;

	protected function setUp(){
		$this->token = new Token;
	}

	public function testInstance(){
		$this->assertInstanceOf(Token::class, $this->token);
	}

	public function tokenDataProvider(){
		return [
			['requestToken',       null, 'REQUEST_TOKEN'],
			['requestTokenSecret', null, 'REQUEST_TOKEN_SECRET'],
			['accessTokenSecret',  null, 'ACCESS_TOKEN'],
			['accessToken',        null, 'ACCESS_TOKEN_SECRET'],
			['refreshToken',       null, 'REFRESH_TOKEN'],
			['extraParams',        []  , ['foo' => 'bar']],
		];
	}

	/**
	 * @dataProvider tokenDataProvider
	 */
	public function testDefaultsGetSet($property, $value, $data){
		// test defaults
		$this->assertSame($value, $this->token->{$property});

		// set some data
		$this->token->{$property} = $data;

		$this->assertSame($data, $this->token->{$property});
	}

	public function expiryDataProvider(){
		return [
			[null,     Token::EOL_UNKNOWN],
			[-9002,    Token::EOL_NEVER_EXPIRES],
			[-9001,    Token::EOL_UNKNOWN],
			[-1, Token::EOL_UNKNOWN],
			[0, Token::EOL_NEVER_EXPIRES],
		];
	}

	/**
	 * @dataProvider expiryDataProvider
	 */
	public function testSetExpiry($expires, $expected){
		$this->token->expires = $expires;

		$this->assertSame($expected, $this->token->expires);
	}

	public function isExpiredDataProvider(){
		return [
			[0,                        false],
			[Token::EOL_NEVER_EXPIRES, false],
			[Token::EOL_UNKNOWN,       false],
		];
	}

	/**
	 * @dataProvider isExpiredDataProvider
	 */
	public function testIsExpired($expires, $isExpired){
		$this->token->setExpiry($expires);
		$this->assertSame($isExpired, $this->token->isExpired());
	}

	public function testIsExpiredVariable(){
		$now    = time();

		$expiry1 = time() + 3600;
		$this->token->setExpiry($expiry1);
		$this->assertSame($expiry1, $this->token->expires);

		$expiry2 = 3600;
		$this->token->setExpiry($expiry2);
		$this->assertSame($now+$expiry2, $this->token->expires);
	}

}
