<?php

namespace SRAG\Learnplaces\service\validation\ExternalStream\Rule;

/**
 * Interface ValidationRule
 *
 * Each streaming service has a validation implementation, which verifies the compliance of the url.
 *
 * @package SRAG\Learnplaces\service\validation\ExternalStream\Rule
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface ValidationRule {

	/**
	 * Validates the given url for a specific streaming provider.
	 *
	 * @param string $url   The url which should be validated.
	 *
	 * @return bool         True if the given url is valid for usage, otherwise false.
	 */
	public function isValid(string $url): bool;

}