<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\mapping;

use SRAG\Learnplaces\persistence\dto\VisitJournal;
use SRAG\Learnplaces\service\publicapi\model\VisitJournalModel;

/**
 * Trait VisitJournalDtoMappingAware
 *
 * Adds functionality to map a visit journal block model to a visit journal block dto.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait VisitJournalDtoMappingAware {

	public function toDto(): VisitJournal {
		/**
		 * @var VisitJournalDtoMappingAware|VisitJournalModel $this
		 */
		$dto = new VisitJournal();
		$dto->setId($this->getId())
			->setTime($this->getTime())
			->setUserId($this->getUserId());

		return $dto;
	}
}

/**
 * Trait VisitJournalModelMappingAware
 *
 * Adds functionality to map a visit journal block dto to a visit journal block model.
 *
 * @package SRAG\Lernplaces\persistence\mapping
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait VisitJournalModelMappingAware {

	public function toModel(): VisitJournalModel {
		/**
		 * @var VisitJournalModelMappingAware|VisitJournal $this
		 */
		$model = new VisitJournalModel();
		$model
			->setId($this->getId())
			->setTime($this->getTime())
			->setUserId($this->getUserId());

		return $model;
	}
}