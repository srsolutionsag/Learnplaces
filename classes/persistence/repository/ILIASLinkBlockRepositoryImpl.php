<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\ILIASLinkBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class ILIASLinkBlock
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ILIASLinkBlockRepositoryImpl implements ILIASLinkBlockRepository {

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
	public function store(ILIASLinkBlock $linkBlock) : ILIASLinkBlock {
		$storedBlock = ($linkBlock->getId() > 0) ? $this->update($linkBlock) : $this->create($linkBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(ILIASLinkBlock $linkBlock) : ILIASLinkBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($linkBlock);
		$block->create();
		$linkBlockEntity = $this->mapToEntity($linkBlock);
		$linkBlockEntity->setFkBlockId($block->getPkId());
		$linkBlockEntity->create();
		return $this->mapToDTO($block, $linkBlockEntity);
	}

	private function update(ILIASLinkBlock $linkBlock) : ILIASLinkBlock {
		$blockEntity = $this->mapToBlockEntity($linkBlock);
		$blockEntity->update();
		$linkBlockEntity = $this->mapToEntity($linkBlock);
		$linkBlockEntity->update();
		return $this->mapToDTO($blockEntity, $linkBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : ILIASLinkBlock {
		try {
			$block = Block::findOrFail($id);
			$linkBlock = \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock::where(['fk_block_id' => $id])->first();
			return $this->mapToDTO($block, $linkBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("PictureUploadBlock with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$uploadBlock = \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($uploadBlock)){
				$uploadBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("ILIAS link block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific link blocks and map them DTOs
		foreach ($blocks as $block) {
			$linkBlockEntity = \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $linkBlockEntity);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock $linkBlockEntity) : ILIASLinkBlock {

		$linkBlock = new ILIASLinkBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$linkBlock
			->setRefId($linkBlockEntity->getRefId())
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $linkBlock;

	}

	private function mapToEntity(ILIASLinkBlock $linkBlock) : \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock::where(['fk_block_id' => $linkBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\ILIASLinkBlock();
			$activeRecord->setFkBlockId($linkBlock->getId());
		}

		$activeRecord->setRefId($linkBlock->getRefId());
		return $activeRecord;
	}

}