<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use arException;
use ilDatabaseException;
use SRAG\Learnplaces\persistence\dto\Configuration;
use SRAG\Learnplaces\persistence\entity\Learnplace;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;

class ConfigurationRepositoryImpl implements ConfigurationRepository {

	/**
	 * @inheritdoc
	 */
	public function store(Configuration $configuration) : Configuration {
		$activeRecord = $this->mapToEntity($configuration);
		$activeRecord->store();
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id) : Configuration {
		try {
			$configurationEntity = \SRAG\Learnplaces\persistence\entity\Configuration::findOrFail($id);
			return $this->mapToDTO($configurationEntity);
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Configuration with id \"$id\" not found.", $ex);
		}
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		try {
			$configurationEntity = \SRAG\Learnplaces\persistence\entity\Configuration::findOrFail($id);
			$configurationEntity->delete();
		}
		catch (arException $ex) {
			throw new EntityNotFoundException("Configuration with id \"$id\" not found.", $ex);
		}
		catch(ilDatabaseException $ex) {
			throw new ilDatabaseException("Unable to delete configuration with id \"$id\"");
		}
	}


	/**
	 * @inheritDoc
	 */
	public function findByObjectId(int $objectId): Configuration {

		$configurationEntity = \SRAG\Learnplaces\persistence\entity\Configuration
			::innerjoinAR(new Learnplace(), 'pk_id', 'fk_configuration')
			->where([Learnplace::returnDbTableName().'.fk_object_id' => $objectId])
			->first();

		if(is_null($configurationEntity))
			throw new EntityNotFoundException("No configuration ");

		return $this->mapToDTO($configurationEntity);
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\Configuration $configurationEntity) : Configuration {

		try {
			/**
			 * @var Visibility $visibility
			 */
			$visibility = Visibility::findOrFail($configurationEntity->getFkVisibilityDefault());
			$configuration = new Configuration();
			$configuration
				->setId($configurationEntity->getPkId())
				->setDefaultVisibility($visibility->getName())
				->setOnline($configurationEntity->getObjectOnline() === 1)
				->setMapZoomLevel($configurationEntity->getMapZoomLevel());

			return $configuration;
		}
		catch (arException $ex) {
			$id = $configurationEntity->getFkVisibilityDefault();
			throw new EntityNotFoundException("Visibility with id \"$id\" not found", $ex);
		}

	}

	private function mapToEntity(Configuration $configuration) : \SRAG\Learnplaces\persistence\entity\Configuration {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\Configuration $activeRecord
		 */
		$activeRecord = new \SRAG\Learnplaces\persistence\entity\Configuration($configuration->getId());

		/**
		 * @var Visibility $visibility
		 */
		$visibility = Visibility::where(['name' => $configuration->getDefaultVisibility()])->first();

		$activeRecord
			->setObjectOnline($configuration->isOnline() ? 1 : 0)
			->setFkVisibilityDefault($visibility->getPkId())
			->setMapZoomLevel($configuration->getMapZoomLevel());

		return $activeRecord;
	}
}