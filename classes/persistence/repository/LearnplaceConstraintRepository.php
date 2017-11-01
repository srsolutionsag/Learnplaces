<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\LearnplaceConstraint;

/**
 * Interface LearnplaceConstraintRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface LearnplaceConstraintRepository {

	/**
	 * Updates an existing learnplace constraint or creates a new if the constraint id was not found.
	 *
	 * @param LearnplaceConstraint $constraint The constraint which should be updated or created.
	 *
	 * @return LearnplaceConstraint The created or updated constraint.
	 */
	public function store(LearnplaceConstraint $constraint): LearnplaceConstraint;


	/**
	 * Searches the constraint by the block which the constraint belongs to.
	 *
	 * @param int $id The block id which should be used for the search.
	 *
	 * @return LearnplaceConstraint The found learnpace constraint.
	 */
	public function findByBlockId(int $id): LearnplaceConstraint;


	/**
	 * Deletes a learnplace constraint by its id.
	 *
	 * @param int $id   The id which should be used to delete the learnplace constraint.
	 *
	 * @return void
	 */
	public function delete(int $id);
}