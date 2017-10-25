<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\CommentBlock;

/**
 * Class CommentBlockDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentBlockDaoImpl extends AbstractCrudBlockDao implements CommentBlockDao {

	/**
	 * CommentBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(CommentBlock::class);
	}
}