<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\filesystem;

use ilLearnplacesPlugin;
use ilUtil;
use function realpath;

/**
 * Class PathHelper
 *
 * Provides helper methods to generate and handle filesystem paths.
 *
 * @package SRAG\Learnplaces\service\filesystem
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PathHelper {

	/**
	 * Generate a file path for a file which belongs to the learnplace with the given object id.
	 * The path pattern is: ./data/{CLIENT ID}/{PLUGIN ID}_{OBJECT ID}/{PLUGIN ID}{UID}.{EXT}
	 *
	 * @param int    $objectId  The object id of the learnplace.
	 * @param string $filename  The name of the file which should be used to generate the path.
	 *
	 * @return string           The generated unique path.
	 */
	public static function generatePath(int $objectId, string $filename): string {
		$path =
			ilUtil::getWebspaceDir()
			. '/'
			. ilLearnplacesPlugin::PLUGIN_ID
			. '_'
			. strval($objectId)
			. '/'
			. uniqid(ilLearnplacesPlugin::PLUGIN_ID, true);

		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$filePath = $path . '.' . $extension;

		return $filePath;
	}


	/**
	 * Creates an absolute path.
	 * Please not that this method is currently filesystem dependent.
	 *
	 * @param string $relativePath  The relative path which should be used.
	 *
	 * @return string               The absolute path.
	 */
	public static function createAbsolutePath(string $relativePath): string {
		return realpath($relativePath);
	}
}