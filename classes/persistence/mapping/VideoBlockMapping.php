<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\VideoBlock;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;
use SRAG\Learnplaces\service\filesystem\PathHelper;

/**
 * Trait VideoBlockDtoMappingAware
 *
 * Adds functionality to map a video block model to a video block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait VideoBlockDtoMappingAware {

	public function toDto(): VideoBlock {
		/**
		 * @var VideoBlockDtoMappingAware|VideoBlockModel $this
		 */
		$dto = new VideoBlock();
		$dto
			->setPath(PathHelper::generatePluginInternalPathFrom($this->getPath()))
			->setCoverPath(PathHelper::generatePluginInternalPathFrom($this->getCoverPath()));

		$this->fillBaseBlock($dto);

		return $dto;
	}
}

/**
 * Trait VideoBlockModelMappingAware
 *
 * Adds functionality to map a video block dto to a video block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait VideoBlockModelMappingAware {

	public function toModel(): VideoBlockModel {
		/**
		 * @var VideoBlockModelMappingAware|VideoBlock $this
		 */
		$model = new VideoBlockModel();
		$model
			->setPath(PathHelper::generateRelativePathFrom($this->getPath()))
			->setCoverPath(PathHelper::generateRelativePathFrom($this->getCoverPath()));
		$this->fillBaseBlock($model);

		return $model;
	}
}