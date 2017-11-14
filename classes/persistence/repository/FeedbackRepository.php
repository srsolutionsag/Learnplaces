<?php

namespace SRAG\Learnplaces\persistence\repository;

use ilDatabaseException;
use SRAG\Learnplaces\persistence\dto\Feedback;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface FeedbackRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface FeedbackRepository {

	/**
	 * Updates a feedback or creates a new one if the id of the feedback was not found.
	 *
	 * @param Feedback $feedback    The feedback which should be updated or created.
	 *
	 * @return Feedback             The newly updated or created feedback.
	 */
	public function store(Feedback $feedback): Feedback;


	/**
	 * Searches a feedback by id.
	 *
	 * @param int $id   The id of the feedback which should be used to find the feedback.
	 *
	 * @return Feedback The feedback with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the feedback with the given id was not found
	 */
	public function find(int $id): Feedback;


	/**
	 * Searches all feedbacks which belong to the learnplace with the given id.
	 *
	 * @param int $id       The learnplace id which should be used to find all corresponding feedbacks.
	 *
	 * @return Feedback[]   All feedbacks which belong to the learnplace with the given id.
	 */
	public function findByLearnplaceId(int $id): array;


	/**
	 * Deletes the feedback with the given id.
	 *
	 * @param int $id   The id of the feedback which should be removed.
	 *
	 * @return void
	 * @throws EntityNotFoundException
	 *                  Thrown if the feedback with the given id was not found.
	 * @throws ilDatabaseException
	 *                  Thrown if the feedback was found but could not be deleted.
	 */
	public function delete(int $id);
}