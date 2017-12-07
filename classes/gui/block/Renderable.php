<?php

namespace SRAG\Learnplaces\gui\block;

/**
 * Interface Renderable
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface Renderable {

	/**
	 * Renders the view into a html representation.
	 *
	 * @return string
	 */
	public function getHtml();
}