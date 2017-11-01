<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use function array_map;
use DateTime;
use SRAG\Learnplaces\persistence\dao\VisibilityDao;
use SRAG\Learnplaces\persistence\dao\VisitJournalDao;
use SRAG\Lernplaces\persistence\dto\VisitJournal;

/**
 * Class VisitJournalRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisitJournalRepositoryImpl implements VisitJournalRepository {

	/**
	 * @var VisitJournalDao $visitJournalDao
	 */
	private $visitJournalDao;


	/**
	 * VisitJournalRepositoryImpl constructor.
	 *
	 * @param VisitJournalDao $visitJournalDao
	 */
	public function __construct(VisitJournalDao $visitJournalDao) { $this->visitJournalDao = $visitJournalDao; }

	/**
	 * @inheritdoc
	 */
	public function store(VisitJournal $visitJournal) : VisitJournal {

		return ($visitJournal->getId() > 0) ? $this->update($visitJournal) : $this->create($visitJournal);
	}

	private function create(VisitJournal $visitJournal) : VisitJournal {
		$activeRecord = $this->visitJournalDao->create($this->mapToEntity($visitJournal));
		return $this->mapToDTO($activeRecord);
	}

	private function update(VisitJournal $visitJournal) : VisitJournal {
		$activeRecord = $this->visitJournalDao->update($this->mapToEntity($visitJournal));
		return $this->mapToDTO($activeRecord);
	}


	/**
	 * @inheritdoc
	 */
	public function find(int $id) : VisitJournal {
		$visitJournalEntity = $this->visitJournalDao->find($id);
		return $this->mapToDTO($visitJournalEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		$this->visitJournalDao->delete($id);
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
			function($visit) { return $this->mapToDTO($visit); },
			$this->visitJournalDao->findByLearnplaceId($id)
		);
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\VisitJournal $visitJournalEntity) : VisitJournal {
	$visitJournal = new VisitJournal();
	$visitJournal
		->setId($visitJournalEntity->getPkId())
		->setTime(new DateTime($visitJournalEntity->getTime()))
		->setUserId($visitJournalEntity->getUserId());

	return $visitJournal;
}

	private function mapToEntity(VisitJournal $visitJournal) : \SRAG\Learnplaces\persistence\entity\VisitJournal {

		$activeRecord = ($visitJournal > 0) ? $this->visitJournalDao->find($visitJournal->getId()) : new \SRAG\Learnplaces\persistence\entity\VisitJournal();
		$activeRecord
			->setTime($visitJournal->getTime()->getTimestamp())
			->setUserId($visitJournal->getUserId());

		return $activeRecord;
	}
}