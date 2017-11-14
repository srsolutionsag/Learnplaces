<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\repository;

use arException;
use ilDatabaseException;
use function is_null;
use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\persistence\dto\Location;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

/**
 * Class LocationRepositoryImpl
 *
 * @package SRAG\Lernplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LocationRepositoryImpl implements LocationRepository {


	/**
	 * @inheritdoc
	 */
	public function store(Location $location) : Location {
		$activeRecord = $this->mapToEntity($location);
		$activeRecord->store();
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id) : Location {
		try {
			$locationId = \SRAG\Learnplaces\persistence\entity\Location::findOrFail($id);
			return $this->mapToDTO($locationId);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Location not found with id \"$id\"", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$location = \SRAG\Learnplaces\persistence\entity\Location::findOrFail($id);
			$location->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Location not found with id \"$id\"", $ex);
		}
		catch (ilDatabaseException $ex) {
			throw new ilDatabaseException("Unable to delete location with id \"$id\"");
		}
	}


	/**
	 * @inheritdoc
	 */
	public function findByLearnplace(Learnplace $learnplace) : Location {

		$id = $learnplace->getId();

		$location = \SRAG\Learnplaces\persistence\entity\Location::where(['fk_learnplace_id' => $id])->first();
		if(is_null($location))
			throw new EntityNotFoundException("Location not found with id \"$id\"");

		return $this->mapToDTO($location);
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

		$activeRecord = new \SRAG\Learnplaces\persistence\entity\Location($location->getId());
		$activeRecord
			->setRadius($location->getRadius())
			->setLongitude($location->getLongitude())
			->setLatitude($location->getLatitude())
			->setElevation($location->getElevation());

		return $activeRecord;
	}
}