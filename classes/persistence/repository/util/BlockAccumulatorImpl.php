<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\repository\util;

use function is_null;
use SRAG\Learnplaces\persistence\dto\Block;
use SRAG\Learnplaces\persistence\repository\AudioBlockRepository;
use SRAG\Learnplaces\persistence\repository\CommentBlockRepository;
use SRAG\Learnplaces\persistence\repository\exception\EntityNotFoundException;
use SRAG\Learnplaces\persistence\repository\ExternalStreamBlockRepository;
use SRAG\Learnplaces\persistence\repository\FeedbackBlockRepository;
use SRAG\Learnplaces\persistence\repository\HorizontalLineBlockRepository;
use SRAG\Learnplaces\persistence\repository\ILIASLinkBlockRepository;
use SRAG\Learnplaces\persistence\repository\MapBlockRepository;
use SRAG\Learnplaces\persistence\repository\PictureBlockRepository;
use SRAG\Learnplaces\persistence\repository\PictureUploadBlockRepository;
use SRAG\Learnplaces\persistence\repository\RichTextBlockRepository;
use SRAG\Learnplaces\persistence\repository\VideoBlockRepository;

/**
 * Class BlockAccumulatorImpl
 *
 * The block accumulator searches specific blocks by block ids or leanplace id.
 * For example a specific blocks are AudioBlock, VideoBlock ...
 * The block id is from the block data table and belongs to exact one specific block.
 *
 * @package SRAG\Learnplaces\persistence\repository\util
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class BlockAccumulatorImpl implements BlockAccumulator {

	/**
	 * @var PictureUploadBlockRepository $pictureUploadRepository
	 */
	private $pictureUploadRepository;
	/**
	 * @var ILIASLinkBlockRepository $iliasLinkBlockRepository
	 */
	private $iliasLinkBlockRepository;
	/**
	 * @var AudioBlockRepository $audioBlockRepository
	 */
	private $audioBlockRepository;
	/**
	 * @var HorizontalLineBlockRepository $horizontalLineRepository
	 */
	private $horizontalLineRepository;
	/**
	 * @var MapBlockRepository $mapBlockRepository
	 */
	private $mapBlockRepository;
	/**
	 * @var CommentBlockRepository $commentBlockRepository
	 */
	private $commentBlockRepository;
	/**
	 * @var VideoBlockRepository $videoBlockRepository
	 */
	private $videoBlockRepository;
	/**
	 * @var RichTextBlockRepository $richTextBlockRepository
	 */
	private $richTextBlockRepository;
	/**
	 * @var PictureBlockRepository $pictureBlockRepository
	 */
	private $pictureBlockRepository;
	/**
	 * @var ExternalStreamBlockRepository $externalStreamBlockRepository
	 */
	private $externalStreamBlockRepository;
	/**
	 * @var FeedbackBlockRepository $feedbackBlockRepository
	 */
	private $feedbackBlockRepository;


	/**
	 * BlockAccumulatorImpl constructor.
	 *
	 * @param PictureUploadBlockRepository  $pictureUploadRepository
	 * @param ILIASLinkBlockRepository      $iliasLinkBlockRepository
	 * @param AudioBlockRepository          $audioBlockRepository
	 * @param HorizontalLineBlockRepository $horizontalLineRepository
	 * @param MapBlockRepository            $mapBlockRepository
	 * @param CommentBlockRepository        $commentBlockRepository
	 * @param VideoBlockRepository          $videoBlockRepository
	 * @param RichTextBlockRepository       $richTextBlockRepository
	 * @param PictureBlockRepository        $pictureBlockRepository
	 * @param ExternalStreamBlockRepository $externalStreamBlockRepository
	 * @param FeedbackBlockRepository       $feedbackBlockRepository
	 */
	public function __construct(
		PictureUploadBlockRepository $pictureUploadRepository,
		ILIASLinkBlockRepository $iliasLinkBlockRepository,
		AudioBlockRepository $audioBlockRepository,
		HorizontalLineBlockRepository $horizontalLineRepository,
		MapBlockRepository $mapBlockRepository,
		CommentBlockRepository $commentBlockRepository,
		VideoBlockRepository $videoBlockRepository,
		RichTextBlockRepository $richTextBlockRepository,
		PictureBlockRepository $pictureBlockRepository,
		ExternalStreamBlockRepository $externalStreamBlockRepository,
		FeedbackBlockRepository $feedbackBlockRepository
	) {
		$this->pictureUploadRepository = $pictureUploadRepository;
		$this->iliasLinkBlockRepository = $iliasLinkBlockRepository;
		$this->audioBlockRepository = $audioBlockRepository;
		$this->horizontalLineRepository = $horizontalLineRepository;
		$this->mapBlockRepository = $mapBlockRepository;
		$this->commentBlockRepository = $commentBlockRepository;
		$this->videoBlockRepository = $videoBlockRepository;
		$this->richTextBlockRepository = $richTextBlockRepository;
		$this->pictureBlockRepository = $pictureBlockRepository;
		$this->externalStreamBlockRepository = $externalStreamBlockRepository;
		$this->feedbackBlockRepository = $feedbackBlockRepository;
	}


	/**
	 * @inheritdoc
	 */
	public function fetchSpecificBlocksById(int $id) : Block {
		$block =        $this->fetchBlock($id, $this->pictureUploadRepository)
					??  $this->fetchBlock($id, $this->iliasLinkBlockRepository)
					??  $this->fetchBlock($id, $this->audioBlockRepository)
					??  $this->fetchBlock($id, $this->horizontalLineRepository)
					??  $this->fetchBlock($id, $this->mapBlockRepository)
					??  $this->fetchBlock($id, $this->commentBlockRepository)
					??  $this->fetchBlock($id, $this->videoBlockRepository)
					??  $this->fetchBlock($id, $this->richTextBlockRepository)
					??  $this->fetchBlock($id, $this->pictureBlockRepository)
					??  $this->fetchBlock($id, $this->externalStreamBlockRepository)
					??  $this->fetchBlock($id, $this->feedbackBlockRepository);

		if(is_null($block))
			throw new EntityNotFoundException("Block with the id \"$id\" was not found.");

		return $block;
	}


	/**
	 * Tries to fetch the block with the given repository.
	 * This method swallows the entity not found exception because they are no issue here.
	 *
	 * This method assumes that the repository has a findByBlockId method with one int parameter.
	 *
	 * @param int       $id             The block id which should be used to fetch the specific block.
	 * @param object    $repository     The repository which should be used to fetch the block.
	 *
	 * @return Block | null             The block if the repository was able to find the it, or null on failure.
	 */
	private function fetchBlock(int $id, $repository) {
		try {
			return $repository->findByBlockId($id);
		}
		catch (EntityNotFoundException $ex) {
			return NULL;
		}
	}

}