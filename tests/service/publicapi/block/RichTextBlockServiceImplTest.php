<?php

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\RichTextBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\RichTextBlockModel;

/**
 * Class RichTextBlockServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class RichTextBlockServiceImplTest extends TestCase {

	use \Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	/**
	 * @var RichTextBlockRepository|MockInterface $richTextBlockRepositoryMock
	 */
	private $richTextBlockRepositoryMock;
	/**
	 * @var RichTextBlockServiceImpl $subject
	 */
	private $subject;

	/**
	 * @inheritDoc
	 */
	protected function setUp() {
		parent::setUp();


		$this->richTextBlockRepositoryMock = Mockery::mock(RichTextBlockRepository::class);
		$this->subject = new RichTextBlockServiceImpl($this->richTextBlockRepositoryMock);
	}

	/**
	 * @Test
	 */
	public function testStoreWhichShouldSucceed() {
		$model = new RichTextBlockModel();
		$model
			->setContent("Hello World")
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->richTextBlockRepositoryMock
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
		$model = new RichTextBlockModel();
		$model
			->setContent("Hello World")
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->richTextBlockRepositoryMock
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

		$this->richTextBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The rich text block with the given id could not be deleted, because the block was not found.');

		$this->subject->delete($blockId);

	}


	/**
	 * @Test
	 */
	public function testFindWhichShouldSucceed() {
		$model = new RichTextBlockModel();
		$model
			->setContent("Hello World")
			->setId(6)
			->setSequence(15)
			->setVisibility("ALWAYS");

		$this->richTextBlockRepositoryMock
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

		$this->richTextBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The rich text block with the given id does not exist.');

		$this->subject->find($blockId);

	}
}
