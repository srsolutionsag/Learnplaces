<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\CommentBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\entity\Block;
use SRAG\Learnplaces\persistence\entity\Comment;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class CommentBlockRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentBlockRepositoryImpl implements CommentBlockRepository {

	use BlockMappingAware, BlockConstraintAware;

	/**
	 * @var LearnplaceConstraintRepository $learnplaceConstraintRepository
	 */
	private $learnplaceConstraintRepository;
	/**
	 * @var CommentRepository $commentRepository
	 */
	private $commentRepository;


	/**
	 * CommentBlockRepositoryImpl constructor.
	 *
	 * @param LearnplaceConstraintRepository $learnplaceConstraintRepository
	 * @param CommentRepository              $commentRepository
	 */
	public function __construct(LearnplaceConstraintRepository $learnplaceConstraintRepository, CommentRepository $commentRepository) {
		$this->learnplaceConstraintRepository = $learnplaceConstraintRepository;
		$this->commentRepository = $commentRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function store(CommentBlock $commentBlock) : CommentBlock {
		$storedBlock = ($commentBlock->getId() > 0) ? $this->update($commentBlock) : $this->create($commentBlock);
		$this->storeBlockConstraint($storedBlock);
		return $storedBlock;
	}

	private function create(CommentBlock $commentBlock) : CommentBlock {
		/**
		 * @var Block $block
		 */
		$block = $this->mapToBlockEntity($commentBlock);
		$block->create();
		$commentBlockEntity = $this->mapToEntity($commentBlock);
		$commentBlockEntity->setFkBlockId($block->getPkId());
		$commentBlockEntity->create();

		$this->saveCommentRelations($commentBlock);

		return $this->mapToDTO($block);
	}

	private function update(CommentBlock $commentBlock) : CommentBlock {
		$blockEntity = $this->mapToBlockEntity($commentBlock);
		$blockEntity->update();
		$commentBlockEntity = $this->mapToEntity($commentBlock);
		$commentBlockEntity->update();

		$this->saveCommentRelations($commentBlock);

		return $this->mapToDTO($blockEntity);
	}

	private function saveCommentRelations(CommentBlock $commentBlock) {
		foreach($commentBlock->getComments() as $comment) {
			$commentEntitiy = new Comment($comment->getId());
			if(is_null($commentEntitiy->getFkCommentBlock())) {
				$commentEntitiy->setFkCommentBlock($commentBlock->getId());
				$commentEntitiy->store();
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : CommentBlock {
		try {
			$block = \SRAG\Learnplaces\persistence\entity\CommentBlock::findOrFail($id);
			return $this->mapToDTO($block);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Comment block with id \"$id\" was not found", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$commentBlock = \SRAG\Learnplaces\persistence\entity\CommentBlock::where(['fk_block_id' => $id])->first();
			if(!is_null($commentBlock)){
				$commentBlock->delete();
			}

			Block::findOrFail($id)->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Comment block with id \"$id\" not found", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : array {
		/**
		 * @var Block[] $blocks
		 */
		$blocks = Block::innerjoinAR(new \SRAG\Learnplaces\persistence\entity\CommentBlock(), 'pk_id', 'fk_block_id')
			->where(['fk_learnplace_id' => $learnplace->getId()])->get();

		$mappedBlocks = [];

		//fetch all specific blocks and map them to DTOs
		foreach ($blocks as $block) {
			$mappedBlocks[] = $this->mapToDTO($block);
		}

		return $mappedBlocks;
	}

	private function mapToDTO(Block $block) : CommentBlock {

		$commentBlock = new CommentBlock();
		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::findOrFail($block->getFkVisibility());

		$commentBlock
			->setId($block->getPkId())
			->setSequence($block->getSequence())
			->setConstraint($this->learnplaceConstraintRepository->findByBlockId($block->getPkId()))
			->setVisibility($visibility->getName());

		$comments = $this->commentRepository->findByBlockId($block->getPkId());
		$commentBlock->setComments($comments);

		return $commentBlock;

	}

	private function mapToEntity(CommentBlock $commentBlock) : \SRAG\Learnplaces\persistence\entity\CommentBlock {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\CommentBlock $activeRecord
		 */
		$activeRecord = \SRAG\Learnplaces\persistence\entity\CommentBlock::where(['fk_block_id' => $commentBlock->getId()])->first();

		if(is_null($activeRecord)) {
			$activeRecord = new \SRAG\Learnplaces\persistence\entity\CommentBlock();
			$activeRecord->setFkBlockId($commentBlock->getId());
		}

		return $activeRecord;
	}

}