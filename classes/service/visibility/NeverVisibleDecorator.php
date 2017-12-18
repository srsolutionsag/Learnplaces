<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\visibility;

use Generator;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;
use SRAG\Learnplaces\util\Visibility;
use function iterator_to_array;

/**
 * Class NeverVisibleDecorator
 *
 * Filters all blocks which are never visible.
 *
 * @package SRAG\Learnplaces\service\visibility
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @see Visibility::NEVER           Only user with write rights see this blocks.
 * @see Visibility::ONLY_AT_PLACE   The user can not be at place while using the ILIAS web ui.
 *
 * @internal
 */
final class NeverVisibleDecorator implements LearnplaceServiceDecorator {

	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;


	/**
	 * NeverVisibleDecorator constructor.
	 *
	 * @param LearnplaceService $learnplaceService
	 */
	public function __construct(LearnplaceService $learnplaceService) { $this->learnplaceService = $learnplaceService; }


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		$this->learnplaceService->delete($id);
	}


	/**
	 * @inheritDoc
	 */
	public function findByObjectId(int $objectId): LearnplaceModel {
		$learnplace = $this->learnplaceService->findByObjectId($objectId);
		$blocks = $this->filterNeverVisibleBlocks($learnplace->getBlocks());
		$learnplace->setBlocks(iterator_to_array($blocks));
		return $learnplace;
	}


	/**
	 * Filters all blocks which contain the NEVER or ONLY_AT_PLACE visibility.
	 *
	 * @param BlockModel[] $blocks The blocks which should be filtered.
	 *
	 * @return Generator The filtered blocks.
	 *
	 * @see Visibility::NEVER
	 * @see Visibility::ONLY_AT_PLACE
	 */
	private function filterNeverVisibleBlocks(array $blocks): Generator {
		foreach ($blocks as $block) {

			if($block instanceof AccordionBlockModel) {
				$accordionBlocks = $this->filterNeverVisibleBlocks($block->getBlocks());
				$block->setBlocks(iterator_to_array($accordionBlocks));
			}

			if($this->isVisible($block))
				yield $block;
		}
		return;
	}

	private function isVisible(BlockModel $block): bool {
		return  strcmp($block->getVisibility(), Visibility::NEVER) !== 0
				&&
				strcmp($block->getVisibility(), Visibility::ONLY_AT_PLACE) !== 0;
	}


	/**
	 * @inheritDoc
	 */
	public function store(LearnplaceModel $learnplaceModel): LearnplaceModel {
		$learnplace = $this->learnplaceService->store($learnplaceModel);
		$blocks = $this->filterNeverVisibleBlocks($learnplace->getBlocks());
		$learnplace->setBlocks(iterator_to_array($blocks));
		return $learnplace;
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): LearnplaceModel {
		$learnplace = $this->learnplaceService->find($id);
		$blocks = $this->filterNeverVisibleBlocks($learnplace->getBlocks());
		$learnplace->setBlocks(iterator_to_array($blocks));
		return $learnplace;
	}
}