<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\media;

use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use SRAG\Learnplaces\service\filesystem\PathHelper;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\media\wrapper\FileTypeDetector;
use SRAG\Learnplaces\service\publicapi\model\VideoModel;
use wapmorgan\FileTypeDetector\Detector;

/**
 * Class VideoServiceImpl
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoServiceImpl implements VideoService {

	/**
	 * The video service will only accept uploads with the whitelisted extensions.
	 *
	 * @var string[] $allowedVideoTypes
	 */
	private static $allowedVideoTypes = [
		Detector::MP4
	];

	/**
	 * @var ServerRequestInterface $request
	 */
	private $request;

	/**
	 * @var FileTypeDetector $fileTypeDetector
	 */
	private $fileTypeDetector;


	/**
	 * VideoServiceImpl constructor.
	 *
	 * @param $request
	 * @param $fileTypeDetector
	 */
	public function __construct($request, $fileTypeDetector) {
		$this->request = $request;
		$this->fileTypeDetector = $fileTypeDetector;
	}


	/**
	 * @inheritDoc
	 */
	public function storeUpload(int $objectId): VideoModel {
		if(!$this->hasUploadedFiles())
			throw new LogicException('Unable to store video without upload.');

		/**
		 * @var UploadedFileInterface $file
		 */
		$file = $this->request->getUploadedFiles()[0];
		$this->validateUpload($file);
		$videoPath = PathHelper::generatePath($objectId, $file->getClientFilename() ?? '');
		$file->moveTo($videoPath);
		$this->validateVideoContent($videoPath);

		$videoModel = new VideoModel();
		$videoModel->setVideoPath($videoPath);

		return $videoModel;
	}

	private function hasUploadedFiles(): bool {
		$files =  $this->request->getUploadedFiles();
		return count($files) > 0;
	}

	private function validateUpload(UploadedFileInterface $file) {
		if($file->getError() !== UPLOAD_ERR_OK)
			throw new FileUploadException('Unable to store video due to an upload error.', $file->getError());

		$typeInfo = $this->fileTypeDetector->detectByFilename($file->getClientFilename() ?? '');

		if(in_array($typeInfo[1], self::$allowedVideoTypes) === false)
			throw new FileUploadException('Video with invalid extension uploaded.');
	}

	private function validateVideoContent(string $pathToPicture) {
		$typeInfo = $this->fileTypeDetector->detectByContent($pathToPicture);

		if(in_array($typeInfo[1], self::$allowedVideoTypes) === false)
			throw new FileUploadException('Video with invalid content uploaded.');
	}

}