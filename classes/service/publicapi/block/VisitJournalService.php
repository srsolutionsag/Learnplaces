<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use SRAG\Learnplaces\service\publicapi\model\VisitJournalModel;

/**
 * Interface VisitJournalService
 *
 * This interface defines the public available operations which must be
 * used to manipulate the visit journal.
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface VisitJournalService {

	/**
	 * Updates a given learn journal or creates a new one if the given journal was not found.
	 *
	 * @param VisitJournalModel $visitJournalModel  The visit journal which should be created or updated.
	 *
	 * @return VisitJournalModel                    The newly created or updated visit journal.
	 */
	public function store(VisitJournalModel $visitJournalModel): VisitJournalModel;


	/**
	 * Deletes a visit journal entry by id.
	 *
	 * @param int $id    The id of the visit journal which should be deleted.
	 *
	 * @return void
	 *
	 * @throws InvalidArgumentException
	 *                  Thrown if no visit journal was found with the given id.
	 */
	public function delete(int $id);


	/**
	 * Searches the visit journal with the given id.
	 *
	 * @param int $id               The id of the visit journal which should be found.
	 *
	 * @return VisitJournalModel    The visit journal with the given id.
	 *
	 * @throws InvalidArgumentException
	 *                              Thrown if no visit journal was found with the given id.
	 */
	public function find(int $id): VisitJournalModel;


	/**
	 * Searches all visit journal entries which belong to the learnplace with the given object id.
	 *
	 * @param int $id               The object id which should be used to search all corresponding visit journal entries.
	 *
	 * @return VisitJournalModel[]  The visit journal models which belong to the learnplace with the given id.
	 */
	public function findByObjectId(int $id): array;

}