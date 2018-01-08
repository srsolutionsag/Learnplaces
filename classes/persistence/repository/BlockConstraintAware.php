<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository;

use SRAG\Learnplaces\persistence\dto\Block;

/**
 * Trait BlockConstraintAware
 *
 * The block constraint aware trait provides a convenience functionality to store the
 * foreign key of the constraint.
 *
 * @package SRAG\Learnplaces\persistence\repository
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
trait BlockConstraintAware {

	/**
	 * Stores the underlying relation of the constraint with the block.
	 *
	 * @param Block $block The block which has a constraint which should be associated with the constraint.
	 *
	 * @return void
	 */
	private function storeBlockConstraint(Block $block) {
		$constraint = $block->getConstraint();

		if(!is_null($constraint)) {
			$constraintClass = get_class($constraint);

			/**
			 * @var \SRAG\Learnplaces\persistence\entity\PictureUploadBlock $constraintEntity
			 */
			$constraintEntity = new $constraintClass($constraint->getId());
			$constraintEntity->setFkBlockId($block->getId());
			$constraintEntity->update();
		}
	}

}