<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\PictureBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;

/**
 * Class PictureBlockServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureBlockServiceImplTest extends TestCase {

	use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	/**
	 * @var PictureBlockRepository|MockInterface $videoBlockRepositoryMock
	 */
	private $videoBlockRepositoryMock;
	/**
	 * @var PictureBlockServiceImpl $subject
	 */
	private $subject;

	/**
	 * @inheritDoc
	 */
	protected function setUp() {
		parent::setUp();


		$this->videoBlockRepositoryMock = Mockery::mock(PictureBlockRepository::class);
		$this->subject = new PictureBlockServiceImpl($this->videoBlockRepositoryMock);
	}

	/**
	 * @Test
	 */
	public function testStoreWhichShouldSucceed() {
		$model = new PictureBlockModel();
		$model
			->setId(6)
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
	 */
	public function testDeleteWhichShouldSucceed() {
		$model = new PictureBlockModel();
		$model
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->videoBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($model->getId())
			->andReturn($model->toDto());

		$this->subject->delete($model->getId());
	}

	/**
	 * @Test
	 */
	public function testDeleteWithInvalidIdWhichShouldFail() {
		$blockId = 6;

		$this->videoBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The picture block with the given id could not be deleted, because the block was not found.');

		$this->subject->delete($blockId);

	}


	/**
	 * @Test
	 */
	public function testFindWhichShouldSucceed() {
		$model = new PictureBlockModel();
		$model
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
	 */
	public function testFindWithInvalidIdWhichShouldFail() {
		$blockId = 6;

		$this->videoBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The picture block with the given id does not exist.');

		$this->subject->find($blockId);

	}
}
