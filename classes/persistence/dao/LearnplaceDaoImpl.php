<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\entity\Learnplace;

/**
 * Class LearnplaceDaoImpl
 *
 * @package SRAG\Learnplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceDaoImpl extends AbstractCrudDao implements LearnplaceDao {

	/**
	 * LearnplaceDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(Learnplace::class);
	}
}