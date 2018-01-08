<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\FeedbackBlock;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Interface FeedbackBlockRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface FeedbackBlockRepository {

	/**
	 * Updates a feedback block or creates a new one if the id of the given block was not found.
	 *
	 * @param FeedbackBlock $feedbackBlock  The block which should be updated or created.
	 *
	 * @return FeedbackBlock                The newly created or updated feedback block.
	 */
	public function store(FeedbackBlock $feedbackBlock): FeedbackBlock;


	/**
	 * Searches a feedback block by block id.
	 *
	 * @param int $id           The block id which should be used to search the feedback block.
	 *
	 * @return FeedbackBlock    The feedback block with the given id.
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if the feedback block with the given id was not found.
	 */
	public function findByBlockId(int $id): FeedbackBlock;


	/**
	 * Deletes the feedback block with the given block id.
	 *
	 * @param int $id   The id of the feedback block which should be deleted.
	 *
	 * @return void
	 *
	 * @throws EntityNotFoundException
	 *                  Thrown if the feedback block was not found with the given block id.
	 */
	public function delete(int $id);


	/**
	 * Searches all feedback blocks which belong to the given learnplace.
	 *
	 * @param Learnplace $learnplace    The learnplace which should be used to search all corresponding feedback blocks.
	 *
	 * @return FeedbackBlock[]          All found feedback blocks which belong to the given learnplace.
	 */
	public function findByLearnplace(Learnplace $learnplace): array;
}