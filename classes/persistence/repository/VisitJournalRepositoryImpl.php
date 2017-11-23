<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use function array_map;
use DateTime;
use ilDatabaseException;
use SRAG\Learnplaces\persistence\dto\VisitJournal;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class VisitJournalRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisitJournalRepositoryImpl implements VisitJournalRepository {

	/**
	 * @inheritdoc
	 */
	public function store(VisitJournal $visitJournal) : VisitJournal {

		$activeRecord = $this->mapToEntity($visitJournal);
		$activeRecord->store();
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id) : VisitJournal {
		try {
			$visitJournalEntity = \SRAG\Learnplaces\persistence\entity\VisitJournal::findOrFail($id);
			return $this->mapToDTO($visitJournalEntity);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("VisitJournal entry with id \"$id\" not found.", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$visitJournal = \SRAG\Learnplaces\persistence\entity\VisitJournal::findOrFail($id);
			$visitJournal->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("VisitJournal entry with id \"$id\" not found.", $ex);
		}
		catch (ilDatabaseException $ex) {
			throw new ilDatabaseException("Could not delete visit journal entry with id \"$id\".");
		}
	}


	/**
	 * Searches all visit journals which belong to the given learnplace id.
	 *
	 * @param int $id The learnplace id which should be used to find the visit journals
	 *
	 * @return VisitJournal[] All visits found by the given learnplace id.
	 */
	public function findByLearnplaceId(int $id) : array {
		return array_map(
			function($visit) { return $this->mapToDTO($visit); },                                                //mapping function
			\SRAG\Learnplaces\persistence\entity\VisitJournal::where(['fk_learnplace_id' => $id])->get()         //input
		);
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\VisitJournal $visitJournalEntity) : VisitJournal {
	$visitJournal = new VisitJournal();
	$visitJournal
		->setId($visitJournalEntity->getPkId())
		->setTime(new DateTime('@' . strval($visitJournalEntity->getTime())))
		->setUserId($visitJournalEntity->getUserId());

	return $visitJournal;
}

	private function mapToEntity(VisitJournal $visitJournal) : \SRAG\Learnplaces\persistence\entity\VisitJournal {

		$activeRecord = new \SRAG\Learnplaces\persistence\entity\VisitJournal($visitJournal->getId());
		$activeRecord
			->setTime($visitJournal->getTime()->getTimestamp())
			->setUserId($visitJournal->getUserId());

		return $activeRecord;
	}
}