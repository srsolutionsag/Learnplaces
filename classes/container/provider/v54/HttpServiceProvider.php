<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider\v54;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;

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
		    return $c['http']->request();
		};
	}
}