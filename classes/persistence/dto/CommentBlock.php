<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

/**
 * Class CommentBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
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
	public function getComments(): array {
		return $this->comments;
	}


	/**
	 * @param Comment[] $comments
	 *
	 * @return CommentBlock
	 */
	public function setComments(array $comments): CommentBlock {
		$this->comments = $comments;

		return $this;
	}

}