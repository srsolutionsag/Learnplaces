<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\AbstractCrudDao;
use SRAG\Learnplaces\persistence\entity\Comment;

/**
 * Class CommentDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentDaoImpl extends AbstractCrudDao implements CommentDao {

	/**
	 * CommentDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Comment::class);
	}


	/**
	 * Searches all comments which belong to the comment block with the given id.
	 *
	 * @param int $id The comment block id which should be used to search for the comments.
	 *
	 * @return Comment[] All comments which belong to the given comment block.
	 */
	public final function findByCommentBlockId(int $id) : array {
		$recordList = Comment::where(['fk_comment_block' => $id]);
		return $recordList->get();
	}
}