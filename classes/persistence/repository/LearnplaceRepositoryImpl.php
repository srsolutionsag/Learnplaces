<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dao\LearnplaceDao;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Lernplaces\persistence\repository\LocationRepository;

/**
 * Class LearnplaceRepositoryImpl
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceRepositoryImpl implements LearnplaceRepository {

	/**
	 * @var LocationRepository $locationRepository
	 */
	private $locationRepository;
	/**
	 * @var VisitJournalRepository $visitJournalRepository
	 */
	private $visitJournalRepository;
	/**
	 * @var ConfigurationRepository $configurationRepository
	 */
	private $configurationRepository;
	/**
	 * @var LearnplaceDao $learnplaceDAO
	 */
	private $learnplaceDAO;


	/**
	 * LearnplaceRepositoryImpl constructor.
	 *
	 * @param LocationRepository      $locationRepository
	 * @param VisitJournalRepository  $visitJournalRepository
	 * @param ConfigurationRepository $configurationRepository
	 * @param LearnplaceDao           $learnplaceDAO
	 */
	public function __construct(
		LocationRepository $locationRepository,
		VisitJournalRepository $visitJournalRepository,
		ConfigurationRepository $configurationRepository,
		LearnplaceDao $learnplaceDAO
	) {

		$this->locationRepository = $locationRepository;
		$this->visitJournalRepository = $visitJournalRepository;
		$this->configurationRepository = $configurationRepository;
		$this->learnplaceDAO = $learnplaceDAO;
		//TODO: finalize after all block repositories are done.
	}

	/**
	 * @inheritdoc
	 */
	public function store(Learnplace $learnplace) : Learnplace {
		return ($learnplace->getId() > 0) ? $this->update($learnplace) : $this->create($learnplace);
	}

	private function create(Learnplace $learnplace) : Learnplace {
		$activeRecord = $this->learnplaceDAO->create($this->mapToEntity($learnplace));
		return $this->mapToDTO($activeRecord);
	}

	private function update(Learnplace $learnplace) : Learnplace {
		$activeRecord = $this->learnplaceDAO->update($this->mapToEntity($learnplace));
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id): Learnplace {
		$learnplaceEntity = $this->learnplaceDAO->find($id);
		return $this->mapToDTO($learnplaceEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function findByObjectId(int $id) : Learnplace {
		$learnplaceEntity = $this->learnplaceDAO->findByObjectId($id);
		return $this->mapToDTO($learnplaceEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		$this->learnplaceDAO->delete($id);
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\Learnplace $learnplaceEntity) : Learnplace {

		$learnplace = new Learnplace();
		$learnplace
			->setId($learnplaceEntity->getPkId())
			->setConfiguration($this->configurationRepository->find($learnplaceEntity->getFkConfiguration()))
			->setVisitJournals($this->visitJournalRepository->findByLearnplaceId($learnplaceEntity->getPkId()))
			->setObjectId($learnplaceEntity->getFkObjectId());

		return $learnplace;
	}

	private function mapToEntity(Learnplace $learnplace) : \SRAG\Learnplaces\persistence\entity\Learnplace {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\Learnplace $activeRecord
		 */
		$activeRecord = ($learnplace > 0)
			? $this->learnplaceDAO->find($learnplace->getId())
			: new \SRAG\Learnplaces\persistence\entity\Learnplace();

		$activeRecord
			->setFkConfiguration($learnplace->getConfiguration()->getId())
			->setFkObjectId($learnplace->getObjectId());

		return $activeRecord;
	}
}