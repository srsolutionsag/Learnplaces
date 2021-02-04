<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\filesystem;

use ilLearnplacesPlugin;
use ilUtil;
use function realpath;
use function explode;
use function count;
use function ltrim;
use function strtolower;

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

		$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
		$filePath = $path . '.' . $extension;

		return $filePath;
	}

	public static function generatePluginInternalPathFrom(string $relativePath): string {
	    $pathParts = explode('/', ltrim($relativePath, './'));
	    $pathLength = count($pathParts);
	    $parentFolder = $pathParts[$pathLength - 2];
	    $file = $pathParts[$pathLength - 1];

	    if (strlen($relativePath) === 0) {
	        return '';
        }
	    return "./$parentFolder/$file";
    }

    public static function generateRelativePathFrom(string $pluginInternalPath): string {
	    if (strlen($pluginInternalPath) === 0) {
	        return '';
        }
        $pathEnd = ltrim($pluginInternalPath, './');
        return ilUtil::getWebspaceDir() . '/' . $pathEnd;
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