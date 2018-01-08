<?php

namespace SRAG\Learnplaces\service\validation\ExternalStream\Rule;

use function Sabre\Uri\normalize;
use function Sabre\Uri\parse;

/**
 * Class YoutubeValidationRule
 *
 * @package SRAG\Learnplaces\service\validation\ExternalStream\Rule
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class YoutubeValidationRule implements ValidationRule {

	/**
	 * @inheritDoc
	 */
	public function isValid(string $url): bool {
		$normalizedUrl = normalize($url);
		$matches = [];
		$matchCount = preg_match('/(?:.+?)?(?:\/v\/|watch\/|\?v=|\&v=|youtu\.be\/|\/v=|^youtu\.be\/|watch\%3Fv\%3D)([a-zA-Z0-9_-]{11})+/g', $normalizedUrl, $matches);

		if($matchCount === 1) {

		}
	}
}