<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\PictureBlockRepository;
use SRAG\Learnplaces\service\media\PictureService;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureModel;

/**
 * Class PictureBlockServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureBlockServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * @var PictureBlockRepository|MockInterface $pictureBlockRepositoryMock
	 */
	private $pictureBlockRepositoryMock;
	/**
	 * @var PictureService|MockInterface $pictureService
	 */
	private $pictureService;
	/**
	 * @var PictureBlockServiceImpl $subject
	 */
	private $subject;

	/**
	 * @inheritDoc
	 */
	protected function setUp() {
		parent::setUp();
		$this->pictureService = Mockery::mock(PictureService::class);
		$this->pictureBlockRepositoryMock = Mockery::mock(PictureBlockRepository::class);
		$this->subject = new PictureBlockServiceImpl($this->pictureBlockRepositoryMock, $this->pictureService);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWhichShouldSucceed() {
		$model = new PictureBlockModel();
		$model
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->pictureBlockRepositoryMock
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
		$picture = new PictureModel();
		$picture->setId(56);

		$model = new PictureBlockModel();
		$model
			->setPicture($picture)
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->pictureBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($model->getId())
			->andReturn($model->toDto());

		$this->pictureBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($model->getId())
			->andReturn($model->toDto());

		$this->pictureService
			->shouldReceive('delete')
			->once()
			->with($picture->getId());

		$this->subject->delete($model->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWithoutPictureWhichShouldSucceed() {
		$model = new PictureBlockModel();
		$model
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->pictureBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($model->getId());

		$this->pictureBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($model->getId())
			->andReturn($model->toDto());

		$this->subject->delete($model->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWithInvalidIdWhichShouldFail() {
		$blockId = 6;

		$this->pictureBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The picture block with the given id could not be deleted, because the block was not found.');

		$this->subject->delete($blockId);

	}


	/**
	 * @Test
	 * @small
	 */
	public function testFindWhichShouldSucceed() {
		$model = new PictureBlockModel();
		$model
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->pictureBlockRepositoryMock
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

		$this->pictureBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The picture block with the given id does not exist.');

		$this->subject->find($blockId);

	}
}
