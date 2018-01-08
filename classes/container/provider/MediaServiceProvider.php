<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use const ILIAS_ABSOLUTE_PATH;
use Intervention\Image\ImageManager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\persistence\repository\PictureRepository;
use SRAG\Learnplaces\service\media\PictureService;
use SRAG\Learnplaces\service\media\PictureServiceImpl;
use SRAG\Learnplaces\service\media\VideoService;
use SRAG\Learnplaces\service\media\VideoServiceImpl;
use SRAG\Learnplaces\service\media\wrapper\FileTypeDetector;
use SRAG\Learnplaces\service\media\wrapper\WabmorganFileTypeDetector;

/**
 * Class MediaServiceProvider
 *
 * Contains the wiring of the entire SRAG\Learnplaces\service\media namespace.
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class MediaServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register(Container $pimple) {
		$pimple[FilesystemInterface::class] = function ($c) {return new Filesystem(new Local(ILIAS_ABSOLUTE_PATH)); };
		$pimple[FileTypeDetector::class]    = function ($c) {return new WabmorganFileTypeDetector(); };
		$pimple[ImageManager::class]        = function ($c) {return new ImageManager(); };
		$pimple[PictureService::class]      = function ($c) {
			return new PictureServiceImpl(
				$c[ServerRequestInterface::class],
				$c[PictureRepository::class],
				$c[ImageManager::class],
				$c[FileTypeDetector::class],
				$c[FilesystemInterface::class]
			);
		};
		$pimple[VideoService::class]        = function ($c) {return new VideoServiceImpl(
				$c[ServerRequestInterface::class],
				$c[FileTypeDetector::class],
				$c[FilesystemInterface::class]
			);
		};
	}
}