<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\VisitJournal;

/**
 * Class VisitJournalDaoImpl
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisitJournalDaoImpl extends AbstractCrudDao implements VisitJournalDao {

	/**
	 * VisitJournalDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(VisitJournal::class);
	}
}