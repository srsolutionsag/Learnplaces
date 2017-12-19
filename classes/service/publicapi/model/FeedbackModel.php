<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\FeedbackDtoMappingAware;

/**
 * Class Feedback
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class FeedbackModel {

	use FeedbackDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;

	/**
	 * @var string $content
	 */
	private $content = "";
	/**
	 * @var int $userId
	 */
	private $userId = 0;


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return FeedbackModel
	 */
	public function setId(int $id): FeedbackModel {
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
	 * @return FeedbackModel
	 */
	public function setContent(string $content): FeedbackModel {
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
	 * @return FeedbackModel
	 */
	public function setUserId(int $userId): FeedbackModel {
		$this->userId = $userId;

		return $this;
	}
}