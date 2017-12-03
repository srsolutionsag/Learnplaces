<?php

namespace SRAG\Learnplaces\service\media;

use LogicException;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\publicapi\model\PictureModel;

/**
 * Interface PictureService
 *
 * The picture service creates new picture models from uploaded pictures.
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface PictureService {

	/**
	 * Stores the uploaded picture in the {WEB ROOT}/data/{CLIENT ID}/xsrl_{OBJECT ID} directory.
	 * The original and preview picture will both have a distinct UID as name.
	 *
	 * Allowed file formats:
	 * *.png
	 * *.jpg
	 *
	 * The returned picture is already persistent.
	 *
	 * @param int $objectId The object id of the current learnplace.
	 *
	 * @return PictureModel     The newly created picture model of the uploaded picture.
	 *
	 * @throws LogicException   Thrown if the storeUpload was called without actual upload.
	 * @throws FileUploadException
	 *                          Thrown if the upload failed or the uploaded file was invalid.
	 */
	public function storeUpload(int $objectId): PictureModel;


	/**
	 * Deletes the picture with the given id.
	 *
	 * @param int $pictureId    The picture with the id which should be deleted.
	 *
	 * @return void
	 */
	public function delete(int $pictureId);
}