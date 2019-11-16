<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use DateTime;
use InvalidArgumentException;
use LogicException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\dto\Configuration;
use SRAG\Learnplaces\persistence\dto\Location;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\LearnplaceRepository;
use SRAG\Learnplaces\service\media\PictureService;
use SRAG\Learnplaces\service\publicapi\block\util\BlockOperationDispatcher;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\ConfigurationModel;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;
use SRAG\Learnplaces\service\publicapi\model\LocationModel;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureModel;
use SRAG\Learnplaces\service\publicapi\model\VisitJournalModel;

/**
 * Class LearnplaceServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class LearnplaceServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * @var LearnplaceRepository|MockInterface $learnplaceRepositoryMock
	 */
	private $learnplaceRepositoryMock;
	/**
	 * @var ConfigurationService|MockInterface $configurationServiceMock
	 */
	private $configurationServiceMock;
	/**
	 * @var LocationService|MockInterface $locationServiceMock
	 */
	private $locationServiceMock;
	/**
	 * @var VisitJournalService|MockInterface $visitJournalMock
	 */
	private $visitJournalMock;
	/**
	 * @var BlockOperationDispatcher|MockInterface $blockOperationDispatcher
	 */
	private $blockOperationDispatcher;
	/**
	 * @var PictureService|MockInterface $pictureServiceMock
	 */
	private $pictureServiceMock;

	/**
	 * @var LearnplaceServiceImpl $subject
	 */
	private $subject;


	public function setUp(): void {
		parent::setUp();
		$this->learnplaceRepositoryMock = Mockery::mock(LearnplaceRepository::class);
		$this->configurationServiceMock = Mockery::mock(ConfigurationService::class);
		$this->locationServiceMock = Mockery::mock(LocationService::class);
		$this->visitJournalMock = Mockery::mock(VisitJournalService::class);
		$this->blockOperationDispatcher = Mockery::mock(BlockOperationDispatcher::class);
		$this->pictureServiceMock = Mockery::mock(PictureService::class);
		$this->subject = new LearnplaceServiceImpl($this->configurationServiceMock, $this->locationServiceMock, $this->visitJournalMock, $this->learnplaceRepositoryMock, $this->blockOperationDispatcher, $this->pictureServiceMock);
	}


	/**
	 * @Test
	 * @small
	 */
	public function testFindWhichShouldSucceed(): void {
		$dto = $this->createLearnplace()->toDto();

		$this->learnplaceRepositoryMock
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
	public function testFindWithNonExistentIdWhichShouldFail(): void {
		$learnplaceId = 1;

		$this->learnplaceRepositoryMock
			->shouldReceive('find')
			->once()
			->with($learnplaceId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("The leanplace could not been found, reason the given id \"$learnplaceId\" was not found.");

		$this->subject->find($learnplaceId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindByObjectIdWhichShouldSucceed(): void {
		$dto = $this->createLearnplace()->toDto();

		$this->learnplaceRepositoryMock
			->shouldReceive('findByObjectId')
			->once()
			->with($dto->getObjectId())
			->andReturn($dto);

		$this->subject->findByObjectId($dto->getObjectId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindByObjectIdWithNonExistentIdWhichShouldFail(): void {
		$objectId = 45;

		$this->learnplaceRepositoryMock
			->shouldReceive('findByObjectId')
			->once()
			->with($objectId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("The leanplace could not been found, reason the given object id \"$objectId\" was not found.");

		$this->subject->findByObjectId($objectId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWhichShouldSucceed(): void {
		$dto = $this->createLearnplace()->toDto();
		$dto->setId(1)
			->setLocation(new Location())
			->setConfiguration(new Configuration())
			->setObjectId(45);

		$this->learnplaceRepositoryMock
			->shouldReceive('store')
			->once()
			->with(Mockery::any())
			->andReturn($dto);

		$this->subject->store($dto->toModel());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWithNonPersistentChildWhichShouldFail(): void {
		$dto = $this->createLearnplace()->toDto();

		$this->learnplaceRepositoryMock
			->shouldReceive('store')
			->once()
			->with(Mockery::any())
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(LogicException::class);
		$this->expectExceptionMessage('Could not store learnplace because at least one of the children is not persistent.');

		$this->subject->store($dto->toModel());
	}



	/*
	public function testDeleteWhichShouldSucceed() {
		Add delete test in the future
	}
	*/

	private function createLearnplace(): LearnplaceModel {
		$config = new ConfigurationModel();
		$config
			->setId(3)
			->setDefaultVisibility('ALWAYS')
			->setOnline(true);

		$location = new LocationModel();
		$location->setId(1)
			->setElevation(100.0)
			->setLatitude(4.4)
			->setLongitude(3.6)
			->setRadius(150);

		$leanplace = new LearnplaceModel();
		$leanplace
			->setId(6)
			->setObjectId(42)
			->setBlocks([])
			->setConfiguration($config)
			->setVisitJournals([$this->createVisit(1), $this->createVisit(2)])
			->setLocation($location)
			->setPictures([$this->createPicture(1), $this->createPicture(2), $this->createPicture(3)])
			->setBlocks([$this->createAccordion(5), $this->createPictureBlock(6), $this->createPictureBlock(7), $this->createPictureBlock(8)]);

		return $leanplace;
	}

	private function createVisit(int $id): VisitJournalModel {
		$visit = new VisitJournalModel();
		$visit
			->setId($id)
			->setTime(new DateTime())
			->setUserId(4);

		return $visit;
	}

	private function createPicture(int $id) {
		$picture = new PictureModel();
		$picture->setId($id)
			->setOriginalPath('asfssfadsasdsadasd')
			->setPreviewPath('asdfadsfdasfdsafadfadfdsa');

		return $picture;
	}

	private function createPictureBlock(int $id): PictureBlockModel {
		$block = new PictureBlockModel();
		$block->setDescription('Awesome picture')
			->setTitle('Awesome title')
			->setPicture($this->createPicture(4));

		return $block;
	}

	private function createAccordion(int $id): AccordionBlockModel {
		$block = new AccordionBlockModel();
		$block
			->setTitle('Awesome accordion')
			->setExpand(false)
			->setBlocks([$this->createPictureBlock(1), $this->createPictureBlock(2), $this->createPictureBlock(3)])
			->setId($id)
			->setSequence(1)
			->setVisibility('ALWAYS');

		return $block;
	}
}
