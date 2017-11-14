<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use SRAG\Learnplaces\persistence\dto\FeedbackBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class FeedbackBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class FeedbackBlockRepositoryImpl implements FeedbackBlockRepository {

	use BlockMappingAware, BlockConstraintAware;

	/**
	 * @var LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	private $learnplaceConstraintRepository;


	/**
	 * ExternalStreamBlockRepositoryImpl constructor.
	 *
	 * @param LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	public function __construct(LearnplaceConstraintRepository $learnplaceConstraintRepository) { $this->learnplaceConstraintRepository = $learnplaceConstraintRepository; }

	/**
	 * @inheritdoc
	 */
	public function store(FeedbackBlock $feedbackBlock) : FeedbackBlock {
		$storedBlock = ($feedbackBlock->getId() > 0) ? $this->update($feedbackBlock) : $this->create($feedbackBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(FeedbackBlock $feedbackBlock) : FeedbackBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($feedbackBlock);
		$block->create();
		$feedbackBlockEntity = $this->mapToEntity($feedbackBlock);
		$feedbackBlockEntity->setFkBlockId($block->getPkId());
		$feedbackBlockEntity->create();
		return $this->mapToDTO($block, $feedbackBlockEntity);
	}

	private function update(FeedbackBlock $feedbackBlock) : FeedbackBlock {
		$blockEntity = $this->mapToBlockEntity($feedbackBlock);
		$blockEntity->update();
		$feedbackBlockEntity = $this->mapToEntity($feedbackBlock);
		$feedbackBlockEntity->update();
		return $this->mapToDTO($blockEntity, $feedbackBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : FeedbackBlock {
		try {
			$block = Block::findOrFail($id);
			$feedbackBlock = \SRAG\Learnplaces\persistence\entity\FeedbackBlock::where(['fk_block_id' => $id])->first();
			return $this->mapToDTO($block, $feedbackBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Feedback block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$feedbackBlock = \SRAG\Learnplaces\persistence\entity\FeedbackBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($feedbackBlock)){
				$feedbackBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Feedback block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\FeedbackBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$feedbackBlock = \SRAG\Learnplaces\persistence\entity\FeedbackBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $feedbackBlock);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\FeedbackBlock $feedbackBlockEntity) : FeedbackBlock {

		$feedbackBlock = new FeedbackBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$feedbackBlock
			->setContent($feedbackBlockEntity->getContent())
			->setUserId($feedbackBlockEntity->getFkIluserId())
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $feedbackBlock;

	}

	private function mapToEntity(FeedbackBlock $feedbackBlock) : \SRAG\Learnplaces\persistence\entity\FeedbackBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\FeedbackBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\FeedbackBlock::where(['fk_block_id' => $feedbackBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\FeedbackBlock();
			$activeRecord->setFkBlockId($feedbackBlock->getId());
		}

		$activeRecord->setContent($feedbackBlock->getContent());
		$activeRecord->setFkIluserId($feedbackBlock->getUserId());

		return $activeRecord;
	}
	
}