<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\FeedbackBlock;
use SRAG\Learnplaces\service\publicapi\model\FeedbackBlockModel;

/**
 * Trait FeedbackBlockDtoMappingAware
 *
 * Adds functionality to map a feedback block model to a feedback block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait FeedbackBlockDtoMappingAware {

	public function toDto(): FeedbackBlock {
		/**
		 * @var FeedbackBlockDtoMappingAware|FeedbackBlockModel $this
		 */
		$dto = new FeedbackBlock();
		$this->fillBaseBlock($dto);

		return $dto;
	}
}

/**
 * Trait FeedbackBlockModelMappingAware
 *
 * Adds functionality to map a feedback block dto to a feedback block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait FeedbackBlockModelMappingAware {

	public function toModel(): FeedbackBlockModel {
		/**
		 * @var FeedbackBlockModelMappingAware|FeedbackBlock $this
		 */
		$model = new FeedbackBlockModel();
		$this->fillBaseBlock($model);

		return $model;
	}
}