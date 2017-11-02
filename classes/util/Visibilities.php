<?php

namespace SRAG\Learnplaces\util;

/**
 * Interface Visibilities
 *
 * Lists all valid visibilities for the learnplace blocks.
 *
 * @package SRAG\Learnplaces\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface Visibilities {

	/**
	 * The block is always visible.
	 */
	const ALWAYS = "ALWAYS";
	/**
	 * The block is only temporary visible at the learnplace location.
	 */
	const ONLY_AT_PLACE = "ONLY_AT_PLACE";
	/**
	 * The block must be unlocked with a visit of a place, but
	 * is permanently visible afterwards.
	 */
	const AFTER_VISIT_PLACE = "AFTER_VISIT_PLACE";
	/**
	 * First an other place has to be visited to unlock the block permanently.
	 */
	const AFTER_VISIT_OTHER_PLACE = "AFTER_VISIT_OTHER_PLACE";
}