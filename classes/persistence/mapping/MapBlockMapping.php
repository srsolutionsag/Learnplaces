<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\MapBlock;
use SRAG\Learnplaces\service\publicapi\model\MapBlockModel;

/**
 * Trait MapBlockDtoMappingAware
 *
 * Adds functionality to map a map block model to a map block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait MapBlockDtoMappingAware {

	use BlockDtoMappingAware;

	public function toDto(): MapBlock {
		/**
		 * @var MapBlockDtoMappingAware|MapBlockModel $this
		 */
		$dto = new MapBlock();
		$this->fillBaseBlock($dto);

		return $dto;
	}
}

/**
 * Trait MapBlockModelMappingAware
 *
 * Adds functionality to map a map block dto to a map block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait MapBlockModelMappingAware {

	use BlockModelMappingAware;

	public function toModel(): MapBlockModel {
		/**
		 * @var MapBlockModelMappingAware|MapBlock $this
		 */
		$model = new MapBlockModel();
		$this->fillBaseBlock($model);

		return $model;
	}
}