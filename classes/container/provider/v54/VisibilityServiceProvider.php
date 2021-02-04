<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider\v54;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use SRAG\Learnplaces\service\visibility\LearnplaceServiceDecoratorFactory;
use SRAG\Learnplaces\service\visibility\LearnplaceServiceDecoratorFactoryImpl;

/**
 * Class VisibilityServiceProvider
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class VisibilityServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register(Container $pimple) {
		$pimple[LearnplaceServiceDecoratorFactory::class] = function ($c) {return new LearnplaceServiceDecoratorFactoryImpl($c['ilUser']);};
	}
}