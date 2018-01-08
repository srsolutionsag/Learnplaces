<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\container\provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use SRAG\Learnplaces\persistence\dto\LearnplaceConstraint;
use SRAG\Learnplaces\persistence\repository\AccordionBlockRepository;
use SRAG\Learnplaces\persistence\repository\AccordionBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\AnswerRepository;
use SRAG\Learnplaces\persistence\repository\AnswerRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\AudioBlockRepository;
use SRAG\Learnplaces\persistence\repository\AudioBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\CommentBlockRepository;
use SRAG\Learnplaces\persistence\repository\CommentBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\CommentRepository;
use SRAG\Learnplaces\persistence\repository\CommentRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\ConfigurationRepository;
use SRAG\Learnplaces\persistence\repository\ConfigurationRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\ExternalStreamBlockRepository;
use SRAG\Learnplaces\persistence\repository\ExternalStreamBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\FeedbackBlockRepository;
use SRAG\Learnplaces\persistence\repository\FeedbackBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\FeedbackRepository;
use SRAG\Learnplaces\persistence\repository\FeedbackRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\HorizontalLineBlockRepository;
use SRAG\Learnplaces\persistence\repository\HorizontalLineBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\ILIASLinkBlockRepository;
use SRAG\Learnplaces\persistence\repository\ILIASLinkBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\LearnplaceConstraintRepository;
use SRAG\Learnplaces\persistence\repository\LearnplaceRepository;
use SRAG\Learnplaces\persistence\repository\LearnplaceRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\LocationRepository;
use SRAG\Learnplaces\persistence\repository\LocationRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\MapBlockRepository;
use SRAG\Learnplaces\persistence\repository\MapBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\PictureBlockRepository;
use SRAG\Learnplaces\persistence\repository\PictureBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\PictureRepository;
use SRAG\Learnplaces\persistence\repository\PictureRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\PictureUploadBlockRepository;
use SRAG\Learnplaces\persistence\repository\PictureUploadBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\RichTextBlockRepository;
use SRAG\Learnplaces\persistence\repository\RichTextBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\util\BlockAccumulator;
use SRAG\Learnplaces\persistence\repository\util\BlockAccumulatorImpl;
use SRAG\Learnplaces\persistence\repository\VideoBlockRepository;
use SRAG\Learnplaces\persistence\repository\VideoBlockRepositoryImpl;
use SRAG\Learnplaces\persistence\repository\VisitJournalRepository;
use SRAG\Learnplaces\persistence\repository\VisitJournalRepositoryImpl;

/**
 * Class RepositoryProvider
 *
 * Contains the wiring of the entire SRAG\Lernplaces\persistence\repository namespace.
 *
 * @package SRAG\Learnplaces\container\provider
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class RepositoryProvider implements ServiceProviderInterface {

	/**
	 * @inheritDoc
	 */
	public function register(Container $pimple) {
		$pimple[VisitJournalRepository::class]  = function ($c) {return new VisitJournalRepositoryImpl(); };
		$pimple[ConfigurationRepository::class] = function ($c) {return new ConfigurationRepositoryImpl(); };
		$pimple[LocationRepository::class]      = function ($c) {return new LocationRepositoryImpl(); };

		$pimple[LearnplaceConstraintRepository::class] = function ($c) {return new class() implements LearnplaceConstraintRepository {

			/**
			 * @inheritDoc
			 */
			public function store(LearnplaceConstraint $constraint): LearnplaceConstraint {
				throw new \Exception('Not implemented yet!');
			}


			/**
			 * @inheritDoc
			 */
			public function findByBlockId(int $id): LearnplaceConstraint {
				throw new \Exception('Not implemented yet!');
			}


			/**
			 * @inheritDoc
			 */
			public function delete(int $id) {
				throw new \Exception('Not implemented yet!');
			}
		};};

		$pimple[VideoBlockRepository::class]            = function ($c) {return new VideoBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[RichTextBlockRepository::class]         = function ($c) {return new RichTextBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[PictureUploadBlockRepository::class]    = function ($c) {return new PictureUploadBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[PictureRepository::class]               = function ($c) {return new PictureRepositoryImpl(); };
		$pimple[PictureBlockRepository::class]          = function ($c) {return new PictureBlockRepositoryImpl($c[LearnplaceConstraintRepository::class], $c[PictureRepository::class]); };
		$pimple[MapBlockRepository::class]              = function ($c) {return new MapBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[ILIASLinkBlockRepository::class]        = function ($c) {return new ILIASLinkBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[HorizontalLineBlockRepository::class]   = function ($c) {return new HorizontalLineBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[FeedbackRepository::class]              = function ($c) {return new FeedbackRepositoryImpl(); };
		$pimple[FeedbackBlockRepository::class]         = function ($c) {return new FeedbackBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[ExternalStreamBlockRepository::class]   = function ($c) {return new ExternalStreamBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[AnswerRepository::class]                = function ($c) {return new AnswerRepositoryImpl($c[PictureRepository::class]); };
		$pimple[CommentRepository::class]               = function ($c) {return new CommentRepositoryImpl($c[PictureRepository::class], $c[AnswerRepository::class]); };
		$pimple[CommentBlockRepository::class]          = function ($c) {return new CommentBlockRepositoryImpl($c[LearnplaceConstraintRepository::class], $c[CommentRepository::class]); };
		$pimple[AudioBlockRepository::class]            = function ($c) {return new AudioBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]); };
		$pimple[BlockAccumulator::class]                = function ($c) {

			/**
			 * @var AccordionBlockRepositoryImpl $accordion
			 */
			$accordion = $c[AccordionBlockRepository::class];
			$accumulator = new BlockAccumulatorImpl(
			$c[PictureUploadBlockRepository::class],
			$c[ILIASLinkBlockRepository::class],
			$c[AudioBlockRepository::class],
			$c[HorizontalLineBlockRepository::class],
			$c[MapBlockRepository::class],
			$c[CommentBlockRepository::class],
			$c[VideoBlockRepository::class],
			$c[RichTextBlockRepository::class],
			$c[PictureBlockRepository::class],
			$c[ExternalStreamBlockRepository::class],
			$c[FeedbackBlockRepository::class],
			$accordion
			);

			$accordion->postConstruct($accumulator);
			return $accumulator;
		};

		$pimple[AccordionBlockRepository::class]        = function ($c) {return new AccordionBlockRepositoryImpl($c[LearnplaceConstraintRepository::class]);};
		$pimple[LearnplaceRepository::class]            = function ($c) {return new LearnplaceRepositoryImpl(
																					$c[LocationRepository::class],
																					$c[VisitJournalRepository::class],
																					$c[ConfigurationRepository::class],
																					$c[FeedbackRepository::class],
																					$c[PictureRepository::class],
																					$c[BlockAccumulator::class]
																				);

																		};
	}
}