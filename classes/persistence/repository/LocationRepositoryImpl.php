<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dao\LocationDao;
use SRAG\Learnplaces\persistence\dto\Location;

/**
 * Class LocationRepositoryImpl
 *
 * @package SRAG\Lernplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LocationRepositoryImpl implements LocationRepository {

	/**
	 * @var LocationDao $locationDao
	 */
	private $locationDao;


	/**
	 * LocationRepositoryImpl constructor.
	 *
	 * @param LocationDao $locationDao
	 */
	public function __construct(LocationDao $locationDao) { $this->locationDao = $locationDao; }


	/**
	 * @inheritdoc
	 */
	public function store(Location $location) : Location {

		return ($location->getId() > 0) ? $this->update($location) : $this->create($location);
	}

	private function create(Location $location) : Location {
		$activeRecord = $this->locationDao->create($this->mapToEntity($location));
		return $this->mapToDTO($activeRecord);
	}

	private function update(Location $location) : Location {
		$activeRecord = $this->locationDao->update($this->mapToEntity($location));
		return $this->mapToDTO($activeRecord);
	}


	/**
	 * @inheritdoc
	 */
	public function find(int $id) : Location {
		$locationId = $this->locationDao->find($id);
		return $this->mapToDTO($locationId);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		$this->locationDao->delete($id);
	}


	/**
	 * Maps the active record to the dto.
	 *
	 * @param \SRAG\Learnplaces\persistence\entity\Location $locationEntity The active record which should be mapped to the dto.
	 *
	 * @return Location The newly mapped location dto.
	 */
	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\Location $locationEntity) : Location {
		$location = new Location();
		$location
			->setId($locationEntity->getPkId())
			->setElevation($locationEntity->getElevation())
			->setLatitude($locationEntity->getLatitude())
			->setLongitude($locationEntity->getLongitude())
			->setRadius($locationEntity->getRadius());

		return $location;
	}


	/**
	 * Maps the dto to the active record representation.
	 *
	 * @param Location $location    The location object which should be mapped to the active record.
	 *
	 * @return \SRAG\Learnplaces\persistence\entity\Location The newly mapped active record.
	 */
	private function mapToEntity(Location $location) : \SRAG\Learnplaces\persistence\entity\Location {

		$activeRecord = ($location > 0) ? $this->locationDao->find($location->getId()) : new \SRAG\Learnplaces\persistence\entity\Location();
		$activeRecord
			->setRadius($location->getRadius())
			->setLongitude($location->getLongitude())
			->setLatitude($location->getLatitude())
			->setElevation($location->getElevation());

		return $activeRecord;
	}
}