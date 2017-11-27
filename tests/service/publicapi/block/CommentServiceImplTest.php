<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use DateTime;
use InvalidArgumentException;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\repository\CommentRepository;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\service\publicapi\model\AnswerModel;
use SRAG\Learnplaces\service\publicapi\model\CommentModel;

/**
 * Class CommentServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class CommentServiceImplTest extends TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * @var CommentRepository|Mockery\MockInterface $commentRepositoryMock
	 */
	private $commentRepositoryMock;
	/**
	 * @var CommentService $subject
	 */
	private $subject;

	/**
	 * @inheritDoc
	 */
	protected function setUp() {
		parent::setUp();

		$this->commentRepositoryMock = Mockery::mock(CommentRepository::class);
		$this->subject = new CommentServiceImpl($this->commentRepositoryMock);
	}


	/**
	 * @Test
	 * @small
	 */
	public function testStoreCommentWithNoAnswersWhichShouldSucceed() {
		$comment = new CommentModel();
		$comment
			->setId(0)
			->setContent("Hello World")
			->setUserId(6)
			->setTitle("Hello Titel")
			->setCreateDate(new DateTime());

		$this->commentRepositoryMock
			->shouldReceive('store')
			->once()
			->with(Mockery::any())
			->andReturn($comment->toDto());

		$this->subject->store($comment);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreCommentWithNonPersistentAnswerWhichShouldFail() {
		$comment = new CommentModel();
		$comment
			->setContent("Hello World")
			->setUserId(6)
			->setTitle("Hello Titel")
			->setCreateDate(new DateTime());
		$comment->setAnswers([new AnswerModel()]);

		$this->commentRepositoryMock
			->shouldReceive('store')
			->once()
			->andThrow(new EntityNotFoundException('Entity not found'));
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("Could not save the answer relations please make sure to save all the answers before the comment.");

		$this->subject->store($comment);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindWhichShouldSucceed() {
		$comment = new CommentModel();
		$comment
			->setContent("Hello World")
			->setUserId(6)
			->setTitle("Hello Titel")
			->setCreateDate(new DateTime());

		$this->commentRepositoryMock
			->shouldReceive('find')
			->once()
			->with($comment->getId())
			->andReturn($comment->toDto());

		$this->subject->find($comment->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testFindWithMissingCommentWhichShouldFail() {
		$comment = new CommentModel();
		$comment
			->setContent("Hello World")
			->setUserId(6)
			->setTitle("Hello Titel")
			->setCreateDate(new DateTime());
		$comment->setAnswers([new AnswerModel()]);

		$this->commentRepositoryMock
			->shouldReceive('find')
			->once()
			->with($comment->getId())
			->andThrow(new EntityNotFoundException('Entity not found'));
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("Comment with the given id does not exist and is therefore considered invalid.");

		$this->subject->find($comment->getId());
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWhichShouldSucceed() {
		$commentId = 6;

		$this->commentRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($commentId);

		$this->subject->delete($commentId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWithMissingCommentWhichShouldFail() {
		$commentId = 6;

		$this->commentRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($commentId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("Comment with the given id does not exist and is therefore considered invalid.");

		$this->subject->delete($commentId);
	}
}
