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


	/**
	 * Sets if the view should only contain the read permission part or everything.
	 *
	 * @param bool $readonly    True if everything should be rendered or false to render only the readonly view.
	 *
	 * @return void
	 */
	public function setReadonly(bool $readonly);
}