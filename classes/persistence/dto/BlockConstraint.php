<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Interface BlockConstraint
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface BlockConstraint {
	/**
	 * @return int
	 */
	public function getId();


	/**
	 * @param int $id
	 *
	 * @return LearnplaceConstraint
	 */
	public function setId($id);
}