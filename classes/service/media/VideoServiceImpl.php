<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\media;

use League\Flysystem\FilesystemInterface;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;
use SRAG\Learnplaces\service\filesystem\PathHelper;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\media\wrapper\FileTypeDetector;
use SRAG\Learnplaces\service\publicapi\model\VideoModel;
use wapmorgan\FileTypeDetector\Detector;
use function array_pop;

/**
 * Class VideoServiceImpl
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class VideoServiceImpl implements VideoService {

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
	 * @var FilesystemInterface $filesystem
	 */
	private $filesystem;


	/**
	 * VideoServiceImpl constructor.
	 *
	 * @param ServerRequestInterface $request
	 * @param FileTypeDetector       $fileTypeDetector
	 * @param FilesystemInterface    $filesystem
	 */
	public function __construct(ServerRequestInterface $request, FileTypeDetector $fileTypeDetector, FilesystemInterface $filesystem) {
		$this->request = $request;
		$this->fileTypeDetector = $fileTypeDetector;
		$this->filesystem = $filesystem;
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
		$file = array_pop($this->request->getUploadedFiles());
		$this->validateUpload($file);
		$videoPath = PathHelper::generatePath($objectId, $file->getClientFilename() ?? '');

		$this->filesystem->putStream($videoPath, $file->getStream()->detach());
		$this->validateVideoContent($videoPath);

		$videoModel = new VideoModel();
		$videoModel->setVideoPath($videoPath);

		return $videoModel;
	}


	/**
	 * @inheritdoc
	 */
	public function delete(VideoModel $video) {
		$this->deleteFile($video->getVideoPath());
		$this->deleteFile($video->getCoverPath());
	}

	private function deleteFile(string $path) {
		if($this->filesystem->has($path))
			$this->filesystem->delete($path);
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

	private function validateVideoContent(string $pathToVideo) {
		try {
			/*
			 * Supported headers:
			 * offset 4: ftyp = 0x66747970
			 *
			 * Possible sup types:
			 * offset 8: isom = 0x69736F6D
			 * offset 8: 3gp5 = 0x33677035
			 * offset 8: MSNV = 0x4D534E56
			 * offset 8: M4A  = 0x4D344120
			 *
			 * documentation: https://github.com/wapmorgan/FileTypeDetector
			 */
			$typeInfo = $this->fileTypeDetector->detectByContent($pathToVideo);

			if(in_array($typeInfo[1], self::$allowedVideoTypes) === false) {
				$this->deleteFile($pathToVideo);
				throw new FileUploadException('Video with invalid content uploaded.');
			}
		}
		catch (RuntimeException $ex) {
			$this->deleteFile($pathToVideo);
			throw new FileUploadException('Video with unknown header uploaded.');
		}

	}

}