<?php

namespace SRAG\Learnplaces\service\media;

use LogicException;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\publicapi\model\VideoModel;

/**
 * Interface VideoService
 *
 * The video service creates new video models from uploaded videos.
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
interface VideoService {

	/**
	 * Stores an uploaded video.
	 *
	 * Allowed file formats:
	 * *.mp4
	 *
	 * @param int $objectId     The object id of the learnplace.
	 *
	 * @return VideoModel       The newly created video model.
	 *
	 * @throws LogicException   Thrown if the storeUpload method was called without actual upload.
	 * @throws FileUploadException
	 *                          Thrown if the upload failed or the uploaded file was invalid.
	 */
	public function storeUpload(int $objectId): VideoModel;

}