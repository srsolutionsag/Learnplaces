<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class HttpServiceProvider
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class HttpServiceProvider implements ServiceProviderInterface {

	public function register(Container $pimple) {
		$pimple[ServerRequestInterface::class] = function(Container $c): ServerRequestInterface {
			if($c->offsetExists('http'))
				return $c['http']->request(); //use ilias 5.3 http service

			//use Zend Diactoros
			return ServerRequestFactory::fromGlobals($_SERVER,
				$_GET,
				$_POST,
				$_COOKIE,
				$_FILES
			);
		};
	}
}