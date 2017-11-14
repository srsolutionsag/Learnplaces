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
	 * @var int $id
	 */
	private $id;

	/**
	 * @var string $content
	 */
	private $content;
	/**
	 * @var int $userId
	 */
	private $userId;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Feedback
	 */
	public function setId(int $id): Feedback {
		$this->id = $id;

		return $this;
	}

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