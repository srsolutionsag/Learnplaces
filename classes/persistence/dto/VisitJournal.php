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
}