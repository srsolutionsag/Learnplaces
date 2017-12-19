<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\security\BlockAccessGuard;
use SRAG\Learnplaces\service\security\BlockAccessGuardImpl;

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
		$pimple[BlockAccessGuard::class] = function($c) {return new BlockAccessGuardImpl(
			$c[ServerRequestInterface::class],
			$c[LearnplaceService::class]
		);
		};
	}
}