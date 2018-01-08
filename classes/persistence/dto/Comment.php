<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use DateTime;
use SRAG\Lernplaces\persistence\mapping\CommentModelMappingAware;

/**
 * Class Comment
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Comment {

	use CommentModelMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;
	/**
	 * @var DateTime $createDate
	 */
	private $createDate;
	/**
	 * @var string $title
	 */
	private $title = "";
	/**
	 * @var string $content
	 */
	private $content = "";
	/**
	 * @var int $userId
	 */
	private $userId = 0;
	/**
	 * @var Answer[]
	 */
	private $answers = [];
	/**
	 * @var Picture|null $picture
	 */
	private $picture = NULL;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Comment
	 */
	public function setId(int $id): Comment {
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
	 * @return Comment
	 */
	public function setCreateDate(DateTime $createDate): Comment {
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
	 * @return Comment
	 */
	public function setTitle(string $title): Comment {
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
	 * @return Comment
	 */
	public function setContent(string $content): Comment {
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
	 * @return Comment
	 */
	public function setUserId(int $userId): Comment {
		$this->userId = $userId;

		return $this;
	}


	/**
	 * @return Answer[]
	 */
	public function getAnswers(): array {
		return $this->answers;
	}


	/**
	 * @param Answer[] $answers
	 *
	 * @return Comment
	 */
	public function setAnswers(array $answers): Comment {
		$this->answers = $answers;

		return $this;
	}


	/**
	 * @return null|Picture
	 */
	public function getPicture() {
		return $this->picture;
	}


	/**
	 * @param null|Picture $picture
	 *
	 * @return Comment
	 */
	public function setPicture($picture) {
		$this->picture = $picture;

		return $this;
	}
}
