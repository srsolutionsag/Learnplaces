<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\Learnplace;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;

/**
 * Trait LearnplaceDtoMappingAware
 *
 * Defines the mapping of the accordion block model to the accordion block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 */
trait LearnplaceDtoMappingAware {

	public function toDto(): Learnplace {
		/**
		 * @var LearnplaceModel|LearnplaceDtoMappingAware $this
		 */

		$dto = new Learnplace();
		$dto
			->setId($this->getId())
			->setBlocks($this->mapModelArrayToDtoArray($this->getBlocks()))
			->setFeedback($this->mapModelArrayToDtoArray($this->getFeedback()))
			->setLocation($this->getLocation()->toDto())
			->setPictures($this->mapModelArrayToDtoArray($this->getPictures()))
			->setObjectId($this->getObjectId())
			->setVisitJournals($this->mapModelArrayToDtoArray($this->getVisitJournals()))
			->setConfiguration($this->getConfiguration()->toDto());


		return $dto;
	}


	/**
	 * @internal only for trait internal use!
	 *
	 * This method assumes that all models implement their respective dto mapping aware trait.
	 *
	 * @param array $models An array of models which should be converted to dtos.
	 *
	 * @return array        An array of mapped dtos.
	 */
	private function mapModelArrayToDtoArray(array $models) : array {

		$dtos = array_map(
			function($model) {return $model->toDto();},
			$models
		);

		return $dtos;
	}

}

/**
 * Trait LearnplaceModelMappingAware
 *
 * Defines the mapping of the accordion block dto to the accordion block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait LearnplaceModelMappingAware {

	public function toModel(): LearnplaceModel {
		/**
		 * @var Learnplace|LearnplaceModelMappingAware $this
		 */

		$model = new LearnplaceModel();
		$model
			->setId($this->getId())
			->setBlocks($this->mapDtoArrayToModelArray($this->getBlocks()))
			->setFeedback($this->mapDtoArrayToModelArray($this->getFeedback()))
			->setLocation($this->getLocation()->toModel())
			->setPictures($this->mapDtoArrayToModelArray($this->getPictures()))
			->setObjectId($this->getObjectId())
			->setVisitJournals($this->mapDtoArrayToModelArray($this->getVisitJournals()))
			->setConfiguration($this->getConfiguration()->toModel());

		return $model;
	}

	/**
	 * @internal only for trait internal use!
	 *
	 * This method assumes that all dtos implement their respective model mapping aware trait.
	 *
	 * @param array $dtos An array of dtos which should be converted to models.
	 *
	 * @return array        An array of mapped models.
	 */
	private function mapDtoArrayToModelArray(array $dtos) : array {

		$models = array_map(
			function($model) {return $model->toModel();},
			$dtos
		);

		return $models;
	}
}