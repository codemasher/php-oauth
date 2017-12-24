<?php
/**
 * Class TestRouter
 *
 * @filesource   TestRouter.php
 * @created      03.11.2017
 * @package      chillerlan\OAuthTest\Request
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuthTest\Request;

use chillerlan\OAuthTest\Providers\ProviderTestAbstract;

use FastRoute\{
	DataGenerator\GroupCountBased as GeneratorGCB,
	Dispatcher\GroupCountBased as DispatcherGCB,
	RouteCollector,
	RouteParser\Std
};

class TestRouter{

	/**
	 * @var \FastRoute\Dispatcher
	 */
	protected $dispatcher;

	/**
	 * @var \FastRoute\RouteCollector
	 */
	protected $collector;

	public function __construct(array $routes = null){

		$this->collector = new RouteCollector(new Std, new GeneratorGCB);

		if(is_array($routes)){
			$this->addRoutes($routes);
		}

		$this->dispatcher = new DispatcherGCB($this->collector->getData());
	}

	public function addRoutes(array $routes):TestRouter{

		foreach($routes as $route){
			$this->collector->addRoute($route[0], ProviderTestAbstract::BASE_PATH.$route[1], $route[2]);
		}

		return $this;
	}

	public function dispatch($method, $url):array {
		return $this->dispatcher->dispatch($method, rawurldecode($url));
	}

}
