<?php

namespace SRAG\Learnplaces\persistence\dto;

/**
 * Interface BlockConstraint
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface BlockConstraint {

	/**
	 * @return int
	 */
	public function getId(): int;


	/**
	 * @param int $id
	 *
	 * @return BlockConstraint
	 */
	public function setId(int $id): BlockConstraint;


	/**
	 * Maps the curreent block constraint into a block constraint model.
	 *
	 * @return \SRAG\Learnplaces\service\publicapi\model\BlockConstraint
	 */
	public function toModel();
}