<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use DateTime;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\dto\VisitJournal;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\VisitJournalRepository;
use SRAG\Learnplaces\service\publicapi\model\VisitJournalModel;

/**
 * Class VisitJournalServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VisitJournalServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * @var VisitJournalRepository|MockInterface $visitJournalRepositoryMock
	 */
	private $visitJournalRepositoryMock;

	/**
	 * @var VisitJournalServiceImpl $subject
	 */
	private $subject;


	public function setUp() {
		parent::setUp();
		$this->visitJournalRepositoryMock = Mockery::mock(VisitJournalRepository::class);
		$this->subject = new VisitJournalServiceImpl($this->visitJournalRepositoryMock);
	}


	/**
	 * @Test
	 * @small
	 */
	public function testStoreWithValidIdWhichShouldSucceed() {
		$visitJournal = new VisitJournalModel();
		$visitJournal
			->setId(6)
			->setUserId(59)
			->setTime(new DateTime());
		
		$this->visitJournalRepositoryMock->shouldReceive('store')
			->once()
			->with(Mockery::any())
			->andReturn($visitJournal->toDto());

		$newVisitJournal = $this->subject->store($visitJournal);
		$this->assertEquals($visitJournal, $newVisitJournal, 'The old and new visit journal must be the same.');
	}


	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWhichShouldSucceed() {
		$journalId = 6;
		$this->visitJournalRepositoryMock->shouldReceive('delete')
			->once()
			->with($journalId);

		$this->subject->delete($journalId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWithInvalidIdWhichShouldFail() {
		$journalId = 6;
		$this->visitJournalRepositoryMock->shouldReceive('delete')
			->once()
			->with($journalId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The visit journal with the given id could not be deleted, because it was not found.');

		$this->subject->delete($journalId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindWhichShouldSucceed() {
		$journal = new VisitJournalModel();
		$journal->setId(6)
			->setUserId(45)
			->setTime(new DateTime());

		$this->visitJournalRepositoryMock->shouldReceive('find')
			->once()
			->with($journal->getId())
			->andReturn($journal->toDto());



		$newJournal = $this->subject->find($journal->getId());
		$this->assertEquals($journal, $newJournal);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindWithNotExistingVisitJournalWhichShouldFail() {
		$journalId = 6;

		$this->visitJournalRepositoryMock->shouldReceive('find')
			->once()
			->with($journalId)
			->andThrow(new EntityNotFoundException('Entity  not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage('The visit journal with the given id does not exist.');

		$this->subject->find($journalId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindAllByObjectIdWithoutResultsWhichShouldSucceed() {
		$objectId = 6;

		$this->visitJournalRepositoryMock->shouldReceive('findByObjectId')
			->once()
			->with($objectId)
			->andReturn([]);

		$this->subject->findByObjectId($objectId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindAllByObjectIdWithResultsWhichShouldSucceed() {
		$objectId = 6;

		$dto = new VisitJournal();
		$dto->setId(6)
			->setUserId(556)
			->setTime(new DateTime());

		$this->visitJournalRepositoryMock->shouldReceive('findByObjectId')
			->once()
			->with($objectId)
			->andReturn([$dto]);

		$results = $this->subject->findByObjectId($objectId);
		$this->assertEquals($dto->toModel(), $results[0]);
	}

}
