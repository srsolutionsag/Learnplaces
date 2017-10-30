<?php

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\VisitJournal;

/**
 * Interface VisitJournalDao
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface VisitJournalDao extends CrudDao {

	/**
	 * Searches all visits by learnplace id.
	 *
	 * @param int $id The id which should be used to search all the visits.
	 *
	 * @return VisitJournal[] A collection of all found visits.
	 */
	public function findByLearnplaceId(int $id) : array;
}