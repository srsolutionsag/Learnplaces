<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\Configuration;
use SRAG\Learnplaces\service\publicapi\model\ConfigurationModel;

/**
 * Trait ConfigurationDtoMappingAware
 *
 * Adds functionality to map a configuration block model to a configuration block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ConfigurationDtoMappingAware {

	public function toDto(): Configuration {
		/**
		 * @var ConfigurationDtoMappingAware|ConfigurationModel $this
		 */
		$dto = new Configuration();
		$dto->setId($this->getId())
			->setOnline($this->isOnline())
			->setDefaultVisibility($this->getDefaultVisibility())
			->setMapZoomLevel($this->getMapZoomLevel());

		return $dto;
	}
}

/**
 * Trait ConfigurationModelMappingAware
 *
 * Adds functionality to map a configuration block dto to a configuration block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ConfigurationModelMappingAware {

	public function toModel(): ConfigurationModel {
		/**
		 * @var ConfigurationModelMappingAware|Configuration $this
		 */
		$model = new ConfigurationModel();
		$model->setId($this->getId())
			->setOnline($this->isOnline())
			->setDefaultVisibility($this->getDefaultVisibility())
			->setMapZoomLevel($this->getMapZoomLevel());

		return $model;
	}
}