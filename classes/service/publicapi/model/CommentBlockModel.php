<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\CommentBlockDtoMappingAware;

/**
 * Class CommentBlockModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentBlockModel extends BlockModel {

	use CommentBlockDtoMappingAware;

	/**
	 * @var CommentModel[]
	 */
	private $comments = [];


	/**
	 * @return CommentModel[]
	 */
	public function getComments(): array {
		return $this->comments;
	}


	/**
	 * @param CommentModel[] $comments
	 *
	 * @return CommentBlockModel
	 */
	public function setComments(array $comments): CommentBlockModel {
		$this->comments = $comments;

		return $this;
	}

}