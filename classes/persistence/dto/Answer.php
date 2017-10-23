<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dto;

use DateTime;

/**
 * Class Answer
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Answer {

	/**
	 * @var int $id
	 */
	private $id;
	/**
	 * @var DateTime $createDate
	 */
	private $createDate;
	/**
	 * @var string $title
	 */
	private $title;
	/**
	 * @var string $content
	 */
	private $content;
	/**
	 * @var int $userId
	 */
	private $userId;
	/**
	 * @var Picture $picture
	 */
	private $picture;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Answer
	 */
	public function setId(int $id): Answer {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return DateTime
	 */
	public function getCreateDate(): DateTime {
		return $this->createDate;
	}


	/**
	 * @param DateTime $createDate
	 *
	 * @return Answer
	 */
	public function setCreateDate(DateTime $createDate): Answer {
		$this->createDate = $createDate;

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
	 * @return Answer
	 */
	public function setTitle(string $title): Answer {
		$this->title = $title;

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
	 * @return Answer
	 */
	public function setContent(string $content): Answer {
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
	 * @return Answer
	 */
	public function setUserId(int $userId): Answer {
		$this->userId = $userId;

		return $this;
	}


	/**
	 * @return Picture
	 */
	public function getPicture(): Picture {
		return $this->picture;
	}


	/**
	 * @param Picture $picture
	 *
	 * @return Answer
	 */
	public function setPicture(Picture $picture): Answer {
		$this->picture = $picture;

		return $this;
	}
}