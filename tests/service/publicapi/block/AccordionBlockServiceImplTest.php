<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\block;

use InvalidArgumentException;
use Mockery;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\persistence\repository\AccordionBlockRepository;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\MapBlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use SRAG\Learnplaces\service\publicapi\model\RichTextBlockModel;
use SRAG\Learnplaces\service\publicapi\model\VideoBlockModel;

/**
 * Class AccordionBlockServiceImplTest
 *
 * @package SRAG\Learnplaces\service\publicapi\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AccordionBlockServiceImplTest extends TestCase {

	use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

	/**
	 * @var AccordionBlockRepository|Mockery\MockInterface $accordionBlockRepositoryMock
	 */
	private $accordionBlockRepositoryMock;

	/**
	 * @var AccordionBlockServiceImpl $subject
	 */
	private $subject;


	public function setUp() {
		parent::setUp();

		$this->accordionBlockRepositoryMock = Mockery::mock(AccordionBlockRepository::class);
		$this->subject = new AccordionBlockServiceImpl($this->accordionBlockRepositoryMock);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testStoreWhichShouldSucceed() {
		$model = new AccordionBlockModel();
		$model
			->setTitle('Title')
			->setExpand(true)
			->setBlocks([
				new RichTextBlockModel(),
				new PictureBlockModel(),
				new MapBlockModel(),
				new VideoBlockModel()
			]);

		$this->accordionBlockRepositoryMock
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
	public function testFindWhichShouldSucceed() {
		$model = new AccordionBlockModel();
		$model
			->setTitle('Title')
			->setExpand(true)
			->setBlocks([
				new RichTextBlockModel(),
				new PictureBlockModel(),
				new MapBlockModel(),
				new VideoBlockModel()
			]);

		$this->accordionBlockRepositoryMock
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
	public function testFindWithMissingBlockWhichShouldFail() {
		$modelId = 6;

		$this->accordionBlockRepositoryMock
			->shouldReceive('findByBlockId')
			->once()
			->with($modelId)
			->andThrow(new EntityNotFoundException('Entity not found'));
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("The accordion block with the given id does not exist.");

		$this->subject->find($modelId);
	}

	/**
	 * @Test
	 * @small
	 */
	public function testDeleteWhichShouldSucceed() {
		$commentId = 6;

		$this->accordionBlockRepositoryMock
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

		$this->accordionBlockRepositoryMock
			->shouldReceive('delete')
			->once()
			->with($commentId)
			->andThrow(new EntityNotFoundException('Entity not found'));

		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionMessage("The accordion block with the given id could not be deleted, because the block was not found.");

		$this->subject->delete($commentId);
	}
}
