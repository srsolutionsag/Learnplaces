<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\Feedback;
use SRAG\Learnplaces\service\publicapi\model\FeedbackModel;

/**
 * Trait FeedbackDtoMappingAware
 *
 * Adds functionality to map a feedback block model to a feedback block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait FeedbackDtoMappingAware {

	public function toDto(): Feedback {
		/**
		 * @var FeedbackDtoMappingAware|FeedbackModel $this
		 */
		$dto = new Feedback();
		$dto->setId($this->getId())
			->setUserId($this->getUserId())
			->setContent($this->getContent());

		return $dto;
	}
}

/**
 * Trait FeedbackModelMappingAware
 *
 * Adds functionality to map a feedback block dto to a feedback block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait FeedbackModelMappingAware {

	public function toModel(): FeedbackModel {
		/**
		 * @var FeedbackModelMappingAware|Feedback $this
		 */
		$model = new FeedbackModel();
		$model
			->setId($this->getId())
			->setUserId($this->getUserId())
			->setContent($this->getContent());

		return $model;
	}
}