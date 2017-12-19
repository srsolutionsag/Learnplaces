<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container;

use ILIAS\DI\Container;
use InvalidArgumentException;
use Pimple\ServiceProviderInterface;
use SRAG\Learnplaces\container\exception\DependencyResolutionException;
use SRAG\Learnplaces\container\provider\BlockServiceProvider;
use SRAG\Learnplaces\container\provider\GUIProvider;
use SRAG\Learnplaces\container\provider\HttpServiceProvider;
use SRAG\Learnplaces\container\provider\MediaServiceProvider;
use SRAG\Learnplaces\container\provider\PluginProvider;
use SRAG\Learnplaces\container\provider\RepositoryProvider;
use SRAG\Learnplaces\container\provider\ViewProvider;
use SRAG\Learnplaces\container\provider\VisibilityServiceProvider;

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
		PluginProvider::class,
		RepositoryProvider::class,
		MediaServiceProvider::class,
		BlockServiceProvider::class,
		GUIProvider::class,
		ViewProvider::class,
		VisibilityServiceProvider::class,
		HttpServiceProvider::class,

		//Add new service provider here
	];
	/**
	 * @var Container $container
	 */
	private static $container;


	/**
	 * Bootstraps the plugin dependency container, with all service providers.
	 * This method requires an registered autoloader and
	 * the already bootstrapped ILIAS DI container.
	 *
	 * @return void
	 */
	public static function bootstrap() {
		static::$container = $GLOBALS['DIC'];

		foreach (static::$provider as $providerClass) {
			$provider = new $providerClass();
			static::$container->register($provider);
		}
	}


	/**
	 * @param string $class
	 * @return object
	 */
	public static function resolve(string $class) {
		if(!static::$container->offsetExists($class))
			throw new DependencyResolutionException("The class \"$class\" was not found.");

		return static::$container[$class];
	}
}