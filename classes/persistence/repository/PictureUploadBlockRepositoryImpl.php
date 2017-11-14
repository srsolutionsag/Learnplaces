<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\{Learnplace, PictureUploadBlock};
use SRAG\Learnplaces\persistence\entity\{Block, Visibility};
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class PictureUploadBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureUploadBlockRepositoryImpl implements PictureUploadBlockRepository {

	use BlockConstraintAware, BlockMappingAware;

	/**
	 * @var LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	private $learnplaceConstraintRepository;

	/**
	 * PictureUploadBlockRepositoryImpl constructor.
	 *
	 * @param LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	public function __construct(LearnplaceConstraintRepository $learnplaceConstraintRepository) { $this->learnplaceConstraintRepository = $learnplaceConstraintRepository; }

	/**
	 * @inheritdoc
	 */
	public function store(PictureUploadBlock $pictureUploadBlock) : PictureUploadBlock {
		$storedBlock = ($pictureUploadBlock->getId() > 0) ? $this->update($pictureUploadBlock) : $this->create($pictureUploadBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(PictureUploadBlock $pictureUploadBlock) : PictureUploadBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($pictureUploadBlock);
		$block->create();
		$pictureUploadBlock->setId($block->getPkId());
		$this->mapToEntity($pictureUploadBlock)->create();
		return $this->mapToDTO($block);
	}

	private function update(PictureUploadBlock $pictureUploadBlock) : PictureUploadBlock {
		$blockEntity = $this->mapToBlockEntity($pictureUploadBlock);
		$blockEntity->update();
		return $this->mapToDTO($blockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : PictureUploadBlock {
		try {
			$block = Block::findOrFail($id);
			return $this->mapToDTO($block);
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
			$uploadBlock = \SRAG\Learnplaces\persistence\entity\PictureUploadBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($uploadBlock)){
				$uploadBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("PictureUploadBlock with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : PictureUploadBlock {
		$block = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\PictureUploadBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])
			->first();

		if(is_null($block))
			throw new EntityNotFoundException('Could not find picture upload block for learnplace with id "' . $learnplace->getId() . '".');

		return $this->mapToDTO($block);
	}

	private function mapToDTO(Block $block) : PictureUploadBlock {

		$pictureUploadBlock = new PictureUploadBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$pictureUploadBlock
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $pictureUploadBlock;

	}

	private function mapToEntity(PictureUploadBlock $pictureUploadBlock) : \SRAG\Learnplaces\persistence\entity\PictureUploadBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\PictureUploadBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\PictureUploadBlock::where(['fk_block_id' => $pictureUploadBlock->getId()])->first();
		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\PictureUploadBlock();
			$activeRecord->setFkBlockId($pictureUploadBlock->getId());
		}

		return $activeRecord;
	}


}