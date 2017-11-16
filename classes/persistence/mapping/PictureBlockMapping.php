<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\PictureBlock;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;

/**
 * Trait PictureBlockDtoMappingAware
 *
 * Adds functionality to map a picture block model to a picture block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait PictureBlockDtoMappingAware {

	public function toDto(): PictureBlock {
		/**
		 * @var PictureBlockDtoMappingAware|PictureBlockModel $this
		 */
		$dto = new PictureBlock();
		$dto->setPicture($this->getPicture()->toDto())
			->setTitle($this->getTitle())
			->setDescription($this->getDescription());
		$this->fillBaseBlock($dto);

		return $dto;
	}
}

/**
 * Trait PictureBlockModelMappingAware
 *
 * Adds functionality to map a picture block dto to a picture block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait PictureBlockModelMappingAware {

	public function toModel(): PictureBlockModel {
		/**
		 * @var PictureBlockModelMappingAware|PictureBlock $this
		 */
		$model = new PictureBlockModel();
		$model
			->setPicture($this->getPicture()->toModel())
			->setTitle($this->getTitle())
			->setDescription($this->getDescription());
		$this->fillBaseBlock($model);

		return $model;
	}
}