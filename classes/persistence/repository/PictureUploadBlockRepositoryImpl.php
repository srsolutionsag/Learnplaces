<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dao\BlockDao;
use SRAG\Learnplaces\persistence\dao\VisibilityDao;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\PictureUploadBlock;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Lernplaces\persistence\dao\LearnplaceConstraintDao;
use SRAG\Lernplaces\persistence\dao\PictureUploadBlockDao;

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
	 * @var BlockDao $blockDao
	 */
	private $blockDao;
	/**
	 * @var PictureUploadBlockDao $pictureUploadBlockDao
	 */
	private $pictureUploadBlockDao;
	/**
	 * @var VisibilityDao $visibilityDao
	 */
	private $visibilityDao;
	/**
	 * @var LearnplaceConstraintDao $learplaceConstraint
	 */
	private $learnplaceConstraintDao;
	/**
	 * @var LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	private $learnplaceConstraintRepository;


	/**
	 * PictureUploadBlockRepositoryImpl constructor.
	 *
	 * @param BlockDao                       $blockDao
	 * @param PictureUploadBlockDao          $pictureUploadBlockDao
	 * @param VisibilityDao                  $visibilityDao
	 * @param LearnplaceConstraintDao        $learnplaceConstraintDao
	 * @param LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	public function __construct(BlockDao $blockDao, PictureUploadBlockDao $pictureUploadBlockDao, VisibilityDao $visibilityDao, LearnplaceConstraintDao $learnplaceConstraintDao, LearnplaceConstraintRepository $learnplaceConstraintRepository) {
		$this->blockDao = $blockDao;
		$this->pictureUploadBlockDao = $pictureUploadBlockDao;
		$this->visibilityDao = $visibilityDao;
		$this->learnplaceConstraintDao = $learnplaceConstraintDao;
		$this->learnplaceConstraintRepository = $learnplaceConstraintRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function store(PictureUploadBlock $pictureUploadBlock) : PictureUploadBlock {
		$storedBlock = ($pictureUploadBlock->getId() > 0) ? $this->update($pictureUploadBlock) : $this->create($pictureUploadBlock);
		$this->storeBlockConstraint($storedBlock, $this->learnplaceConstraintDao);
		return $storedBlock;
	}

	private function create(PictureUploadBlock $pictureUploadBlock) : PictureUploadBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->blockDao->create($this->mapToBlockEntity($pictureUploadBlock, $this->visibilityDao));
		$pictureUploadBlock->setId($block->getPkId());
		$this->pictureUploadBlockDao->create($this->mapToEntity($pictureUploadBlock));
		return $this->mapToDTO($block);
	}

	private function update(PictureUploadBlock $pictureUploadBlock) : PictureUploadBlock {
		$blockEntity = $this->blockDao->update($this->mapToBlockEntity($pictureUploadBlock, $this->visibilityDao));
		return $this->mapToDTO($blockEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : PictureUploadBlock {
		$block = $this->blockDao->find($id);
		return $this->mapToDTO($block);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		$this->pictureUploadBlockDao->delete($id);
	}


	/**
	 * @param Learnplace $learnplace
	 *
	 * @return PictureUploadBlock[]
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		$blocks = $this->blockDao->findByLearnplaceId($learnplace->getId());
	}

	private function mapToDTO(Block $block) : PictureUploadBlock {

		$pictureUploadBlock = new PictureUploadBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = $this->visibilityDao->find($block->getFkVisibility());

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
		$activeRecord = ($pictureUploadBlock > 0)
			? $this->pictureUploadBlockDao->find($pictureUploadBlock->getId())
			: new \SRAG\Learnplaces\persistence\entity\PictureUploadBlock();

		return $activeRecord;
	}


}