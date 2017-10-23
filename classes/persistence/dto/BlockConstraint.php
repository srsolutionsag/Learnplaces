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
	public function getId(): int;


	/**
	 * @param int $id
	 *
	 * @return BlockConstraint
	 */
	public function setId(int $id): BlockConstraint;
}