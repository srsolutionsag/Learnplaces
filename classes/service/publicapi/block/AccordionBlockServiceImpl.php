<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\AccordionBlockRepository;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\service\publicapi\block\util\BlockOperationDispatcher;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;

/**
 * Class AccordionBlockServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class AccordionBlockServiceImpl implements AccordionBlockService {

	/**
	 * @var AccordionBlockRepository $accordionBlockRepository
	 */
	private $accordionBlockRepository;
	/**
	 * @var BlockOperationDispatcher $blockOperationDispatcher
	 */
	private $blockOperationDispatcher;


	/**
	 * AccordionBlockServiceImpl constructor.
	 *
	 * @param AccordionBlockRepository $accordionBlockRepository
	 */
	public function __construct(AccordionBlockRepository $accordionBlockRepository) {
		$this->accordionBlockRepository = $accordionBlockRepository;
	}


	/**
	 * Post construct to break the circular dependency between the block operation dispatcher and the accordion service.
	 * This method must only be called by the DIC.
	 *
	 * @param BlockOperationDispatcher $blockOperationDispatcher
	 */
	public function postConstruct(BlockOperationDispatcher $blockOperationDispatcher) {
		$this->blockOperationDispatcher = $blockOperationDispatcher;
	}


	/**
	 * @inheritDoc
	 */
	public function store(AccordionBlockModel $blockModel): AccordionBlockModel {
		$blockModel->setBlocks($this->regenerateSequence($blockModel->getBlocks()));
		$dto = $this->accordionBlockRepository->store($blockModel->toDto());
		return $dto->toModel();
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $id) {
		try {
			$accordion = $this->accordionBlockRepository->findByBlockId($id);
			$this->accordionBlockRepository->delete($id);
			$this->blockOperationDispatcher->deleteAll($accordion->toModel()->getBlocks());
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The accordion block with the given id could not be deleted, because the block was not found.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $id): AccordionBlockModel {
		try {
			$dto = $this->accordionBlockRepository->findByBlockId($id);
			$model = $dto->toModel();
			$model->setBlocks($this->sortBySequence($model->getBlocks()));
			return $model;
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('The accordion block with the given id does not exist.', 0, $ex);
		}
	}

	/**
	 * Sorts block models by sequence id.
	 *
	 * @param BlockModel[] $blocks  Unsorted block model list.
	 *
	 * @return BlockModel[]         Sorted block model list.
	 */
	private function sortBySequence(array $blocks): array {
		$sorted = $blocks;
		usort($sorted, function (BlockModel $i, BlockModel $y) {
			return ($i->getSequence() > $y->getSequence()) ? 1 : -1;
		});

		return $sorted;
	}


	/**
	 * Regenerate the sequence numbers of the block in the current order.
	 *
	 * @param BlockModel[] $blocks  List of blocks with possible inconsistent sequence numbers.
	 *
	 * @return BlockModel[]         Blocks with regenerated sequence numbers.
	 */
	private function regenerateSequence(array $blocks): array {
		$regenerated = [];
		foreach ($blocks as $key => $block) {
			$block->setSequence($key + 1);
			$regenerated[] = $block;
		}

		return $regenerated;
	}
}