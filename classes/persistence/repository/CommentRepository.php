<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Comment;
use SRAG\Learnplaces\persistence\dto\CommentBlock;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface CommentRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface CommentRepository {

	/**
	 * Updates the given commet or creates a new one if the comment id was not found.
	 *
	 * @param Comment $comment  The comment which should be updated or created.
	 *
	 * @return Comment          The updated or created comment.
	 */
	public function store(Comment $comment): Comment;


	/**
	 * Finds the comment by id.
	 *
	 * @param int $id   The id of the comment which should be found.
	 *
	 * @return Comment  The comment with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the comment with the given id was not found.
	 */
	public function find(int $id): Comment;


	/**
	 * Searches all comments which belong to the comment block with the given id.
	 *
	 * @param int $id       The id of the comment block which should be used to find all corresponding comments.
	 *
	 * @return Comment[]    All comments which belong to comment block with the given id.
	 */
	public function findByBlockId(int $id): array;


	/**
	 * Deletes a comment by id.
	 *
	 * @param int $id   The which should be used to delete the comment.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if no comment could be found with the given id.
	 */
	public function delete(int $id);
}