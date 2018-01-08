<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Answer;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface AnswerRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface AnswerRepository {

	/**
	 * Updates an answer or creates a new one if the answer id was not found.
	 *
	 * @param Answer $answer    The answer which should be created or updated.
	 *
	 * @return Answer           The updated or created answer.
	 */
	public function store(Answer $answer): Answer;


	/**
	 * Searches an answer with the given id.
	 *
	 * @param int $id   The id of the answer which should be found.
	 *
	 * @return Answer   The found answer.
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the answer with the given id was not found.
	 */
	public function find(int $id): Answer;


	/**
	 * Find all answers for the commit with the given id.
	 * This method will not fail if the comment id is not valid.
	 * A search with an invalid id will always yield a result of zero found answers.
	 *
	 * @param int $id       The id of the comment which should be used to fetch all the corresponding answers.
	 *
	 * @return Answer[]     All answers which belong to the comment.
	 */
	public function findByCommentId(int $id): array;


	/**
	 * Deletes the answer with the given id.
	 *
	 * @param int $id   The id of the answer which should be deleted.
	 *
	 * @return void
	 */
	public function delete(int $id);
}