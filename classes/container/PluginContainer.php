<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container;

use Pimple\ServiceProviderInterface;
use SRAG\Learnplaces\container\provider\BlockServiceProvider;
use SRAG\Learnplaces\container\provider\MediaServiceProvider;
use SRAG\Learnplaces\container\provider\RepositoryProvider;

/**
 * Class PluginContainer
 *
 * The plugin service container, which is responsible for the
 * bootstrap process of the underlying pimple container which is provided by ILIAS.
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PluginContainer {

	/**
	 * @var ServiceProviderInterface[] $provider
	 */
	private static $provider = [
		RepositoryProvider::class,
		MediaServiceProvider::class,
		BlockServiceProvider::class,

		//Add new service provider here
	];

	public static function bootstrap() {
		global $DIC;

		foreach (static::$provider as $providerClass) {
			$provider = new $providerClass();
			$DIC->register($provider);
		}
	}
}