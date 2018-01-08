<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\ILIASLinkBlock;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;

/**
 * Trait ILIASLinkBlockDtoMappingAware
 *
 * Adds functionality to map an ILIAS link block model to an ILIAS link block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ILIASLinkBlockDtoMappingAware {

	public function toDto(): ILIASLinkBlock {
		/**
		 * @var ILIASLinkBlockDtoMappingAware|ILIASLinkBlockModel $this
		 */
		$dto = new ILIASLinkBlock();
		$dto->setRefId($this->getRefId());
		$this->fillBaseBlock($dto);

		return $dto;
	}
}

/**
 * Trait ILIASLinkBlockModelMappingAware
 *
 * Adds functionality to map an ILIAS link block dto to a ILIAS link block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait ILIASLinkBlockModelMappingAware {

	public function toModel(): ILIASLinkBlockModel {
		/**
		 * @var ILIASLinkBlockModelMappingAware|ILIASLinkBlock $this
		 */
		$model = new ILIASLinkBlockModel();
		$model->setRefId($this->getRefId());
		$this->fillBaseBlock($model);

		return $model;
	}
}