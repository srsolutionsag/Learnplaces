<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\CommentModel;

/**
 * Interface CommentService
 *
 * The comment service defines the public interface which must be used by
 * the GUI, REST or other Plugins to access the comments of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 * @deprecated Not needed for current version
 */
interface CommentService {

	/**
	 * Stores only the comment and the relations to the answer, but not the answers.
	 * Please save the answers first with the CommentService::storeAnswer method.
	 *
	 * @param CommentModel $commentModel    The comment model which should be created or updated.
	 *
	 * @return CommentModel                 The newly created or updated comment.
	 *
	 * @throws InvalidArgumentException     Thrown if the comment could not be saved due to missing
	 *                                      database entries for example non persistent answers.
	 *
	 * $@see CommentService::storeAnswer()
	 */
	public function store(CommentModel $commentModel) : CommentModel;


	/**
	 * Find the comment with the given id.
	 *
	 * @param int $commentId            The comment id which should be used to fetch the comment.
	 *
	 * @throws InvalidArgumentException Thrown if the id is not considered invalid.
	 *
	 * @return CommentModel             The comment model with the given id.
	 */
	public function find(int $commentId): CommentModel;


	/**
	 * Deletes the comment with the given id.
	 *
	 * @param int $commentId                The comment id which should be used to delete the comment.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException    Thrown if the comment with the given id doesn't exist.
	 */
	public function delete(int $commentId);
}