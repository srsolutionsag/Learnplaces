<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use League\Flysystem\FilesystemInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\VideoBlockRepository;
use SRAG\Learnplaces\service\media\VideoService;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;
use SRAG\Learnplaces\service\publicapi\model\VideoModel;

/**
 * Class VideoBlockServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlockServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * @var VideoBlockRepository|MockInterface $videoBlockRepositoryMock
	 */
	private $videoBlockRepositoryMock;
	/**
	 * @var VideoService|MockInterface $videoServiceMock
	 */
	private $videoServiceMock;
	/**
	 * @var VideoBlockServiceImpl $subject
	 */
	private $subject;

	/**
	 * @inheritDoc
	 */
	protected function setUp() {
		parent::setUp();

		$this->videoServiceMock = Mockery::mock(VideoService::class);
		$this->videoBlockRepositoryMock = Mockery::mock(VideoBlockRepository::class);
		$this->subject = new VideoBlockServiceImpl($this->videoBlockRepositoryMock, $this->videoServiceMock);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWhichShouldSucceed() {
		$model = new VideoBlockModel();
		$model->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->videoBlockRepositoryMock
			->shouldReceive('store')
			->once()
			->with(Mockery::any())
			->andReturn($model->toDto());

		$this->subject->store($model);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWhichShouldSucceed() {
		$model = new VideoBlockModel();
		$model
			->setPath("Hello")
			->setCoverPath("World")
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->videoBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($model->getId())
			->andReturn($model->toDto())
			->getMock()
			->shouldReceive('delete')
			->once()
			->with($model->getId());

		$this->videoServiceMock
			->shouldReceive('delete')
			->once()
			->with(Mockery::type(VideoModel::class));

		$this->subject->delete($model->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWithInvalidIdWhichShouldFail() {
		$blockId = 6;

		$this->videoBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The video block with the given id could not be deleted, because the block was not found.');

		$this->subject->delete($blockId);

	}


	/**
	 * @Test
	 * @small
	 */
	public function testFindWhichShouldSucceed() {
		$model = new VideoBlockModel();
		$model
			->setPath("Hello")
			->setCoverPath("World")
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->videoBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($model->getId())
			->andReturn($model->toDto());

		$this->subject->find($model->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindWithInvalidIdWhichShouldFail() {
		$blockId = 6;

		$this->videoBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The video block with the given id does not exist.');

		$this->subject->find($blockId);

	}
}
