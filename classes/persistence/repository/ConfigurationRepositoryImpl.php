<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dao\ConfigurationDao;
use SRAG\Learnplaces\persistence\dao\VisibilityDao;
use SRAG\Learnplaces\persistence\entity\Visibility;
use SRAG\Lernplaces\persistence\dto\Configuration;

class ConfigurationRepositoryImpl implements ConfigurationRepository {

	/**
	 * @var ConfigurationDao $configurationDAO
	 */
	private $configurationDAO;
	/**
	 * @var VisibilityDao $visibilityDAO
	 */
	private $visibilityDAO;


	/**
	 * ConfigurationRepositoryImpl constructor.
	 *
	 * @param ConfigurationDao $configurationDAO
	 * @param VisibilityDao    $visibilityDAO
	 */
	public function __construct(ConfigurationDao $configurationDAO, VisibilityDao $visibilityDAO) {
		$this->configurationDAO = $configurationDAO;
		$this->visibilityDAO = $visibilityDAO;
	}


	/**
	 * @inheritdoc
	 */
	public function store(Configuration $configuration) : Configuration {
		return ($configuration->getId() > 0) ? $this->update($configuration) : $this->create($configuration);
	}

	private function create(Configuration $configuration) : Configuration {
		$activeRecord = $this->configurationDAO->create($this->mapToEntity($configuration));
		return $this->mapToDTO($activeRecord);
	}

	private function update(Configuration $configuration) : Configuration {
		$activeRecord = $this->configurationDAO->update($this->mapToEntity($configuration));
		return $this->mapToDTO($activeRecord);
	}

	/**
	 * @inheritdoc
	 */
	public function find(int $id) : Configuration {
		$configurationEntity = $this->configurationDAO->find($id);
		return $this->mapToDTO($configurationEntity);
	}

	/**
	 * @inheritdoc
	 */
	public function delete(int $id) {
		$this->configurationDAO->delete($id);
	}

	private function mapToDTO(\SRAG\Learnplaces\persistence\entity\Configuration $configurationEntity) : Configuration {
		/**
		 * @var Visibility $visibility
		 */
		$visibility = $this->visibilityDAO->find($configurationEntity->getFkVisibilityDefault());
		$configuration = new Configuration();
		$configuration
			->setId($configurationEntity->getPkId())
			->setDefaultVisibility($visibility->getName())
			->setOnline($configurationEntity->getOnline() === 1);

		return $configuration;
	}

	private function mapToEntity(Configuration $configuration) : \SRAG\Learnplaces\persistence\entity\Configuration {

		/**
		 * @var \SRAG\Learnplaces\persistence\entity\Configuration $activeRecord
		 */
		$activeRecord = ($configuration > 0)
			? $this->configurationDAO->find($configuration->getId())
			: new \SRAG\Learnplaces\persistence\entity\Configuration();

		$visibilityId = $this->visibilityDAO->findByName($configuration->getDefaultVisibility())->getPkId();

		$activeRecord
			->setOnline($configuration->isOnline() ? 1 : 0)
			->setFkVisibilityDefault($visibilityId);

		return $activeRecord;
	}
}