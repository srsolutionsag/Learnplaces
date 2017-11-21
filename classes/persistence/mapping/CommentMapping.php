<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\Answer;
use SRAG\Learnplaces\persistence\dto\Comment;
use SRAG\Learnplaces\service\publicapi\model\AnswerModel;
use SRAG\Learnplaces\service\publicapi\model\CommentModel;

/**
 * Trait CommentDtoMappingAware
 *
 * Adds the functionality to map a comment model to a comment dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait CommentDtoMappingAware {

	public function toDto(): Comment {
		/**
		 * @var CommentDtoMappingAware|CommentModel $this
		 */
		$dto = new Comment();
		$dto->setId($this->getId())
			->setCreateDate($this->getCreateDate())
			->setPicture(is_null($this->getPicture()) ? NULL : $this->getPicture()->toDto())
			->setUserId($this->getUserId())
			->setContent($this->getContent())
			->setTitle($this->getTitle())
			->setAnswers($this->mapAnswer($this->getAnswers()));

		return $dto;
	}

	private function mapAnswer(array $answerModels): array {
		return array_map(
			function(AnswerModel $answerDto) { return $answerDto->toDto(); },
			$answerModels
		);
	}
}

/**
 * Trait CommentModelMappingAware
 *
 * Adds the functionality to map a comment dto to a comment model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait CommentModelMappingAware {

	public function toModel(): CommentModel {
		/**
		 * @var CommentModelMappingAware|Comment $this
		 */
		$model = new CommentModel();
		$model->setId($this->getId())
			->setCreateDate($this->getCreateDate())
			->setPicture((is_null($this->getPicture())) ? NULL : $this->getPicture()->toModel())
			->setUserId($this->getUserId())
			->setContent($this->getContent())
			->setTitle($this->getTitle())
			->setAnswers($this->mapAnswer($this->getAnswers()));

		return $model;
	}

	private function mapAnswer(array $answerModels): array {
		return array_map(
			function(Answer $answerDto) { return $answerDto->toModel(); },
			$answerModels
		);
	}
}