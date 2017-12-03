<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use LogicException;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\LearnplaceRepository;
use SRAG\Learnplaces\service\media\PictureService;
use SRAG\Learnplaces\service\publicapi\block\util\BlockOperationDispatcher;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;


/**
 * Class LearnplaceServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceServiceImpl  implements LearnplaceService {

	/**
	 * @var ConfigurationService $configService
	 */
	private $configService;
	/**
	 * @var LocationService $locationService
	 */
	private $locationService;
	/**
	 * @var VisitJournalService $visitJournalService
	 */
	private $visitJournalService;
	/**
	 * @var LearnplaceRepository $learnplaceRepository
	 */
	private $learnplaceRepository;
	/**
	 * @var BlockOperationDispatcher $blockOperationDispatcher
	 */
	private $blockOperationDispatcher;
	/**
	 * @var PictureService $pictureService
	 */
	private $pictureService;


	/**
	 * LearnplaceServiceImpl constructor.
	 *
	 * @param ConfigurationService     $configService
	 * @param LocationService          $locationService
	 * @param VisitJournalService      $visitJournalService
	 * @param LearnplaceRepository     $learnplaceRepository
	 * @param BlockOperationDispatcher $blockOperationDispatcher
	 * @param PictureService           $pictureService
	 */
	public function __construct(ConfigurationService $configService, LocationService $locationService, VisitJournalService $visitJournalService, LearnplaceRepository $learnplaceRepository, BlockOperationDispatcher $blockOperationDispatcher, PictureService $pictureService) {
		$this->configService = $configService;
		$this->locationService = $locationService;
		$this->visitJournalService = $visitJournalService;
		$this->learnplaceRepository = $learnplaceRepository;
		$this->blockOperationDispatcher = $blockOperationDispatcher;
		$this->pictureService = $pictureService;
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$learnplace = $this->learnplaceRepository->find($id);
			$this->blockOperationDispatcher->deleteAll($learnplace->getBlocks());
			$this->configService->delete($learnplace->getConfiguration()->getId());
			$this->locationService->delete($learnplace->getId());
			foreach ($learnplace->getVisitJournals() as $visit)
				$this->visitJournalService->delete($visit->getId());
			foreach ($learnplace->getPictures() as $picture)
				$this->pictureService->delete($picture->getId());
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('Learnplace could not been deleted because the leanplace or one of its children do not exists.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function findByObjectId(int $objectId): LearnplaceModel {
		try {
			$dto = $this->learnplaceRepository->findByObjectId($objectId);
			return $this->filterBlocksWhichBelongToAccordions($dto->toModel());
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException("The leanplace could not been found, reason the given object id \"$objectId\" was not found.", 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function store(LearnplaceModel $learnplaceModel): LearnplaceModel {
		try {
			$model = $this->learnplaceRepository->store($learnplaceModel->toDto());
			return $model->toModel();
		}
		catch(EntityNotFoundException $ex) {
			throw new LogicException('Could not store learnplace because at least one of the children is not persistent.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): LearnplaceModel {
		try {
			$dto = $this->learnplaceRepository->find($id);
			return $this->filterBlocksWhichBelongToAccordions($dto->toModel());
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException("The leanplace could not been found, reason the given id \"$id\" was not found.", 0, $ex);
		}
	}


	private function filterBlocksWhichBelongToAccordions(LearnplaceModel $learnplace): LearnplaceModel {
		$filteredBlocks = $learnplace->getBlocks();
		foreach ($learnplace->getBlocks() as $block) {
			if($block instanceof AccordionBlockModel) {
				$excludedBlocks = $block->getBlocks();
				$filteredBlocks = array_udiff(
					$filteredBlocks,
					$excludedBlocks,
					function(BlockModel $block1, BlockModel $block2): int {
						return $block1->getId() - $block2->getId();
					});
			}
		}
		$learnplace->setBlocks($filteredBlocks);
		return $learnplace;
	}


}