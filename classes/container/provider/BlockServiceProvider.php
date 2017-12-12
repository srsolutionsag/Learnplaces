<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use League\Flysystem\FilesystemInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use SRAG\Learnplaces\persistence\repository\AccordionBlockRepository;
use SRAG\Learnplaces\persistence\repository\AnswerRepository;
use SRAG\Learnplaces\persistence\repository\AnswerRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\ConfigurationRepository;
use SRAG\Learnplaces\persistence\repository\ExternalStreamBlockRepository;
use SRAG\Learnplaces\persistence\repository\ILIASLinkBlockRepository;
use SRAG\Learnplaces\persistence\repository\LearnplaceRepository;
use SRAG\Learnplaces\persistence\repository\LocationRepository;
use SRAG\Learnplaces\persistence\repository\MapBlockRepository;
use SRAG\Learnplaces\persistence\repository\PictureBlockRepository;
use SRAG\Learnplaces\persistence\repository\PictureUploadBlockRepository;
use SRAG\Learnplaces\persistence\repository\RichTextBlockRepository;
use SRAG\Learnplaces\persistence\repository\VideoBlockRepository;
use SRAG\Learnplaces\persistence\repository\VisitJournalRepository;
use SRAG\Learnplaces\service\media\PictureService;
use SRAG\Learnplaces\service\media\VideoService;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\AnswerService;
use SRAG\Learnplaces\service\publicapi\block\CommentService;
use SRAG\Learnplaces\service\publicapi\block\CommentServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationService;
use SRAG\Learnplaces\service\publicapi\block\ConfigurationServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\ExternalStreamBlockService;
use SRAG\Learnplaces\service\publicapi\block\ExternalStreamBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\ILIASLinkBlockService;
use SRAG\Learnplaces\service\publicapi\block\ILIASLinkBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\LocationService;
use SRAG\Learnplaces\service\publicapi\block\LocationServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\MapBlockService;
use SRAG\Learnplaces\service\publicapi\block\MapBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\PictureBlockService;
use SRAG\Learnplaces\service\publicapi\block\PictureBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\PictureUploadBlockService;
use SRAG\Learnplaces\service\publicapi\block\PictureUploadBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\RichTextBlockService;
use SRAG\Learnplaces\service\publicapi\block\RichTextBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\util\BlockOperationDispatcher;
use SRAG\Learnplaces\service\publicapi\block\util\DefaultBlockOperationDispatcher;
use SRAG\Learnplaces\service\publicapi\block\VideoBlockService;
use SRAG\Learnplaces\service\publicapi\block\VideoBlockServiceImpl;
use SRAG\Learnplaces\service\publicapi\block\VisitJournalService;
use SRAG\Learnplaces\service\publicapi\block\VisitJournalServiceImpl;

/**
 * Class BlockServiceProvider
 *
 * Contains the wiring of the entire SRAG\Learnplaces\service\publicapi\block namespace.
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class BlockServiceProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register(Container $pimple) {
		$pimple[VisitJournalService::class]             = function ($c) {return new VisitJournalServiceImpl($c[VisitJournalRepository::class]); };
		$pimple[VideoBlockService::class]               = function ($c) {return new VideoBlockServiceImpl($c[VideoBlockRepository::class], $c[VideoService::class]); };
		$pimple[RichTextBlockService::class]            = function ($c) {return new RichTextBlockServiceImpl($c[RichTextBlockRepository::class]); };
		$pimple[PictureUploadBlockService::class]       = function ($c) {return new PictureUploadBlockServiceImpl($c[PictureUploadBlockRepository::class]); };
		$pimple[PictureBlockService::class]             = function ($c) {return new PictureBlockServiceImpl($c[PictureBlockRepository::class], $c[PictureService::class]); };
		$pimple[MapBlockService::class]                 = function ($c) {return new MapBlockServiceImpl($c[MapBlockRepository::class]); };
		$pimple[LocationService::class]                 = function ($c) {return new LocationServiceImpl($c[LocationRepository::class]); };
		$pimple[ILIASLinkBlockService::class]           = function ($c) {return new ILIASLinkBlockServiceImpl($c[ILIASLinkBlockRepository::class]); };
		$pimple[ExternalStreamBlockService::class]      = function ($c) {return new ExternalStreamBlockServiceImpl($c[ExternalStreamBlockRepository::class]); };
		$pimple[ConfigurationService::class]            = function ($c) {return new ConfigurationServiceImpl($c[ConfigurationRepository::class]); };
		$pimple[CommentService::class]                  = function ($c) {return new CommentServiceImpl($c[ConfigurationRepository::class]); };
		$pimple[AnswerService::class]                   = function ($c) {return new AnswerRepositoryImpl($c[AnswerRepository::class]); };
		$pimple[AccordionBlockService::class]           = function ($c) {return new AccordionBlockServiceImpl($c[AccordionBlockRepository::class]); };
		$pimple[BlockOperationDispatcher::class]        = function ($c) {return new DefaultBlockOperationDispatcher(
																					$c[AccordionBlockService::class],
																					$c[ILIASLinkBlockService::class],
																					$c[PictureBlockService::class],
																					$c[PictureUploadBlockService::class],
																					$c[MapBlockService::class],
																					$c[RichTextBlockService::class]
																					);
																				};
		$pimple[LearnplaceService::class]               = function ($c) {return new LearnplaceServiceImpl(
																					$c[ConfigurationService::class],
																					$c[LocationService::class],
																					$c[VisitJournalService::class],
																					$c[LearnplaceRepository::class],
																					$c[BlockOperationDispatcher::class],
																					$c[PictureService::class]
																					);
																				};
	}
}