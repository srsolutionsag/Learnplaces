<?php
declare(strict_types=1);

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
	 * @return string
	 */
	public function getTitle(): string {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return Learnplace
	 */
	public function setTitle(string $title): Learnplace {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDescription(): string {
		return $this->description;
	}


	/**
	 * @param string $description
	 *
	 * @return Learnplace
	 */
	public function setDescription(string $description): Learnplace {
		$this->description = $description;

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
}