<?php
declare(strict_types=1);

namespace SRAG\Lernplaces\persistence\dao;

use ActiveRecord;
use SRAG\Learnplaces\persistence\dao\AbstractCrudDao;
use SRAG\Learnplaces\persistence\dao\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\entity\LearnplaceConstraint;

/**
 * Class LearnplaceConstraintDaoImpl
 *
 * @package SRAG\Lernplaces\persistence\dao
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceConstraintDaoImpl extends AbstractCrudDao implements LearnplaceConstraintDao {

	/**
	 * LearnplaceConstraintDaoImpl constructor.
	 */
	public function __construct() {
		parent::__construct(LearnplaceConstraint::class);
	}


	/**
	 * Searches the learnplace constraint which belongs to the given block.
	 * The id is the block id which belongs to the block table.
	 *
	 * @param int $id The id of the block which is used to find the constraint.
	 *
	 * @return ActiveRecord The found learnplace constraint
	 *
	 * @throws EntityNotFoundException
	 *                          Thrown if the block has no learnplace constraint.
	 */
	public function findByBlockId(int $id) : LearnplaceConstraint {

		$recordList = LearnplaceConstraint::where(['fk_block_id' => $id]);
		$result = $recordList->first();

		if(is_null($result))
			throw new EntityNotFoundException("Learnplace constraint with block id \"$id\" was not found.");

		return $result;
	}
}