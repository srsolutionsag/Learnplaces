<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use SRAG\Learnplaces\persistence\dto\AccordionBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\entity\AccordionBlockMember;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\util\BlockAccumulator;

class AccordionBlockRepositoryImpl implements AccordionBlockRepository {

	use BlockMappingAware, BlockConstraintAware;

	/**
	 * @var LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	private $learnplaceConstraintRepository;
	/**
	 * @var BlockAccumulator $blockAccumulator
	 */
	private $blockAccumulator;


	/**
	 * AccordionBlockRepositoryImpl constructor.
	 *
	 * @param LearnplaceConstraintRepository $learnplaceConstraintRepository
	 * @param BlockAccumulator               $blockAccumulator
	 */
	public function __construct(LearnplaceConstraintRepository $learnplaceConstraintRepository, BlockAccumulator $blockAccumulator) {
		$this->learnplaceConstraintRepository = $learnplaceConstraintRepository;
		$this->blockAccumulator = $blockAccumulator;
	}


	/**
	 * @inheritdoc
	 */
	public function store(AccordionBlock $accordionBlock) : AccordionBlock {
		$storedBlock = ($accordionBlock->getId() > 0) ? $this->update($accordionBlock) : $this->create($accordionBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(AccordionBlock $accordionBlock) : AccordionBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($accordionBlock);
		$block->create();
		$accordionBlockEntity = $this->mapToEntity($accordionBlock);
		$accordionBlockEntity->setFkBlockId($block->getPkId());
		$accordionBlockEntity->create();
		return $this->mapToDTO($block, $accordionBlockEntity);
	}

	private function update(AccordionBlock $accordionBlock) : AccordionBlock {
		$blockEntity = $this->mapToBlockEntity($accordionBlock);
		$blockEntity->update();
		$accordionBlockEntity = $this->mapToEntity($accordionBlock);
		$accordionBlockEntity->update();
		return $this->mapToDTO($blockEntity, $accordionBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : AccordionBlock {
		try {
			$block = Block::findOrFail($id);
			$accordionBlock = \SRAG\Learnplaces\persistence\entity\AccordionBlock::where(['fk_block_id' => $id])->first();
			return $this->mapToDTO($block, $accordionBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Accordion block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$accordionBlock = \SRAG\Learnplaces\persistence\entity\AccordionBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($accordionBlock)){
				$accordionBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Accordion block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\AccordionBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$accordionBlock = \SRAG\Learnplaces\persistence\entity\AccordionBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $accordionBlock);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\AccordionBlock $accordionBlockEntity) : AccordionBlock {

		$accordionBlock = new AccordionBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$accordionBlock
			->setTitle($accordionBlockEntity->getTitle())
			->setExpand($accordionBlockEntity->getExpand() === 1)
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		$members = AccordionBlockMember::where(['fk_accordion_block' => $accordionBlockEntity->getPkId()])->get();
		$blocks = array_map(
			function (AccordionBlockMember $member) {
				return $this->blockAccumulator->fetchSpecificBlocksById($member->getFkBlockId());
			},
			$members
		);

		$accordionBlock->setBlocks($blocks);

		return $accordionBlock;

	}

	private function mapToEntity(AccordionBlock $accordionBlock) : \SRAG\Learnplaces\persistence\entity\AccordionBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\AccordionBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\AccordionBlock::where(['fk_block_id' => $accordionBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\AccordionBlock();
			$activeRecord->setFkBlockId($accordionBlock->getId());
		}

		$activeRecord->setExpand($accordionBlock->isExpand() ? 1 : 0);
		$activeRecord->setTitle($accordionBlock->getTitle());

		return $activeRecord;
	}
}