<?php

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\VisitJournal;

/**
 * Interface VisitJournalRepository
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface VisitJournalRepository {

	/**
	 * Updates an existing visit journal or creates a new entry.
	 *
	 * @param VisitJournal $visitJournal The visit journal which should be persisted.
	 *
	 * @return VisitJournal The newly persisted visit journal.
	 */
	public function store(VisitJournal $visitJournal): VisitJournal;


	/**
	 * Searches a visit journal by id.
	 *
	 * @param int $id The id which should be used to search the visit journal.
	 *
	 * @return VisitJournal The found visit journal.
	 */
	public function find(int $id): VisitJournal;


	/**
	 * Deletes an existing visit journal.
	 *
	 * @param int $id The id which should be used to
	 *
	 * @return void
	 */
	public function delete(int $id);

	/**
	 * Searches all visit journals which belong to the given learnplace id.
	 *
	 * @param int $id The learnplace id which should be used to find the visit journals
	 *
	 * @return VisitJournal[] All visits found by the given learnplace id.
	 */
	public function findByLearnplaceId(int $id) : array;
}