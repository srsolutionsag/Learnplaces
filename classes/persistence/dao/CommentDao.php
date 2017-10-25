<?php

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\CrudDao;
use SRAG\Learnplaces\persistence\entity\Comment;

/**
 * Interface CommentDao
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface CommentDao extends CrudDao {

	/**
	 * Searches all comments which belong to the comment block with the given id.
	 *
	 * @param int $id The comment block id which should be used to search for the comments.
	 *
	 * @return Comment[] All comments which belong to the given comment block.
	 */
	public function findByCommentBlockId(int $id): array;
}