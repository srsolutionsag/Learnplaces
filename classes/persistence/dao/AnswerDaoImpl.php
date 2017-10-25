<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\AbstractCrudDao;
use SRAG\Learnplaces\persistence\entity\Answer;

/**
 * Class AnswerDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AnswerDaoImpl extends AbstractCrudDao implements AnswerDao {

	/**
	 * AnswerDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Answer::class);
	}

	/**
	 * Searches all answers for the comment with the given id.
	 *
	 * @param int $id The comment id which should be used to search all answers.
	 *
	 * @return Answer[] All answers which belong to the given comment.
	 */
	public final function findByCommentId(int $id) : array {
		$recordList = Answer::where(['fk_comment_id' => $id]);
		return $recordList->get();
	}
}