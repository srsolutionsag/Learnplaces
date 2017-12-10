<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\RichTextBlock;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class RichTextBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class RichTextBlockRepositoryImpl implements RichTextBlockRepository {

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
	public function store(RichTextBlock $richTextBlock) : RichTextBlock {
		$storedBlock = ($richTextBlock->getId() > 0) ? $this->update($richTextBlock) : $this->create($richTextBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(RichTextBlock $richTextBlock) : RichTextBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($richTextBlock);
		$block->create();
		$richTextBlockEntity = $this->mapToEntity($richTextBlock);
		$richTextBlockEntity->setFkBlockId($block->getPkId());
		$richTextBlockEntity->create();
		return $this->mapToDTO($block, $richTextBlockEntity);
	}

	private function update(RichTextBlock $richTextBlock) : RichTextBlock {
		$blockEntity = $this->mapToBlockEntity($richTextBlock);
		$blockEntity->update();
		$richTextBlockEntity = $this->mapToEntity($richTextBlock);
		$richTextBlockEntity->update();
		return $this->mapToDTO($blockEntity, $richTextBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : RichTextBlock {
		try {
			$block = Block::findOrFail($id);
			$richTextBlock = \SRAG\Learnplaces\persistence\entity\RichTextBlock::where(['fk_block_id' => $id])->first();
			if(is_null($richTextBlock))
				throw new EntityNotFoundException("Rich text block with id \"$id\" was not found");
			return $this->mapToDTO($block, $richTextBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Rich text block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$richTextBlock = \SRAG\Learnplaces\persistence\entity\RichTextBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($richTextBlock)){
				$richTextBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Rich text block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\RichTextBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$richTextBlock = \SRAG\Learnplaces\persistence\entity\RichTextBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $richTextBlock);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\RichTextBlock $richTextBlockEntity) : RichTextBlock {

		$richTextBlock = new RichTextBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$richTextBlock
			->setContent($richTextBlockEntity->getContent())
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setVisibility($visibility->getName());

		return $richTextBlock;

	}

	private function mapToEntity(RichTextBlock $richTextBlock) : \SRAG\Learnplaces\persistence\entity\RichTextBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\RichTextBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\RichTextBlock::where(['fk_block_id' => $richTextBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\RichTextBlock();
			$activeRecord->setFkBlockId($richTextBlock->getId());
		}

		$activeRecord
			->setContent($richTextBlock->getContent());

		return $activeRecord;
	}
}