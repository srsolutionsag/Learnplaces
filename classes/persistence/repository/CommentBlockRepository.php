<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\CommentBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface CommentBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface CommentBlockRepository {

	/**
	 * Updates a comment block or creates a new one if the comment block id was not found.
	 *
	 * @param CommentBlock $commentBlock    The comment block which should be updated or created.
	 *
	 * @return CommentBlock                 The updated or created comment block.
	 */
	public function store(CommentBlock $commentBlock): CommentBlock;


	/**
	 * Searches a comment block by block id.
	 *
	 * @param int $id           The id of the block which should be used to search the comment block.
	 *
	 * @return CommentBlock     The found comment block with the given id.
	 * @throws EntityNotFoundException
	 *                          Thrown if the block with the given id was not found.
	 */
	public function findByBlockId(int $id): CommentBlock;


	/**
	 * Removes a comment block by block id.
	 *
	 * @param int $id   The id of the block which should be removed.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the given block id was not found.
	 */
	public function delete(int $id);


	/**
	 * Searches all comment blocks which belong to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding comment blocks.
	 *
	 * @return CommentBlock[]
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}