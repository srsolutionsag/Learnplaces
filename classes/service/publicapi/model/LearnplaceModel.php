<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\LearnplaceDtoMappingAware;

/**
 * Class Learnplace
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceModel {

	use LearnplaceDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;
	/**
	 * @var int $objectId
	 */
	private $objectId = 0;
	/**
	 * @var ConfigurationModel $configuration
	 */
	private $configuration;
	/**
	 * @var VisitJournalModel[] $visitJournals
	 */
	private $visitJournals = [];
	/**
	 * @var PictureModel[]
	 */
	private $pictures = [];
	/**
	 * @var FeedbackModel[]
	 */
	private $feedback = [];
	/**
	 * @var LocationModel $location
	 */
	private $location;
	/**
	 * @var BlockModel[] $blocks
	 */
	private $blocks = [];


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return LearnplaceModel
	 */
	public function setId(int $id): LearnplaceModel {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getObjectId(): int {
		return $this->objectId;
	}


	/**
	 * @param int $objectId
	 *
	 * @return LearnplaceModel
	 */
	public function setObjectId(int $objectId): LearnplaceModel {
		$this->objectId = $objectId;

		return $this;
	}


	/**
	 * @return ConfigurationModel
	 */
	public function getConfiguration(): ConfigurationModel {
		return $this->configuration;
	}


	/**
	 * @param ConfigurationModel $configuration
	 *
	 * @return LearnplaceModel
	 */
	public function setConfiguration(ConfigurationModel $configuration): LearnplaceModel {
		$this->configuration = $configuration;

		return $this;
	}


	/**
	 * @return VisitJournalModel[]
	 */
	public function getVisitJournals(): array {
		return $this->visitJournals;
	}


	/**
	 * @param VisitJournalModel[] $visitJournals
	 *
	 * @return LearnplaceModel
	 */
	public function setVisitJournals(array $visitJournals): LearnplaceModel {
		$this->visitJournals = $visitJournals;

		return $this;
	}


	/**
	 * @return PictureModel[]
	 */
	public function getPictures(): array {
		return $this->pictures;
	}


	/**
	 * @param PictureModel[] $pictures
	 *
	 * @return LearnplaceModel
	 */
	public function setPictures(array $pictures): LearnplaceModel {
		$this->pictures = $pictures;

		return $this;
	}


	/**
	 * @return FeedbackModel[]
	 */
	public function getFeedback(): array {
		return $this->feedback;
	}


	/**
	 * @param FeedbackModel[] $feedback
	 *
	 * @return LearnplaceModel
	 */
	public function setFeedback(array $feedback): LearnplaceModel {
		$this->feedback = $feedback;

		return $this;
	}


	/**
	 * @return BlockModel[]
	 */
	public function getBlocks(): array {
		return $this->blocks;
	}


	/**
	 * @param BlockModel[] $blocks
	 *
	 * @return LearnplaceModel
	 */
	public function setBlocks(array $blocks): LearnplaceModel {
		$this->blocks = $blocks;

		return $this;
	}


	/**
	 * @return LocationModel
	 */
	public function getLocation(): LocationModel {
		return $this->location;
	}


	/**
	 * @param LocationModel $location
	 *
	 * @return LearnplaceModel
	 */
	public function setLocation(LocationModel $location): LearnplaceModel {
		$this->location = $location;

		return $this;
	}
}