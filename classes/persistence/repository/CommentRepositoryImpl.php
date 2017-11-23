<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use DateTime;
use ilDatabaseException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\Comment;
use SRAG\Learnplaces\persistence\entity\Answer;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class CommentRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentRepositoryImpl implements CommentRepository {

	/**
	 * @var PictureRepository $pictureRepository
	 */
	private $pictureRepository;
	/**
	 * @var AnswerRepository $answerRepository
	 */
	private $answerRepository;


	/**
	 * CommentRepositoryImpl constructor.
	 *
	 * @param PictureRepository $pictureRepository
	 * @param AnswerRepository  $answerRepository
	 */
	public function __construct(PictureRepository $pictureRepository, AnswerRepository $answerRepository) {
		$this->pictureRepository = $pictureRepository;
		$this->answerRepository = $answerRepository;
	}

	/**
	 * @inheritdoc
	 */
	public function store(Comment $comment) : Comment {
		$activeRecord = $this->mapToEntity($comment);
		$activeRecord->store();

		try {
			//store all foreign keys
			foreach ($comment->getAnswers() as $answer) {

				/**
				 * @var Answer $answerEntity
				 */
				$answerEntity = Answer::findOrFail($answer->getId());
				$answerEntity->setFkCommentId($comment->getId());
				$answerEntity->store();
			}
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Unable to save answer relations, due to non persistent answers.");
		}

		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id) : Comment {
		try {
			$commentEntity = \SRAG\Learnplaces\persistence\entity\Comment::findOrFail($id);
			return $this->mapToDTO($commentEntity);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Comment with id \"$id\" not found.", $ex);
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByBlockId(int $id) : array {
		$commentBlocks = \SRAG\Learnplaces\persistence\entity\Comment::where(['fk_comment_block' => $id])->get();
		return array_map(
			function(\SRAG\Learnplaces\persistence\entity\Comment $comment) { return $this->mapToDTO($comment); },
			$commentBlocks
		);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			/**
			 * @var \SRAG\Learnplaces\persistence\entity\Comment $commentEntity
			 */
			$commentEntity = \SRAG\Learnplaces\persistence\entity\Comment::findOrFail($id);
			$commentEntity->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Comment with id \"$id\" not found.", $ex);
		}
		catch(ilDatabaseException $ex) {
			throw new ilDatabaseException("Unable to delete comment with id \"$id\"");
		}
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\Comment $commentEntity) : Comment {

		$comment = new Comment();
		$comment
			->setId($commentEntity->getPkId())
			->setTitle($comment->getTitle())
			->setContent($comment->getContent())
			->setCreateDate(new DateTime('@' . strval($commentEntity->getCreateDate())))
			->setUserId($commentEntity->getFkIluserId());
		if(!is_null($commentEntity->getFkPictureId()))
			$comment->setPicture($this->pictureRepository->find($commentEntity->getFkPictureId()));

		$answers = $this->answerRepository->findByCommentId($comment->getId());
		$comment->setAnswers($answers);

		return $comment;
	}

	private function mapToEntity(Comment $comment) : \SRAG\Learnplaces\persistence\entity\Comment {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\Comment $activeRecord
		 */
		$activeRecord = new \SRAG\Learnplaces\persistence\entity\Comment($comment->getId());
		$picture = $comment->getPicture();
		if(!is_null($picture))
			$activeRecord->setFkPictureId($picture->getId());

		$activeRecord
			->setPkId($comment->getId())
			->setTitle($comment->getTitle())
			->setContent($comment->getContent())
			->setCreateDate($comment->getCreateDate()->getTimestamp())
			->setFkIluserId($comment->getUserId());

		return $activeRecord;
	}
}