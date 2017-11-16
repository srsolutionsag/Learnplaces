<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use DateTime;
use SRAG\Lernplaces\persistence\mapping\CommentDtoMappingAware;

/**
 * Class CommentModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentModel {

	use CommentDtoMappingAware;

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
	 * @var AnswerModel[]
	 */
	private $answers;
	/**
	 * @var PictureModel|null $picture
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
	 * @return CommentModel
	 */
	public function setId(int $id): CommentModel {
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
	 * @return CommentModel
	 */
	public function setCreateDate(DateTime $createDate): CommentModel {
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
	 * @return CommentModel
	 */
	public function setTitle(string $title): CommentModel {
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
	 * @return CommentModel
	 */
	public function setContent(string $content): CommentModel {
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
	 * @return CommentModel
	 */
	public function setUserId(int $userId): CommentModel {
		$this->userId = $userId;

		return $this;
	}


	/**
	 * @return AnswerModel[]
	 */
	public function getAnswers(): array {
		return $this->answers;
	}


	/**
	 * @param AnswerModel[] $answers
	 *
	 * @return CommentModel
	 */
	public function setAnswers(array $answers): CommentModel {
		$this->answers = $answers;

		return $this;
	}


	/**
	 * @return null|PictureModel
	 */
	public function getPicture() {
		return $this->picture;
	}


	/**
	 * @param null|PictureModel $picture
	 *
	 * @return CommentModel
	 */
	public function setPicture($picture) {
		$this->picture = $picture;

		return $this;
	}
}
