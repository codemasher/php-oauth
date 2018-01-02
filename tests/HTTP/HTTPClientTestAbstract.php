<?php
/**
 * Class HTTPClientTestAbstract
 *
 * @filesource   HTTPClientTestAbstract.php
 * @created      21.10.2017
 * @package      chillerlan\OAuthTest\HTTP
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\HTTP;

use chillerlan\OAuth\HTTP\HTTPClientInterface;
use PHPUnit\Framework\TestCase;

abstract class HTTPClientTestAbstract extends TestCase{

	const CACERT     = __DIR__.'/../../config/cacert.pem';
	const USER_AGENT = 'chillerLAN-php-oauth-test';

	/**
	 * @var \chillerlan\OAuth\HTTP\HTTPClientInterface
	 */
	protected $http;

	public function testInstance(){
		$this->assertInstanceOf(HTTPClientInterface::class, $this->http);
	}

	public function headerDataProvider():array {
		return [
			[['content-Type' => 'application/x-www-form-urlencoded'], ['Content-type' => 'Content-type: application/x-www-form-urlencoded']],
			[['lowercasekey' => 'lowercasevalue'], ['Lowercasekey' => 'Lowercasekey: lowercasevalue']],
			[['UPPERCASEKEY' => 'UPPERCASEVALUE'], ['Uppercasekey' => 'Uppercasekey: UPPERCASEVALUE']],
			[['mIxEdCaSeKey' => 'MiXeDcAsEvAlUe'], ['Mixedcasekey' => 'Mixedcasekey: MiXeDcAsEvAlUe']],
			[['31i71casekey' => '31i71casevalue'], ['31i71casekey' => '31i71casekey: 31i71casevalue']],
			[[1 => 'numericvalue:1'], ['Numericvalue'  => 'Numericvalue: 1']],
			[[2 => 2], []],
			[['what'], []],
		];
	}

	/**
	 * @dataProvider headerDataProvider
	 *
	 * @param $header
	 * @param $normalized
	 */
	public function testNormalizeHeaders(array $header, array $normalized){
		$this->assertSame($normalized, $this->http->normalizeRequestHeaders($header));
	}

	public function requestDataProvider():array {
		return [
			['get',    []],
			['post',   []],
			['put',    []],
			['patch',  []],
			['delete', []],
		];
	}

	/**
	 * @dataProvider requestDataProvider
	 *
	 * @param $method
	 * @param $extra_headers
	 */
	public function testRequest(string $method, array $extra_headers){

		// @todo httpbin times out on a regular basis... a more reliable service, anyone?
		$r = null;

		try{
			$response = $this->http->request(
				'https://httpbin.org/'.$method,
				['foo' => 'bar'],
				$method,
				['huh' => 'wtf'],
				['what' => 'nope'] + $extra_headers
			);

			$r = $response->json;
		}
		catch(\Exception $e){
			$this->markTestSkipped('httpbin.org timeout... '.$e->getMessage());
		}

		if(!$r){
			$this->markTestSkipped('empty response');
		}
		else{
			$this->assertSame('https://httpbin.org/'.$method.'?foo=bar', $r->url);
			$this->assertSame('bar', $r->args->foo);
			$this->assertSame('nope', $r->headers->What);
			$this->assertSame(self::USER_AGENT, $r->headers->{'User-Agent'});

			if(in_array($method, ['patch', 'post', 'put'])){
				$this->assertSame('wtf', $r->form->huh);
			}
		}

	}

	/**
	 * @expectedException \chillerlan\OAuth\HTTP\HTTPClientException
	 * @expectedExceptionMessage invalid URL
	 */
	public function testInvalidURLException(){
		$this->http->request('');
	}

}
