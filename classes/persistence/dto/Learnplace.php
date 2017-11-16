<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\LearnplaceModelMappingAware;

/**
 * Class Learnplace
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Learnplace {

	use LearnplaceModelMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;
	/**
	 * @var int $objectId
	 */
	private $objectId = 0;
	/**
	 * @var Configuration $configuration
	 */
	private $configuration;
	/**
	 * @var VisitJournal[] $visitJournals
	 */
	private $visitJournals = [];
	/**
	 * @var Picture[]
	 */
	private $pictures = [];
	/**
	 * @var Feedback[]
	 */
	private $feedback = [];
	/**
	 * @var Location $location
	 */
	private $location;
	/**
	 * @var Block[] $blocks
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
	 * @return Learnplace
	 */
	public function setId(int $id): Learnplace {
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
	 * @return Learnplace
	 */
	public function setObjectId(int $objectId): Learnplace {
		$this->objectId = $objectId;

		return $this;
	}


	/**
	 * @return Configuration
	 */
	public function getConfiguration(): Configuration {
		return $this->configuration;
	}


	/**
	 * @param Configuration $configuration
	 *
	 * @return Learnplace
	 */
	public function setConfiguration(Configuration $configuration): Learnplace {
		$this->configuration = $configuration;

		return $this;
	}


	/**
	 * @return VisitJournal[]
	 */
	public function getVisitJournals(): array {
		return $this->visitJournals;
	}


	/**
	 * @param VisitJournal[] $visitJournals
	 *
	 * @return Learnplace
	 */
	public function setVisitJournals(array $visitJournals): Learnplace {
		$this->visitJournals = $visitJournals;

		return $this;
	}


	/**
	 * @return Picture[]
	 */
	public function getPictures(): array {
		return $this->pictures;
	}


	/**
	 * @param Picture[] $pictures
	 *
	 * @return Learnplace
	 */
	public function setPictures(array $pictures): Learnplace {
		$this->pictures = $pictures;

		return $this;
	}


	/**
	 * @return Feedback[]
	 */
	public function getFeedback(): array {
		return $this->feedback;
	}


	/**
	 * @param Feedback[] $feedback
	 *
	 * @return Learnplace
	 */
	public function setFeedback(array $feedback): Learnplace {
		$this->feedback = $feedback;

		return $this;
	}


	/**
	 * @return Block[]
	 */
	public function getBlocks(): array {
		return $this->blocks;
	}


	/**
	 * @param Block[] $blocks
	 *
	 * @return Learnplace
	 */
	public function setBlocks(array $blocks): Learnplace {
		$this->blocks = $blocks;

		return $this;
	}


	/**
	 * @return Location
	 */
	public function getLocation(): Location {
		return $this->location;
	}


	/**
	 * @param Location $location
	 *
	 * @return Learnplace
	 */
	public function setLocation(Location $location): Learnplace {
		$this->location = $location;

		return $this;
	}
}