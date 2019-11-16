<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\media;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use League\Flysystem\FilesystemInterface;
use LogicException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use SRAG\Learnplaces\persistence\dto\Picture;
use SRAG\Learnplaces\persistence\repository\PictureRepository;
use SRAG\Learnplaces\service\filesystem\PathHelper;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\media\wrapper\FileTypeDetector;
use wapmorgan\FileTypeDetector\Detector;

/**
 * Class PictureServiceImplTest
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * Required due to the ilUtil hard dependency mock.
 * @runTestsInSeparateProcesses
 */
class PictureServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;
	
	/**
	 * @var PictureRepository|MockInterface $pictureRepositoryMock
	 */
	private $pictureRepositoryMock;
	/**
	 * @var ServerRequestInterface|MockInterface $requestMock
	 */
	private $requestMock;
	/**
	 * @var ImageManager|MockInterface $imageManagerMock
	 */
	private $imageManagerMock;
	/**
	 * @var FileTypeDetector|MockInterface $fileTypeDetectorMock
	 */
	private $fileTypeDetectorMock;
	/**
	 * @var FilesystemInterface|MockInterface $filesystemMock
	 */
	private $filesystemMock;

	/**
	 * @var PictureServiceImpl $subject
	 */
	private $subject;


	public function setUp(): void {
		parent::setUp();
		$this->pictureRepositoryMock = Mockery::mock(PictureRepository::class);
		$this->requestMock = Mockery::mock(ServerRequestInterface::class);
		$this->imageManagerMock = Mockery::mock(ImageManager::class);
		$this->fileTypeDetectorMock = Mockery::mock(FileTypeDetector::class);
		$this->filesystemMock = Mockery::mock(FilesystemInterface::class);
		$this->subject = new PictureServiceImpl($this->requestMock, $this->pictureRepositoryMock, $this->imageManagerMock, $this->fileTypeDetectorMock, $this->filesystemMock);
	}


	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWithNoUploadWhichShouldFail(): void {
		$this->requestMock->shouldReceive('getUploadedFiles')
			->once()
			->withNoArgs()
			->andReturn([]);

		$this->expectException(LogicException::class);
		$this->expectExceptionMessage('Unable to store image without upload.');

		$this->subject->storeUpload(42);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWithErrorUploadWhichShouldFail(): void {
		/**
		 * @var UploadedFileInterface|MockInterface $file
		 */
		$file = Mockery::mock(UploadedFileInterface::class);
		$file->shouldReceive('getError')
			->twice()
			->withNoArgs()
			->andReturn(UPLOAD_ERR_PARTIAL);

		$this->requestMock->shouldReceive('getUploadedFiles')
			->twice()
			->withNoArgs()
			->andReturn([$file]);

		$this->expectException(FileUploadException::class);
		$this->expectExceptionMessage('Unable to store picture due to an upload error.');
		$this->expectExceptionCode(UPLOAD_ERR_PARTIAL);

		$this->subject->storeUpload(42);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWithInvalidFileExtensionWhichShouldFail(): void {

		$filename = 'TheAnswerIs42.php';

		/**
		 * @var UploadedFileInterface|MockInterface $file
		 */
		$file = Mockery::mock(UploadedFileInterface::class);
		$file->shouldReceive('getError')
				->once()
				->withNoArgs()
				->andReturn(UPLOAD_ERR_OK)
				->getMock()
			->shouldReceive('getClientFilename')
				->once()
				->withNoArgs()
				->andReturn($filename);

		$this->fileTypeDetectorMock->shouldReceive('detectByFilename')
			->once()
			->with($filename)
			->andReturn([Detector::VIDEO, Detector::AVI, '']);

		$this->requestMock->shouldReceive('getUploadedFiles')
			->twice()
			->withNoArgs()
			->andReturn([$file]);

		$this->expectException(FileUploadException::class);
		$this->expectExceptionMessage('Picture with invalid extension uploaded.');
		$this->expectExceptionCode(UPLOAD_ERR_OK);

		$this->subject->storeUpload(42);
	}


	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWhichShouldSucceed(): void {

		$webDir = './data/default';
		$filename = 'TheAnswerIs42.png';
		$ilUtil = Mockery::mock('alias:' . PathHelper::class);
		$ilUtil->shouldReceive('generatePath')
			->twice()
			->withArgs([42, Mockery::any()])
			->andReturn("$webDir/$filename");

		/**
		 * @var UploadedFileInterface|MockInterface $file
		 */
		$file = Mockery::mock(UploadedFileInterface::class);
		$file->shouldReceive('getError')
				->once()
				->withNoArgs()
				->andReturn(UPLOAD_ERR_OK)
				->getMock()
			->shouldReceive('getClientFilename')
				->twice()
				->withNoArgs()
				->andReturn($filename)
				->getMock()
			->shouldReceive('moveTo')
				->once()
				->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"));

		$this->fileTypeDetectorMock->shouldReceive('detectByFilename')
				->once()
				->with($filename)
				->andReturn([Detector::IMAGE, Detector::PNG, ''])
				->getMock()
			->shouldReceive('detectByContent')
				->once()
				->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"))
				->andReturn([Detector::IMAGE, Detector::PNG, '']);

		$image = Mockery::mock(Image::class);
		$this->imageManagerMock->shouldReceive('make')
				->once()
				->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"))
				->andReturn($image)
				->getMock();

		$width = 2560;
		$height = 1080;
		$ratio = $width / $height;

		$targetWith = 1280;
		$targetHeight = intval(floor($targetWith / $ratio));

		$image->shouldReceive('getHeight')
				->once()
				->andReturn($height)
				->getMock()
			->shouldReceive('getWidth')
				->once()
				->andReturn($width)
				->getMock()
			->shouldReceive('save')
				->once()
				->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"))
				->getMock()
			->shouldReceive('resize')
				->withArgs([$targetWith, $targetHeight]);


		$this->requestMock->shouldReceive('getUploadedFiles')
			->twice()
			->withNoArgs()
			->andReturn([$file]);

		$this->pictureRepositoryMock->shouldReceive('store')
			->once()
			->with(Mockery::type(Picture::class))
			->andReturnUsing(function(Picture $args): Picture {
				$args->setId(1);
				return $args;
			});

		$pictureModel = $this->subject->storeUpload(42);

		$this->assertRegExp("/\.\/data\/default\/.*?\.png/", $pictureModel->getOriginalPath(), 'Original path must match the path pattern.');
		$this->assertRegExp("/\.\/data\/default\/.*?\.png/", $pictureModel->getPreviewPath(), 'Preview path must match the path pattern.');
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWithInvalidPictureContentWhichShouldFail(): void {

		$webDir = './data/default';
		$filename = 'TheAnswerIs42.png';
		$ilUtil = Mockery::mock('alias:' . PathHelper::class);
		$ilUtil->shouldReceive('generatePath')
			->once()
			->withArgs([42, $filename])
			->andReturn("$webDir/$filename");

		/**
		 * @var UploadedFileInterface|MockInterface $file
		 */
		$file = Mockery::mock(UploadedFileInterface::class);
		$file->shouldReceive('getError')
			->once()
			->withNoArgs()
			->andReturn(UPLOAD_ERR_OK)
			->getMock()
			->shouldReceive('getClientFilename')
			->twice()
			->withNoArgs()
			->andReturn($filename)
			->getMock()
			->shouldReceive('moveTo')
			->once()
			->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"));

		$this->fileTypeDetectorMock->shouldReceive('detectByFilename')
			->once()
			->with($filename)
			->andReturn([Detector::IMAGE, Detector::PNG, ''])
			->getMock()
			->shouldReceive('detectByContent')
			->once()
			->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"))
			->andReturn([Detector::DISK_IMAGE, Detector::APK, '']);

		$this->requestMock->shouldReceive('getUploadedFiles')
			->twice()
			->withNoArgs()
			->andReturn([$file]);

		$this->expectException(FileUploadException::class);
		$this->expectExceptionMessage('Picture with invalid content uploaded.');

		$this->subject->storeUpload(42);

	}
}
