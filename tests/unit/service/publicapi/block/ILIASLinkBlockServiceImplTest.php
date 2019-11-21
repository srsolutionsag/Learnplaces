<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\ILIASLinkBlockRepository;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;

/**
 * Class ILIASLinkBlockServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ILIASLinkBlockServiceImplTest extends TestCase {

	use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	/**
	 * @var ILIASLinkBlockRepository|MockInterface $iliasLinkBlockRepositoryMock
	 */
	private $iliasLinkBlockRepositoryMock;

	/**
	 * @var ILIASLinkBlockServiceImpl $subject
	 */
	private $subject;

	public function setUp(): void {
		parent::setUp();
		$this->iliasLinkBlockRepositoryMock = Mockery::mock(ILIASLinkBlockRepository::class);
		$this->subject = new ILIASLinkBlockServiceImpl($this->iliasLinkBlockRepositoryMock);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWhichShouldSucceed(): void {
		$model = new ILIASLinkBlockModel();
		$model
			->setRefId(234)
			->setSequence(45);

		$this->iliasLinkBlockRepositoryMock
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
	public function testFindWhichShouldSucceed(): void {
		$model = new ILIASLinkBlockModel();
		$model
			->setRefId(56)
			->setSequence(4);

		$this->iliasLinkBlockRepositoryMock
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
	public function testFindWithMissingBlockWhichShouldFail(): void {
		$modelId = 6;

		$this->iliasLinkBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($modelId)
			->andThrow(new EntityNotFoundException('Entity not found'));
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("The ILIAS link block with the given id does not exist.");

		$this->subject->find($modelId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWhichShouldSucceed(): void {
		$commentId = 6;

		$this->iliasLinkBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($commentId);

		$this->subject->delete($commentId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWithMissingCommentWhichShouldFail(): void {
		$commentId = 6;

		$this->iliasLinkBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($commentId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("The ILIAS link block with the given id could not be deleted, because the block was not found.");

		$this->subject->delete($commentId);
	}
}
