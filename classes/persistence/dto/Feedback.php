<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

/**
 * Class Feedback
 *
 * @package SRAG\Learnplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Feedback {

	/**
	 * @var string $content
	 */
	private $content;
	/**
	 * @var int $userId
	 */
	private $userId;


	/**
	 * @return string
	 */
	public function getContent(): string {
		return $this->content;
	}


	/**
	 * @param string $content
	 *
	 * @return Feedback
	 */
	public function setContent(string $content): Feedback {
		$this->content = $content;

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
	 * @return Feedback
	 */
	public function setUserId(int $userId): Feedback {
		$this->userId = $userId;

		return $this;
	}
}