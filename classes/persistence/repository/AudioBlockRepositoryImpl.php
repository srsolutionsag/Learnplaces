<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\AudioBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class AudioBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AudioBlockRepositoryImpl implements AudioBlockRepository {

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
	public function store(AudioBlock $audioBlock) : AudioBlock {
		$storedBlock = ($audioBlock->getId() > 0) ? $this->update($audioBlock) : $this->create($audioBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(AudioBlock $audioBlock) : AudioBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($audioBlock);
		$block->create();
		$audioBlockEntity = $this->mapToEntity($audioBlock);
		$audioBlockEntity->setFkBlockId($block->getPkId());
		$audioBlockEntity->create();
		return $this->mapToDTO($block, $audioBlockEntity);
	}

	private function update(AudioBlock $audioBlock) : AudioBlock {
		$blockEntity = $this->mapToBlockEntity($audioBlock);
		$blockEntity->update();
		$audioBlockEntity = $this->mapToEntity($audioBlock);
		$audioBlockEntity->update();
		return $this->mapToDTO($blockEntity, $audioBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : AudioBlock {
		try {
			$block = Block::findOrFail($id);
			$audioBlock = \SRAG\Learnplaces\persistence\entity\AudioBlock::where(['fk_block_id' => $id])->first();
			return $this->mapToDTO($block, $audioBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Audio block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$uploadBlock = \SRAG\Learnplaces\persistence\entity\AudioBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($uploadBlock)){
				$uploadBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Audio block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\AudioBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$audioBlockEntity = \SRAG\Learnplaces\persistence\entity\AudioBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $audioBlockEntity);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\AudioBlock $audioBlockEntity) : AudioBlock {

		$audioBlock = new AudioBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$audioBlock
			->setPath($audioBlockEntity->getPath())
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $audioBlock;

	}

	private function mapToEntity(AudioBlock $audioBlock) : \SRAG\Learnplaces\persistence\entity\AudioBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\AudioBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\AudioBlock::where(['fk_block_id' => $audioBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\AudioBlock();
			$activeRecord->setFkBlockId($audioBlock->getId());
		}

		$activeRecord->setPath($audioBlock->getPath());
		return $activeRecord;
	}
}