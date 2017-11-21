<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use DateTime;
use SRAG\Lernplaces\persistence\mapping\VisitJournalDtoMappingAware;

/**
 * Class VisitJournal
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisitJournalModel {

	use VisitJournalDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;
	/**
	 * @var int $userId
	 */
	private $userId = 0;
	/**
	 * @var DateTime $time
	 */
	private $time;


	/**
	 * VisitJournalModel constructor.
	 */
	public function __construct() {
		$this->time = new DateTime();
	}


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return VisitJournalModel
	 */
	public function setId(int $id): VisitJournalModel {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getUserId(): int {
		return $this->userId;
	}


	/**
	 * @param int $userId
	 *
	 * @return VisitJournalModel
	 */
	public function setUserId(int $userId): VisitJournalModel {
		$this->userId = $userId;

		return $this;
	}


	/**
	 * @return DateTime
	 */
	public function getTime(): DateTime {
		return $this->time;
	}


	/**
	 * @param DateTime $time
	 *
	 * @return VisitJournalModel
	 */
	public function setTime(DateTime $time): VisitJournalModel {
		$this->time = $time;

		return $this;
	}
}