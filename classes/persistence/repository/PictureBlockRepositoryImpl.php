<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\PictureBlock;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class PictureBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureBlockRepositoryImpl implements PictureBlockRepository {

	use BlockMappingAware, BlockConstraintAware;

	/**
	 * @var LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	private $learnplaceConstraintRepository;
	/**
	 * @var PictureRepository $pictureRepository
	 */
	private $pictureRepository;


	/**
	 * PictureBlockRepositoryImpl constructor.
	 *
	 * @param LearnplaceConstraintRepository $learnplaceConstraintRepository
	 * @param PictureRepository              $pictureRepository
	 */
	public function __construct(LearnplaceConstraintRepository $learnplaceConstraintRepository, PictureRepository $pictureRepository) {
		$this->learnplaceConstraintRepository = $learnplaceConstraintRepository;
		$this->pictureRepository = $pictureRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function store(PictureBlock $pictureBlock) : PictureBlock {
		$storedBlock = ($pictureBlock->getId() > 0) ? $this->update($pictureBlock) : $this->create($pictureBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(PictureBlock $pictureBlock) : PictureBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($pictureBlock);
		$block->create();
		$pictureBlockEntity = $this->mapToEntity($pictureBlock);
		$pictureBlockEntity->setFkBlockId($block->getPkId());
		$pictureBlockEntity->create();
		return $this->mapToDTO($block, $pictureBlockEntity);
	}

	private function update(PictureBlock $pictureBlock) : PictureBlock {
		$blockEntity = $this->mapToBlockEntity($pictureBlock);
		$blockEntity->update();
		$pictureBlockEntity = $this->mapToEntity($pictureBlock);
		$pictureBlockEntity->update();
		return $this->mapToDTO($blockEntity, $pictureBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : PictureBlock {
		try {
			$block = Block::findOrFail($id);
			$pictureBlock = \SRAG\Learnplaces\persistence\entity\PictureBlock::where(['fk_block_id' => $id])->first();
			if(is_null($pictureBlock))
				throw new EntityNotFoundException("Picture block with id \"$id\" was not found");

			return $this->mapToDTO($block, $pictureBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Picture block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$pictureBlock = \SRAG\Learnplaces\persistence\entity\PictureBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($pictureBlock)){
				$pictureBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Picture block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\PictureBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$pictureBlock = \SRAG\Learnplaces\persistence\entity\PictureBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $pictureBlock);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\PictureBlock $pictureBlockEntity) : PictureBlock {

		$pictureBlock = new PictureBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$pictureBlock
			->setTitle($pictureBlockEntity->getTitle())
			->setDescription($pictureBlockEntity->getDescription())
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setVisibility($visibility->getName());

		if(!is_null($pictureBlockEntity->getFkPicture()))
			$pictureBlock->setPicture($this->pictureRepository->find($pictureBlockEntity->getFkPicture()));

		return $pictureBlock;

	}

	private function mapToEntity(PictureBlock $pictureBlock) : \SRAG\Learnplaces\persistence\entity\PictureBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\PictureBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\PictureBlock::where(['fk_block_id' => $pictureBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\PictureBlock();
			$activeRecord->setFkBlockId($pictureBlock->getId());
		}

		if(!is_null($pictureBlock->getPicture()))
			$activeRecord->setFkPicture($pictureBlock->getPicture()->getId());

		$activeRecord
			->setTitle($pictureBlock->getTitle())
			->setDescription($pictureBlock->getDescription());

		return $activeRecord;
	}
}