<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use ilCtrl;
use ilLearnplacesPlugin;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use SRAG\Learnplaces\gui\block\PictureBlock\PictureBlockPresentationView;
use SRAG\Learnplaces\gui\block\PictureUploadBlock\PictureUploadBlockPresentationView;

/**
 * Class ViewProvider
 *
 * Provides factories for the view components
 * because they have some dependencies to ilCtrl and the ilLanguage usw.
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class ViewProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register(Container $pimple) {
		$pimple[PictureUploadBlockPresentationView::class] = $pimple->factory(function ($c) {
			return new PictureUploadBlockPresentationView(
				$c[ilLearnplacesPlugin::class],
				$c[ilCtrl::class]
			);
		});

		$pimple[PictureBlockPresentationView::class] = $pimple->factory(function ($c) {
			return new PictureBlockPresentationView(
				$c[ilLearnplacesPlugin::class],
				$c[ilCtrl::class]
			);
		});
	}
}