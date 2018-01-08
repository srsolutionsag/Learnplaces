<?php

namespace SRAG\Learnplaces\service\media\wrapper;

use RuntimeException;

/**
 * Interface FileTypeDetector
 *
 * Tiny wrapper for the wapmorgan/file-type-detector Detector class.
 *
 * @package SRAG\Learnplaces\service\media\wrapper
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface FileTypeDetector {

	/**
	 * Detects the type by filename.
	 *
	 * The result array is structured like this:
	 *
	 * [0] - Type of file (Detector::AUDIO and so on)
	 * [1] - Format of file (Detector::MP3 and so on)
	 * [2] - Mime type of file ('audio/mpeg' for example)
	 *
	 * @param string $filename  The filename which should be used to detect the file type.
	 *
	 * @return string[]         The result array containing the file types.
	 *
	 * @throws RuntimeException Thrown if the detection failed.
	 */
	public function detectByFilename(string $filename): array;

	/**
	 * Detects the type of the file by its content.
	 *
	 * The result array is structured like this:
	 *
	 * [0] - Type of file (Detector::AUDIO and so on)
	 * [1] - Format of file (Detector::MP3 and so on)
	 * [2] - Mime type of file ('audio/mpeg' for example)
	 *
	 * @param string $pathToFile    The path to the file which should be used to detect the type.
	 *
	 * @return string[]             The result array containing the file types.
	 *
	 * @throws RuntimeException     Thrown if the detection failed.
	 */
	public function detectByContent(string $pathToFile): array;

}