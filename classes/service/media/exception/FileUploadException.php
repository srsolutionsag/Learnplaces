<?php

namespace SRAG\Learnplaces\service\media\exception;

use RuntimeException;

/**
 * Class FileUploadException
 *
 * The file upload exception indicates a problem with the file upload.
 * The exception code always contains the php upload codes.
 *
 * UPLOAD_ERR_OK            = 0 (There is no error, the file uploaded with success, but was not valid for usage.)
 * UPLOAD_ERR_INI_SIZE      = 1 (The uploaded file exceeds the upload_max_filesize directive in php.ini.)
 * UPLOAD_ERR_FORM_SIZE     = 2 (The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.)
 * UPLOAD_ERR_PARTIAL       = 3 (The uploaded file was only partially uploaded.)
 * UPLOAD_ERR_NO_FILE       = 4 (No file was uploaded.)
 * UPLOAD_ERR_NO_TMP_DIR    = 6 (Missing a temporary folder. Introduced in PHP 5.0.3.)
 * UPLOAD_ERR_CANT_WRITE    = 7 (Failed to write file to disk. Introduced in PHP 5.1.0.)
 * UPLOAD_ERR_EXTENSION     = 8 (Value: 8; A PHP extension stopped the file upload. PHP does not provide a way
 *                               to ascertain which extension caused the file upload to stop; examining the list
 *                               of loaded extensions with phpinfo() may help. Introduced in PHP 5.2.0.)
 *
 * @package SRAG\Learnplaces\service\media\exception
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @see https://secure.php.net/manual/en/features.file-upload.errors.php
 */
class FileUploadException extends RuntimeException {

}