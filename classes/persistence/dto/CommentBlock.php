<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class CommentBlock
 *
 * @package StuderRaimannCh\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentBlock extends Block {

	/**
	 * @var Comment[]
	 */
	private $comments;


	/**
	 * @return Comment[]
	 */
	public function getComments() {
		return $this->comments;
	}


	/**
	 * @param Comment[] $comments
	 *
	 * @return CommentBlock
	 */
	public function setComments($comments) {
		$this->comments = $comments;

		return $this;
	}

}