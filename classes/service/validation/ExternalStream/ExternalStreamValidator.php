<?php

namespace SRAG\Learnplaces\service\validation\ExternalStream;

/**
 * Interface ExternalStreamValidator
 *
 * The external stream validator validates external streaming service urls like youtube and vimeo.
 *
 * @package SRAG\Learnplaces\service\validation\ExternalStream
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ExternalStreamValidator {

	/**
	 * Checks if the given url belongs to an allowed service and that the url is valid in general.
	 *
	 * @param string $url   The url which should be validated.
	 *
	 * @return bool         True if the url is valid otherwise false.
	 */
	public function isValid(string $url): bool;
}