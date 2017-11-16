<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\Answer;
use SRAG\Learnplaces\service\publicapi\model\AnswerModel;

/**
 * Trait AnswerDtoMappingAware
 *
 * Provides the functionality to map an answer model to an answer dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait AnswerDtoMappingAware {

	public function toDto(): Answer {
		/**
		 * @var AnswerModel|AnswerDtoMappingAware $this
		 */
		$dto = new Answer();
		$dto->setId($this->getId())
			->setTitle($this->getTitle())
			->setContent($this->getContent())
			->setUserId($this->getUserId())
			->setPicture($this->getPicture()->toDto())
			->setCreateDate($this->getCreateDate());
		return $dto;
	}

}

/**
 * Trait AnswerModelMappingAware
 *
 * Provides the functionality to map an answer dto to an answer model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait AnswerModelMappingAware {

	public function toModel(): AnswerModel {

		/**
		 * @var Answer|AnswerDtoMappingAware $this
		 */
		$dto = new AnswerModel();
		$dto->setId($this->getId())
			->setTitle($this->getTitle())
			->setContent($this->getContent())
			->setUserId($this->getUserId())
			->setPicture($this->getPicture()->toModel())
			->setCreateDate($this->getCreateDate());
		return $dto;
	}
}