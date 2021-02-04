<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider\v6;

use ilLearnplacesPlugin;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\gui\block\BlockAddFormGUI;
use SRAG\Learnplaces\gui\block\RenderableBlockViewFactory;
use SRAG\Learnplaces\gui\block\RenderableBlockViewFactoryImpl;
use SRAG\Learnplaces\service\media\PictureService;
use SRAG\Learnplaces\service\media\VideoService;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\ILIASLinkBlockService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\LocationService;
use SRAG\Learnplaces\service\publicapi\block\MapBlockService;
use SRAG\Learnplaces\service\publicapi\block\PictureBlockService;
use SRAG\Learnplaces\service\publicapi\block\PictureUploadBlockService;
use SRAG\Learnplaces\service\publicapi\block\RichTextBlockService;
use SRAG\Learnplaces\service\publicapi\block\VideoBlockService;
use SRAG\Learnplaces\service\security\AccessGuard;
use SRAG\Learnplaces\service\visibility\LearnplaceServiceDecoratorFactory;
use xsrlAccordionBlockGUI;
use xsrlContentGUI;
use xsrlIliasLinkBlockGUI;
use xsrlMapBlockGUI;
use xsrlPictureBlockGUI;
use xsrlPictureUploadBlockGUI;
use xsrlRichTextBlockGUI;
use xsrlSettingGUI;
use xsrlVideoBlockGUI;

/**
 * Class GUIProvider
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class GUIProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register(Container $pimple) {
		$pimple[RenderableBlockViewFactory::class] = function ($c) {return new RenderableBlockViewFactoryImpl(); };

		$pimple[xsrlContentGUI::class] = function ($c) {return new xsrlContentGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[RenderableBlockViewFactory::class],
			$c[LearnplaceService::class],
			$c[AccordionBlockService::class],
			$c[LearnplaceServiceDecoratorFactory::class],
			$c[BlockAddFormGUI::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
			);
		};

		$pimple[xsrlPictureUploadBlockGUI::class] = function ($c) {return new xsrlPictureUploadBlockGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[PictureUploadBlockService::class],
			$c[LearnplaceService::class],
			$c[ConfigurationService::class],
			$c[AccordionBlockService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};

		$pimple[xsrlPictureBlockGUI::class] = function ($c) {return new xsrlPictureBlockGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[PictureService::class],
			$c[PictureBlockService::class],
			$c[LearnplaceService::class],
			$c[ConfigurationService::class],
			$c[AccordionBlockService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};

		$pimple[xsrlRichTextBlockGUI::class] = function ($c) {return new xsrlRichTextBlockGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[RichTextBlockService::class],
			$c[LearnplaceService::class],
			$c[ConfigurationService::class],
			$c[AccordionBlockService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};

		$pimple[xsrlIliasLinkBlockGUI::class] = function ($c) {return new xsrlIliasLinkBlockGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[ILIASLinkBlockService::class],
			$c[LearnplaceService::class],
			$c[ConfigurationService::class],
			$c[AccordionBlockService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};

		$pimple[xsrlMapBlockGUI::class] = function ($c) {return new xsrlMapBlockGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[MapBlockService::class],
			$c[LearnplaceService::class],
			$c[ConfigurationService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};

		$pimple[xsrlVideoBlockGUI::class] = function ($c) {return new xsrlVideoBlockGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[VideoBlockService::class],
			$c[VideoService::class],
			$c[LearnplaceService::class],
			$c[ConfigurationService::class],
			$c[AccordionBlockService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};

		$pimple[xsrlAccordionBlockGUI::class] = function ($c) {return new xsrlAccordionBlockGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[AccordionBlockService::class],
			$c[LearnplaceService::class],
			$c[ConfigurationService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};

		$pimple[xsrlSettingGUI::class] = function ($c) {return new xsrlSettingGUI(
            $c->tabs(),
            $c->ui()->mainTemplate(),
            $c->ctrl(),
			$c[ilLearnplacesPlugin::class],
			$c[ConfigurationService::class],
			$c[LocationService::class],
			$c[LearnplaceService::class],
			$c[ServerRequestInterface::class],
			$c[AccessGuard::class]
		);
		};
	}
}