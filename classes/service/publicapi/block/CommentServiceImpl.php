<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\persistence\repository\CommentRepository;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\service\publicapi\model\CommentModel;

/**
 * Class CommentServiceImpl
 *
 * @package SRAG\Learnplaces\service\publicapi
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 * @deprecated Not needed for current version
 */
class CommentServiceImpl implements CommentService {

	/**
	 * @var CommentRepository $commentRepository
	 */
	private $commentRepository;

	/**
	 * CommentServiceImpl constructor.
	 *
	 * @param CommentRepository $commentRepository
	 */
	public function __construct(CommentRepository $commentRepository) { $this->commentRepository = $commentRepository; }

	/**
	 * @inheritDoc
	 */
	public function store(CommentModel $commentModel): CommentModel {
		try {
			$dto = $commentModel->toDto();
			$dto = $this->commentRepository->store($dto);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('Could not save the answer relations please make sure to save all the answers before the comment.', 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function find(int $commentId): CommentModel {
		try {
			$dto = $this->commentRepository->find($commentId);
			return $dto->toModel();
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException("Comment with the given id does not exist and is therefore considered invalid.", 0, $ex);
		}
	}


	/**
	 * @inheritDoc
	 */
	public function delete(int $commentId) {
		try {
			$this->commentRepository->delete($commentId);
		}
		catch (EntityNotFoundException $ex) {
			throw new InvalidArgumentException('Comment with the given id does not exist and is therefore considered invalid.', 0, $ex);
		}
	}
}