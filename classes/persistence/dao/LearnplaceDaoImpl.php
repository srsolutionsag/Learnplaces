<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dao;

use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;
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


	/**
	 * @inheritdoc
	 */
	public function findByObjectId(int $id) : Learnplace {

		/**
		 * @var Learnplace $learnplace
		 */
		$learnplace = Learnplace::where(['fk_object_id' => $id])->first();
		if(is_null($learnplace)) {
			throw new EntityNotFoundException("No Learnplace found with object id \"$id\"");
		}

		return $learnplace;
	}
}