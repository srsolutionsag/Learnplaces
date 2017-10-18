<?php

namespace SRAG\Lernplaces\persistence\dto;

use DateTime;

/**
 * Class Comment
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Comment {

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
	 * @var Answer[]
	 */
	private $answers;
	/**
	 * @var Picture $picture
	 */
	private $picture;


	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Comment
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return DateTime
	 */
	public function getCreateDate() {
		return $this->createDate;
	}


	/**
	 * @param DateTime $createDate
	 *
	 * @return Comment
	 */
	public function setCreateDate($createDate) {
		$this->createDate = $createDate;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}


	/**
	 * @param string $title
	 *
	 * @return Comment
	 */
	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}


	/**
	 * @param string $content
	 *
	 * @return Comment
	 */
	public function setContent($content) {
		$this->content = $content;

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
	 * @return Comment
	 */
	public function setUserId($userId) {
		$this->userId = $userId;

		return $this;
	}


	/**
	 * @return Answer[]
	 */
	public function getAnswers() {
		return $this->answers;
	}


	/**
	 * @param Answer[] $answers
	 *
	 * @return Comment
	 */
	public function setAnswers($answers) {
		$this->answers = $answers;

		return $this;
	}


	/**
	 * @return Picture
	 */
	public function getPicture() {
		return $this->picture;
	}


	/**
	 * @param Picture $picture
	 *
	 * @return Comment
	 */
	public function setPicture($picture) {
		$this->picture = $picture;

		return $this;
	}
}
