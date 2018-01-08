<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use ilLearnplacesPlugin;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class PluginProvider
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PluginProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register(Container $pimple) {
		$pimple[ilLearnplacesPlugin::class] = function ($c) {return ilLearnplacesPlugin::getInstance(); };
	}
}