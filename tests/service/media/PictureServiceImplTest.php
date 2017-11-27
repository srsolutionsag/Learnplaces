<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\media;

use ilUtil;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use LogicException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use SRAG\Learnplaces\persistence\dto\Picture;
use SRAG\Learnplaces\persistence\repository\PictureRepository;
use SRAG\Learnplaces\service\media\exception\FileUploadException;

/**
 * Class PictureServiceImplTest
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * Required due to the ilUtil hard dependency mock.
 *
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
	 * @var PictureServiceImpl $subject
	 */
	private $subject;


	public function setUp() {
		parent::setUp();
		$this->pictureRepositoryMock = Mockery::mock(PictureRepository::class);
		$this->requestMock = Mockery::mock(ServerRequestInterface::class);
		$this->imageManagerMock = Mockery::mock(ImageManager::class);
		$this->subject = new PictureServiceImpl($this->requestMock, $this->pictureRepositoryMock, $this->imageManagerMock);
	}


	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWithNoUploadWhichShouldFail() {
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
	public function testStoreUploadWithErrorUploadWhichShouldFail() {
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
	public function testStoreUploadWithInvalidFileExtensionWhichShouldFail() {
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
				->andReturn('TheAnswerIs42.php');

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
	public function testStoreUploadWhichShoulSucceed() {

		$webDir = './data/default';
		$ilUtil = Mockery::mock('alias:' . ilUtil::class);
		$ilUtil->shouldReceive('getWebspaceDir')
			->twice()
			->withNoArgs()
			->andReturn($webDir);

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
				->andReturn('TheAnswerIs42.png')
				->getMock()
			->shouldReceive('moveTo')
				->once()
				->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"));

		$image = Mockery::mock(Image::class);
		$this->imageManagerMock->shouldReceive('make')
			->once()
			->with(Mockery::pattern("/\.\/data\/default\/.*?\.png/"))
			->andReturn($image);

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
}
