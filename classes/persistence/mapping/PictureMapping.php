<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\Picture;
use SRAG\Learnplaces\service\publicapi\model\PictureModel;

/**
 * Trait PictureDtoMappingAware
 *
 * Adds the functionality to map a picture model to a picture dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait PictureDtoMappingAware {

	public function toDto(): Picture {

		/**
		 * @var PictureModel|PictureDtoMappingAware $this
		 */
		$dto = new Picture();
		$dto->setPreviewPath($this->getPreviewPath())
			->setOriginalPath($this->getOriginalPath())
			->setId($this->getId());

		return $dto;
	}
}

/**
 * Trait PictureModelMappingAware
 *
 * Adds the functionality to map a picture dto to a picture model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait PictureModelMappingAware {

	public function toModel() : PictureModel {
		/**
		 * @var Picture|PictureDtoMappingAware $this
		 */
		$model = new PictureModel();
		$model->setPreviewPath($this->getPreviewPath())
			->setOriginalPath($this->getOriginalPath())
			->setId($this->getId());

		return $model;
	} 
}