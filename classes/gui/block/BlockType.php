<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block;

/**
 * Interface BlockType
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface BlockType {

	const PICTURE_UPLOAD = 1;
	const MAP = 2;
	const PICTURE = 3;
	const ILIAS_LINK = 4;
	const ACCORDION = 5;
	const RICH_TEXT = 6;
	const VIDEO = 7;

}