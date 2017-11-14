<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\HorizontalLineBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class HorizontalLineBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class HorizontalLineBlockRepositoryImpl implements HorizontalLineBlockRepository {

	use BlockMappingAware, BlockConstraintAware;

	/**
	 * @var LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	private $learnplaceConstraintRepository;

	/**
	 * Constructor.
	 *
	 * @param LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	public function __construct(LearnplaceConstraintRepository $learnplaceConstraintRepository) { $this->learnplaceConstraintRepository = $learnplaceConstraintRepository; }

	/**
	 * @inheritdoc
	 */
	public function store(HorizontalLineBlock $lineBlock) : HorizontalLineBlock {
		$storedBlock = ($lineBlock->getId() > 0) ? $this->update($lineBlock) : $this->create($lineBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(HorizontalLineBlock $lineBlock) : HorizontalLineBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($lineBlock);
		$block->create();
		$lineBlockEntity = $this->mapToEntity($lineBlock);
		$lineBlockEntity->setFkBlockId($block->getPkId());
		$lineBlockEntity->create();
		return $this->mapToDTO($block);
	}

	private function update(HorizontalLineBlock $lineBlock) : HorizontalLineBlock {
		$blockEntity = $this->mapToBlockEntity($lineBlock);
		$blockEntity->update();
		$lineBlockEntity = $this->mapToEntity($lineBlock);
		$lineBlockEntity->update();
		return $this->mapToDTO($blockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : HorizontalLineBlock {
		try {
			$block = Block::findOrFail($id);
			return $this->mapToDTO($block);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Horizontal line block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$uploadBlock = \SRAG\Learnplaces\persistence\entity\HorizontalLineBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($uploadBlock)){
				$uploadBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Horizontal line block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\HorizontalLineBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$mappedBlocks[] = $this->mapToDTO($block);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block) : HorizontalLineBlock {

		$lineBlock = new HorizontalLineBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$lineBlock
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $lineBlock;

	}

	private function mapToEntity(HorizontalLineBlock $lineBlock) : \SRAG\Learnplaces\persistence\entity\HorizontalLineBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\HorizontalLineBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\HorizontalLineBlock::where(['fk_block_id' => $lineBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\HorizontalLineBlock();
			$activeRecord->setFkBlockId($lineBlock->getId());
		}

		return $activeRecord;
	}
}