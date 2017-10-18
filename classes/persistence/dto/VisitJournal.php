<?php

namespace SRAG\Lernplaces\persistence\dto;

use DateTime;

/**
 * Class VisitJournal
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisitJournal {

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var int $userId
	 */
	private $userId;
	/**
	 * @var DateTime $time
	 */
	private $time;


	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return VisitJournal
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getUserId() {
		return $this->userId;
	}


	/**
	 * @param int $userId
	 *
	 * @return VisitJournal
	 */
	public function setUserId($userId) {
		$this->userId = $userId;

		return $this;
	}


	/**
	 * @return DateTime
	 */
	public function getTime() {
		return $this->time;
	}


	/**
	 * @param DateTime $time
	 *
	 * @return VisitJournal
	 */
	public function setTime($time) {
		$this->time = $time;

		return $this;
	}
}