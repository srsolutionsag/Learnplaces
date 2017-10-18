<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class FeedbackBlock
 *
 * @package StuderRaimannCh\Lernplaces\persistence\dto
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
	public function getContent() {
		return $this->content;
	}


	/**
	 * @param string $content
	 *
	 * @return FeedbackBlock
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
	 * @return FeedbackBlock
	 */
	public function setUserId($userId) {
		$this->userId = $userId;

		return $this;
	}
}