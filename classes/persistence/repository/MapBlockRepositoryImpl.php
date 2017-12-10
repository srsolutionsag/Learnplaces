<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\MapBlock;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class MapBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class MapBlockRepositoryImpl implements MapBlockRepository {

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
	public function store(MapBlock $mapBlock) : MapBlock {
		$storedBlock = ($mapBlock->getId() > 0) ? $this->update($mapBlock) : $this->create($mapBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(MapBlock $mapBlock) : MapBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($mapBlock);
		$block->create();
		$mapBlockEntity = $this->mapToEntity($mapBlock);
		$mapBlockEntity->setFkBlockId($block->getPkId());
		$mapBlockEntity->create();
		return $this->mapToDTO($block);
	}

	private function update(MapBlock $mapBlock) : MapBlock {
		$blockEntity = $this->mapToBlockEntity($mapBlock);
		$blockEntity->update();
		$mapBlockEntity = $this->mapToEntity($mapBlock);
		$mapBlockEntity->update();
		return $this->mapToDTO($blockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : MapBlock {
		try {
			$block = \SRAG\Learnplaces\persistence\entity\MapBlock::findOrFail($id);
			return $this->mapToDTO($block);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Map block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$uploadBlock = \SRAG\Learnplaces\persistence\entity\MapBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($uploadBlock)){
				$uploadBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Map block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\MapBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$mappedBlocks[] = $this->mapToDTO($block);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block) : MapBlock {

		$mapBlock = new MapBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$mapBlock
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $mapBlock;

	}

	private function mapToEntity(MapBlock $mapBlock) : \SRAG\Learnplaces\persistence\entity\MapBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\MapBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\MapBlock::where(['fk_block_id' => $mapBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\MapBlock();
			$activeRecord->setFkBlockId($mapBlock->getId());
		}

		return $activeRecord;
	}

}