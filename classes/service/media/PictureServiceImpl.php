<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\media;

use ilLearnplacesPlugin;
use ilUtil;
use Intervention\Image\ImageManager;
use LogicException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use SRAG\Learnplaces\persistence\repository\PictureRepository;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\publicapi\model\PictureModel;

/**
 * Class PictureServiceImpl
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureServiceImpl implements PictureService {

	/**
	 * The picture service will only accept uploads with the whitelisted extensions.
	 *
	 * @var string[] $allowedExtensions
	 */
	private static $allowedExtensions = [
		'png',
		'jpg'
	];


	/**
	 * @var ServerRequestInterface $request
	 */
	private $request;
	/**
	 * @var PictureRepository $pictureRepository
	 */
	private $pictureRepository;
	/**
	 * @var ImageManager $imageManager
	 */
	private $imageManager;


	/**
	 * PictureServiceImpl constructor.
	 *
	 * @param ServerRequestInterface $request
	 * @param PictureRepository      $pictureRepository
	 * @param ImageManager           $imageManager
	 */
	public function __construct(ServerRequestInterface $request, PictureRepository $pictureRepository, ImageManager $imageManager) {
		$this->request = $request;
		$this->pictureRepository = $pictureRepository;
		$this->imageManager = $imageManager;
	}


	/**
	 * @inheritDoc
	 */
	public function storeUpload(int $objectId): PictureModel {

		if($this->hasUploadedFiles() === false)
			throw new LogicException('Unable to store image without upload.');

		/**
		 * @var UploadedFileInterface $file
		 */
		$file = $this->request->getUploadedFiles()[0];
		$this->validateUpload($file);

		$path = $this->generatePicturePath($objectId, $file->getClientFilename() ?? '');
		$file->moveTo($path);
		$previewPath = $this->generatePreview($objectId, $path);
		
		$picture = new PictureModel();
		$picture
			->setOriginalPath($path)
			->setPreviewPath($previewPath);
		
		$dto = $this->pictureRepository->store($picture->toDto());

		return $dto->toModel();
	}

	private function hasUploadedFiles(): bool {
		$files =  $this->request->getUploadedFiles();
		return count($files) > 0;
	}

	private function generatePicturePath(int $objectId, string $filename): string {
		$path =
			ilUtil::getWebspaceDir()
			. '/'
			. ilLearnplacesPlugin::PLUGIN_ID
			. '_'
			. strval($objectId)
			. '/'
			. uniqid(ilLearnplacesPlugin::PLUGIN_ID, true);

		$extension = $this->extractExtensionFromName($filename);
		$filePath = $path . '.' . $extension;

		return $filePath;
	}

	private function validateUpload(UploadedFileInterface $file) {
		if($file->getError() !== UPLOAD_ERR_OK)
			throw new FileUploadException('Unable to store picture due to an upload error.', $file->getError());

		$extension = $this->extractExtensionFromName($file->getClientFilename() ?? '');

		if(in_array($extension, self::$allowedExtensions) === false)
			throw new FileUploadException('Picture with invalid extension uploaded.');
	}

	private function extractExtensionFromName(string $filename): string {
		return pathinfo($filename, PATHINFO_EXTENSION);
	}


	/**
	 * Generates a preview of the given picture.
	 *
	 * @param int    $objectId      The leanplace object id.
	 * @param string $originalPath  The picture which should be used to generate a preview.
	 *
	 * @return string The path to the preview picture.
	 */
	private function generatePreview(int $objectId, string $originalPath): string {
		$image = $this->imageManager->make($originalPath);
		$ratio = $image->getWidth() / $image->getHeight();

		$targetWith = 1280;
		$targetHeight = intval(floor($targetWith / $ratio));
		$image->resize($targetWith, $targetHeight);

		$previewPath = $this->generatePicturePath($objectId, $originalPath);
		$image->save($previewPath);

		return $previewPath;
	}
}