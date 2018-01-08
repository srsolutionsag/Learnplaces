<?php

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\ExternalStreamBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class ExternalStreamBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ExternalStreamBlockRepositoryImpl implements ExternalStreamBlockRepository {

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
	public function store(ExternalStreamBlock $streamBlock) : ExternalStreamBlock {
		$storedBlock = ($streamBlock->getId() > 0) ? $this->update($streamBlock) : $this->create($streamBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(ExternalStreamBlock $streamBlock) : ExternalStreamBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($streamBlock);
		$block->create();
		$streamBlockEntity = $this->mapToEntity($streamBlock);
		$streamBlockEntity->setFkBlockId($block->getPkId());
		$streamBlockEntity->create();
		return $this->mapToDTO($block, $streamBlockEntity);
	}

	private function update(ExternalStreamBlock $streamBlock) : ExternalStreamBlock {
		$blockEntity = $this->mapToBlockEntity($streamBlock);
		$blockEntity->update();
		$streamBlockEntity = $this->mapToEntity($streamBlock);
		$streamBlockEntity->update();
		return $this->mapToDTO($blockEntity, $streamBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : ExternalStreamBlock {
		try {
			$block = Block::findOrFail($id);
			$streamBlock = \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock::where(['fk_block_id' => $id])->first();
			if(is_null($streamBlock))
				throw new EntityNotFoundException("External stream block with id \"$id\" was not found");

			return $this->mapToDTO($block, $streamBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("External stream block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$streamBlock = \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($streamBlock)){
				$streamBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("External stream block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$streamBlock = \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $streamBlock);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock $streamBlockEntity) : ExternalStreamBlock {

		$streamBlock = new ExternalStreamBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$streamBlock
			->setUrl($streamBlockEntity->getUrl())
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $streamBlock;

	}

	private function mapToEntity(ExternalStreamBlock $streamBlock) : \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock::where(['fk_block_id' => $streamBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\ExternalStreamBlock();
			$activeRecord->setFkBlockId($streamBlock->getId());
		}

		$activeRecord->setUrl($streamBlock->getUrl());

		return $activeRecord;
	}
}