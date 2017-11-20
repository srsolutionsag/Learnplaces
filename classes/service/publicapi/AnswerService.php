<?php

namespace SRAG\Learnplaces\service\publicapi;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\AnswerModel;

/**
 * Interface AnswerService
 *
 * The answer service defines the public interface which must be used by
 * the GUI, REST or other Plugins to access the comment answers of the learnplace.
 *
 * @package SRAG\Learnplaces\service\publicapi
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface AnswerService {

	/**
	 * Store the given answer.
	 * Please make sure to store the relation to a comment via the CommentService::store method,
	 * otherwise the answer will end up as an orphan within the system due to the missing relation to a comment.
	 *
	 * @param AnswerModel $answerModel  The answer which should be created or updated.
	 *
	 * @return AnswerModel              The newly created or updated answer model.
	 *
	 * @see CommentService::store()     Use to store the answer relation afterwards!
	 */
	public function store(AnswerModel $answerModel): AnswerModel;

	/**
	 * Find the answer with the given id.
	 *
	 * @param int $answerId                 The id which should be used to fetch the answer with the corresponding id.
	 *
	 * @throws \InvalidArgumentException    Thrown if the id is not considered invalid.
	 *
	 * @return AnswerModel                  The answer with the given id.
	 */
	public function find(int $answerId): AnswerModel;

	/**
	 * Deletes the answer with the given id.
	 *
	 * @param int $answerId                 The answer id which should be used to delete the answer.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException     Thrown if the answer with the given id doesn't exist.
	 */
	public function delete(int $answerId);

}