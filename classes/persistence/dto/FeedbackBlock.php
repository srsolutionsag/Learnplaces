<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class FeedbackBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class FeedbackBlock extends Block {

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
	 * @return FeedbackBlock
	 */
	public function setContent(string $content): FeedbackBlock {
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
	 * @return FeedbackBlock
	 */
	public function setUserId(int $userId): FeedbackBlock {
		$this->userId = $userId;

		return $this;
	}

}