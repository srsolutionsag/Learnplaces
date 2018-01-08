<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use DateTime;
use SRAG\Lernplaces\persistence\mapping\AnswerDtoMappingAware;

/**
 * Class AnswerModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class AnswerModel {

	use AnswerDtoMappingAware;

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
	 * @var PictureModel|null $picture
	 */
	private $picture = NULL;


	/**
	 * AnswerModel constructor.
	 */
	public function __construct() {
		$this->createDate = new DateTime();
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
	 * @return AnswerModel
	 */
	public function setId(int $id): AnswerModel {
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
	 * @return AnswerModel
	 */
	public function setCreateDate(DateTime $createDate): AnswerModel {
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
	 * @return AnswerModel
	 */
	public function setTitle(string $title): AnswerModel {
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
	 * @return AnswerModel
	 */
	public function setContent(string $content): AnswerModel {
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
	 * @return AnswerModel
	 */
	public function setUserId(int $userId): AnswerModel {
		$this->userId = $userId;

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
	 * @return AnswerModel
	 */
	public function setPicture($picture) {
		$this->picture = $picture;

		return $this;
	}
}