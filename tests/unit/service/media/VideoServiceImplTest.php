<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\media;

use LogicException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use SRAG\Learnplaces\service\filesystem\PathHelper;
use SRAG\Learnplaces\service\media\exception\FileUploadException;
use SRAG\Learnplaces\service\media\wrapper\FileTypeDetector;
use wapmorgan\FileTypeDetector\Detector;

/**
 * Class VideoServiceImplTest
 *
 * @package SRAG\Learnplaces\service\media
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 * @runTestsInSeparateProcesses
 */
class VideoServiceImplTest extends TestCase {

	/**
	 * @var ServerRequestInterface|MockInterface $requestMock
	 */
	private $requestMock;
	/**
	 * @var FileTypeDetector|MockInterface $fileTypeDetectorMock
	 */
	private $fileTypeDetectorMock;

	/**
	 * @var VideoServiceImpl $subject
	 */
	private $subject;


	public function setUp(): void {
		parent::setUp();
		$this->requestMock = Mockery::mock(ServerRequestInterface::class);
		$this->fileTypeDetectorMock = Mockery::mock(FileTypeDetector::class);
		$this->subject = new VideoServiceImpl($this->requestMock, $this->fileTypeDetectorMock);
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
		$this->expectExceptionMessage('Unable to store video without upload.');

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
		$this->expectExceptionMessage('Unable to store video due to an upload error.');
		$this->expectExceptionCode(UPLOAD_ERR_PARTIAL);

		$this->subject->storeUpload(42);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWithInvalidFileExtensionWhichShouldFail(): void {

		$filename = 'TheAnswerIs42.avi';

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
		$this->expectExceptionMessage('Video with invalid extension uploaded.');
		$this->expectExceptionCode(UPLOAD_ERR_OK);

		$this->subject->storeUpload(42);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWithInvalidVideoContentWhichShouldFail(): void {

		$webDir = './data/default';
		$filename = 'TheAnswerIs42.mp4';
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
			->with(Mockery::pattern("/\.\/data\/default\/.*?\.mp4/"));

		$this->fileTypeDetectorMock->shouldReceive('detectByFilename')
			->once()
			->with($filename)
			->andReturn([Detector::VIDEO, Detector::MP4, ''])
			->getMock()
			->shouldReceive('detectByContent')
			->once()
			->with(Mockery::pattern("/\.\/data\/default\/.*?\.mp4/"))
			->andReturn([Detector::DISK_IMAGE, Detector::APK, '']);

		$this->requestMock->shouldReceive('getUploadedFiles')
			->twice()
			->withNoArgs()
			->andReturn([$file]);

		$this->expectException(FileUploadException::class);
		$this->expectExceptionMessage('Video with invalid content uploaded.');

		$this->subject->storeUpload(42);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreUploadWhichShouldSucceed(): void {

		$webDir = './data/default';
		$filename = 'TheAnswerIs42.mp4';
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
			->with(Mockery::pattern("/\.\/data\/default\/.*?\.mp4/"));

		$this->fileTypeDetectorMock->shouldReceive('detectByFilename')
			->once()
			->with($filename)
			->andReturn([Detector::VIDEO, Detector::MP4, ''])
			->getMock()
			->shouldReceive('detectByContent')
			->once()
			->with(Mockery::pattern("/\.\/data\/default\/.*?\.mp4/"))
			->andReturn([Detector::VIDEO, Detector::MP4, '']);

		$this->requestMock->shouldReceive('getUploadedFiles')
			->twice()
			->withNoArgs()
			->andReturn([$file]);

		$videoModel = $this->subject->storeUpload(42);

		$this->assertRegExp('//', $videoModel->getCoverPath(), 'The cover path must match the path pattern.');
		$this->assertRegExp("/\.\/data\/default\/.*?\.mp4/", $videoModel->getVideoPath(), 'The video path must match the path pattern.');
	}
}
