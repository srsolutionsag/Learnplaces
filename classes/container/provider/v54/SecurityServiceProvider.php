<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider\v54;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\security\AccessGuard;
use SRAG\Learnplaces\service\security\AccessGuardImpl;
use SRAG\Learnplaces\service\visibility\LearnplaceServiceDecoratorFactory;

/**
 * Class SecurityServiceProvider
 *
 * Service provider for the security namespace SRAG\Learnplaces\service\security.
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class SecurityServiceProvider implements ServiceProviderInterface {

	public function register(Container $pimple) {
		$pimple[AccessGuard::class] = function($c) {return new AccessGuardImpl(
			$c[ServerRequestInterface::class],
			$c[LearnplaceService::class],
			$c[LearnplaceServiceDecoratorFactory::class],
			$c['ilAccess']
		);
		};
	}
}