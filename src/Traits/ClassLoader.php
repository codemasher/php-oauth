<?php
/**
 * Trait ClassLoader
 *
 * @filesource   ClassLoader.php
 * @created      09.07.2017
 * @package      chillerlan\OAuth\Traits
 * @author       Smiley <smiley@chillerlan.net>
 * @copyright    2017 Smiley
 * @license      MIT
 */

namespace chillerlan\OAuth\Traits;

use chillerlan\OAuth\OAuthException;
use Exception, ReflectionClass;

trait ClassLoader{

	/**
	 * A simple class loader
	 *
	 * @param string $class  class FQCN
	 * @param string $type   type/interface FQCN
	 *
	 * @param mixed $params [optional] the following arguments are optional and
	 *                      will be passed to the class constructor if present.
	 *
	 * @return mixed of type $type
	 * @throws \chillerlan\OAuth\OAuthException
	 */
	public function loadClass(string $class, string $type, ...$params){

		try{

			if(!class_exists($class)){
				trigger_error($class.' does not exist');
			}

			$reflectionClass = new ReflectionClass($class);

			if(!$reflectionClass->implementsInterface($type) || !$reflectionClass->isSubclassOf($type)) {
				trigger_error($class.' does not implement or inherit '.$type);
			}

			$object = $reflectionClass->newInstanceArgs($params);

			return $object;
		}
		catch(Exception $e){
			throw new OAuthException($e->getMessage());
		}

	}

}
