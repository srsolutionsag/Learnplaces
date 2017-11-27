<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\dto\Configuration;
use SRAG\Learnplaces\persistence\repository\ConfigurationRepository;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\service\publicapi\model\ConfigurationModel;

/**
 * Class ConfigurationServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ConfigurationServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;
	/**
	 * @var ConfigurationRepository|MockInterface $configurationRepositoryMock
	 */
	private $configurationRepositoryMock;

	/**
	 * @var ConfigurationServiceImpl $subject
	 */
	private $subject;


	public function setUp() {
		parent::setUp();
		$this->configurationRepositoryMock = Mockery::mock(ConfigurationRepository::class);
		$this->subject = new ConfigurationServiceImpl($this->configurationRepositoryMock);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWhichShouldSucceed() {
		$model = new ConfigurationModel();
		$model
			->setId(6)
			->setDefaultVisibility('ALWAYS');

		$this->configurationRepositoryMock
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
		$model = new ConfigurationModel();
		$model
			->setId(6)
			->setDefaultVisibility('ALWAYS');

		$this->configurationRepositoryMock
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
	public function testDeleteWithInvalidIdWhichShouldFail() {
		$blockId = 6;

		$this->configurationRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The configuration with the given id could not be deleted, because the it was not found.');

		$this->subject->delete($blockId);

	}


	/**
	 * @Test
	 * @small
	 */
	public function testFindWhichShouldSucceed() {
		$dto = new Configuration();
		$dto
			->setId(6)
			->setDefaultVisibility('ALWAYS');

		$this->configurationRepositoryMock
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
	public function testFindWithInvalidIdWhichShouldFail() {
		$blockId = 6;

		$this->configurationRepositoryMock
			->shouldReceive('find')
			->once()
			->with($blockId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The configuration with the given id does not exist.');

		$this->subject->find($blockId);
	}
}
