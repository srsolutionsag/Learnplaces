<?php

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\CrudDao;
use SRAG\Learnplaces\persistence\entity\Answer;

/**
 * Interface AnswerDao
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface AnswerDao extends CrudDao {

	/**
	 * Searches all answers for the comment with the given id.
	 *
	 * @param int $id The comment id which should be used to search all answers.
	 *
	 * @return Answer[] All answers which belong to the given comment.
	 */
	public function findByCommentId(int $id): array;
}