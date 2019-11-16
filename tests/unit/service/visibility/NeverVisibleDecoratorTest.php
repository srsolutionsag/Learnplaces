<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\visibility;

use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;
use SRAG\Learnplaces\service\publicapi\model\LearnplaceModel;
use SRAG\Learnplaces\util\Visibility;

/**
 * Class NeverVisibleDecoratorTest
 *
 * @package SRAG\Learnplaces\service\visibility
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class NeverVisibleDecoratorTest extends TestCase {

	use MockeryPHPUnitIntegration;

	/**
	 * @var LearnplaceService|MockInterface $learnplaceServiceMock
	 */
	private $learnplaceServiceMock;

	/**
	 * @var NeverVisibleDecorator $subject
	 */
	private $subject;


	public function setUp(): void {
		parent::setUp();
		$this->learnplaceServiceMock = Mockery::mock(LearnplaceService::class);
		$this->subject = new NeverVisibleDecorator($this->learnplaceServiceMock);
	}


	/**
	 * @Test
	 * @small
	 * @dataProvider blockDataProvider
	 */
	public function testFindByObjectIdWithoutAccordionBlocksWhichShouldSucceed($blocks, $expected): void {
		$learnplaceModel = new LearnplaceModel();
		$learnplaceModel->setId(5)
			->setObjectId(45)
			->setBlocks($blocks);
		$this->learnplaceServiceMock->shouldReceive('findByObjectId')
			->once()
			->with($learnplaceModel->getObjectId())
			->andReturn($learnplaceModel);

		$result = $this->subject->findByObjectId($learnplaceModel->getObjectId());
		$this->assertEquals($expected, $result->getBlocks());
	}

	public function blockDataProvider(): array {
		return [

			//set 1
			[
				[
					$this->generateBlock(Visibility::ALWAYS),
				],
				[
					$this->generateBlock(Visibility::ALWAYS),
				],
			],
			//set 2
			[
				[
					$this->generateBlock(Visibility::NEVER),
					$this->generateBlock(Visibility::ONLY_AT_PLACE),
					$this->generateBlock(Visibility::ALWAYS),
				],
				[
					$this->generateBlock(Visibility::ALWAYS),
				],
			],
			//set 3
			[
				[
					$this->generateBlock(Visibility::NEVER),
					$this->generateBlock(Visibility::ALWAYS),
					$this->generateBlock(Visibility::ONLY_AT_PLACE),
				],
				[
					$this->generateBlock(Visibility::ALWAYS),
				],
			],
			//set 4
			[
				[
					$this->generateBlock(Visibility::NEVER),
				],
				[],
			],

			//set 5
			[
				[
					$this->generateBlock(Visibility::ALWAYS),
					$this->generateBlock(Visibility::ONLY_AT_PLACE),
					$this->generateBlock(Visibility::NEVER),
				],
				[
					$this->generateBlock(Visibility::ALWAYS),
				],
			],
			//set 6
			[
				[
					$this->generateBlock(Visibility::ONLY_AT_PLACE),
					$this->generateAccordion(Visibility::ALWAYS, []),
					$this->generateBlock(Visibility::NEVER),
				],
				[
					$this->generateAccordion(Visibility::ALWAYS, []),
				],
			],
			//set 7
			[
				[
					$this->generateBlock(Visibility::NEVER),
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::NEVER),
					]),
					$this->generateBlock(Visibility::ONLY_AT_PLACE),
				],
				[
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ALWAYS),
					]),
				],
			],
			//set 8
			[
				[
					$this->generateBlock(Visibility::NEVER),
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::NEVER),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::NEVER),
					]),
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::NEVER),
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::NEVER),
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
					]),
					$this->generateBlock(Visibility::NEVER),
				],
				[
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ALWAYS),
					]),
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ALWAYS),
					]),
				],
			],
			//set 9
			[
				[
					$this->generateBlock(Visibility::NEVER),
					$this->generateAccordion(Visibility::NEVER, [
						$this->generateBlock(Visibility::NEVER),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::NEVER),
					]),
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::NEVER),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ONLY_AT_PLACE),
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::NEVER),
					]),
					$this->generateBlock(Visibility::NEVER),
					$this->generateBlock(Visibility::ONLY_AT_PLACE),
					$this->generateBlock(Visibility::ONLY_AT_PLACE),
				],
				[
					$this->generateAccordion(Visibility::ALWAYS, [
						$this->generateBlock(Visibility::ALWAYS),
						$this->generateBlock(Visibility::ALWAYS),
					]),
				],
			],

		];
	}
	
	private function generateBlock(string $visibility): BlockModel {
		return (new ILIASLinkBlockModel())->setId(5)->setSequence(7)->setVisibility($visibility);
	}

	private function generateAccordion(string $visibility, array $blocks): BlockModel {
		return (new AccordionBlockModel())->setBlocks($blocks)->setId(5)->setSequence(7)->setVisibility($visibility);
	}
}
