<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class Learnplace
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Learnplace {

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var string $title;
	 */
	private $title;
	/**
	 * @var string $description
	 */
	private $description;
	/**
	 * @var Configuration $configuration
	 */
	private $configuration;
	/**
	 * @var VisitJournal[] $visitJournals
	 */
	private $visitJournals;


	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Learnplace
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return Learnplace
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}


	/**
	 * @param string $description
	 *
	 * @return Learnplace
	 */
	public function setDescription($description) {
		$this->description = $description;

		return $this;
	}


	/**
	 * @return Configuration
	 */
	public function getConfiguration() {
		return $this->configuration;
	}


	/**
	 * @param Configuration $configuration
	 *
	 * @return Learnplace
	 */
	public function setConfiguration($configuration) {
		$this->configuration = $configuration;

		return $this;
	}


	/**
	 * @return VisitJournal[]
	 */
	public function getVisitJournals() {
		return $this->visitJournals;
	}


	/**
	 * @param VisitJournal[] $visitJournals
	 *
	 * @return Learnplace
	 */
	public function setVisitJournals($visitJournals) {
		$this->visitJournals = $visitJournals;

		return $this;
	}
}