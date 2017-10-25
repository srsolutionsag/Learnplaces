<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\RichTextBlock;

/**
 * Class RichTextBlock
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class RichTextBlockDaoImpl extends AbstractCrudBlockDao implements RichTextBlockDao {

	/**
	 * RichTextBlockDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(RichTextBlock::class);
	}
}