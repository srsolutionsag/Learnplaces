<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use Intervention\Image\ImageManager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
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
		$pimple[FileTypeDetector::class]    = function ($c) {return new WabmorganFileTypeDetector(); };
		$pimple[ImageManager::class]        = function ($c) {return new ImageManager(); };
		$pimple[PictureService::class]      = function ($c) {
			return new PictureServiceImpl($c['http']->request(), $c[PictureRepository::class], $c[ImageManager::class], $c[FileTypeDetector::class]);
		};
		$pimple[VideoService::class]        = function ($c) {return new VideoServiceImpl($c['http']->request(), $c[FileTypeDetector::class]); };
	}
}