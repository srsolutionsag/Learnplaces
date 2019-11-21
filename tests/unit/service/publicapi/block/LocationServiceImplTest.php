<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\dto\Location;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\LocationRepository;
use SRAG\Learnplaces\service\publicapi\model\LocationModel;

/**
 * Class LocationServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LocationServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;
	/**
	 * @var LocationRepository|MockInterface $locationRepositoryMock
	 */
	private $locationRepositoryMock;

	/**
	 * @var LocationServiceImpl $subject
	 */
	private $subject;


	public function setUp(): void {
		parent::setUp();
		$this->locationRepositoryMock = Mockery::mock(LocationRepository::class);
		$this->subject = new LocationServiceImpl($this->locationRepositoryMock);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWhichShouldSucceed(): void {
		$model = new LocationModel();
		$model
			->setId(6)
			->setRadius(200);

		$this->locationRepositoryMock
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
	public function testDeleteWhichShouldSucceed(): void {
		$model = new LocationModel();
		$model
			->setId(6)
			->setRadius(150);

		$this->locationRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($model->getId())
			->andReturn($model->toDto());

		$this->subject->delete($model->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWithInvalidIdWhichShouldFail(): void {
		$blockId = 6;

		$this->locationRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The location with the given id could not be deleted, because the it was not found.');

		$this->subject->delete($blockId);

	}


	/**
	 * @Test
	 * @small
	 */
	public function testFindWhichShouldSucceed(): void {
		$dto = new Location();
		$dto
			->setId(6)
			->setRadius(200);

		$this->locationRepositoryMock
			->shouldReceive('find')
			->once()
			->with($dto->getId())
			->andReturn($dto);

		$this->subject->find($dto->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindWithInvalidIdWhichShouldFail(): void {
		$blockId = 6;

		$this->locationRepositoryMock
			->shouldReceive('find')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The location with the given id does not exist.');

		$this->subject->find($blockId);

	}
}
