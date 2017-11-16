<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\ExternalStreamBlock;
use SRAG\Learnplaces\service\publicapi\model\ExternalStreamBlockModel;

/**
 * Trait ExternalStreamBlockDtoMappingAware
 *
 * Adds functionality to map a external stream block model to a external stream block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ExternalStreamBlockDtoMappingAware {

	public function toDto(): ExternalStreamBlock {
		/**
		 * @var ExternalStreamBlockDtoMappingAware|ExternalStreamBlockModel $this
		 */
		$dto = new ExternalStreamBlock();
		$dto->setUrl($this->getUrl());
		$this->fillBaseBlock($dto);

		return $dto;
	}
}

/**
 * Trait ExternalStreamBlockModelMappingAware
 *
 * Adds functionality to map a external stream block dto to a external stream block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ExternalStreamBlockModelMappingAware {

	public function toModel(): ExternalStreamBlockModel {
		/**
		 * @var ExternalStreamBlockModelMappingAware|ExternalStreamBlock $this
		 */
		$model = new ExternalStreamBlockModel();
		$model->setUrl($this->getUrl());
		$this->fillBaseBlock($model);

		return $model;
	}
}