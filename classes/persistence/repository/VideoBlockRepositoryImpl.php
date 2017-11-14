<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\VideoBlock;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class VideoBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlockRepositoryImpl implements VideoBlockRepository {

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
	public function store(VideoBlock $videoBlock) : VideoBlock {
		$storedBlock = ($videoBlock->getId() > 0) ? $this->update($videoBlock) : $this->create($videoBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(VideoBlock $videoBlock) : VideoBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($videoBlock);
		$block->create();
		$videoBlockEntity = $this->mapToEntity($videoBlock);
		$videoBlockEntity->setFkBlockId($block->getPkId());
		$videoBlockEntity->create();
		return $this->mapToDTO($block, $videoBlockEntity);
	}

	private function update(VideoBlock $videoBlock) : VideoBlock {
		$blockEntity = $this->mapToBlockEntity($videoBlock);
		$blockEntity->update();
		$videoBlockEntity = $this->mapToEntity($videoBlock);
		$videoBlockEntity->update();
		return $this->mapToDTO($blockEntity, $videoBlockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : VideoBlock {
		try {
			$block = Block::findOrFail($id);
			$videoBlock = \SRAG\Learnplaces\persistence\entity\VideoBlock::where(['fk_block_id' => $id])->first();
			return $this->mapToDTO($block, $videoBlock);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Video block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$uploadBlock = \SRAG\Learnplaces\persistence\entity\VideoBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($uploadBlock)){
				$uploadBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Video block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\VideoBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$videoBlockEntity = \SRAG\Learnplaces\persistence\entity\VideoBlock::where(['fk_block_id' => $block->getPkId()])->first();
			$mappedBlocks[] = $this->mapToDTO($block, $videoBlockEntity);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block, \SRAG\Learnplaces\persistence\entity\VideoBlock $videoBlockEntity) : VideoBlock {

		$videoBlock = new VideoBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$videoBlock
			->setPath($videoBlockEntity->getPath())
			->setCoverPath($videoBlockEntity->getCoverPath())
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		return $videoBlock;

	}

	private function mapToEntity(VideoBlock $videoBlock) : \SRAG\Learnplaces\persistence\entity\VideoBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\VideoBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\VideoBlock::where(['fk_block_id' => $videoBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\VideoBlock();
			$activeRecord->setFkBlockId($videoBlock->getId());
		}

		$activeRecord
			->setPath($videoBlock->getPath())
			->setCoverPath($videoBlock->getCoverPath());

		return $activeRecord;
	}
}