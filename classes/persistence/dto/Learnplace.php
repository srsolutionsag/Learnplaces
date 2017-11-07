<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

/**
 * Class Learnplace
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Learnplace {

	/**
	 * @var int $id
	 */
	private $id = 0;
	/**
	 * @var int $objectId
	 */
	private $objectId = 0;
	/**
	 * @var Configuration $configuration
	 */
	private $configuration;
	/**
	 * @var VisitJournal[] $visitJournals
	 */
	private $visitJournals = [];
	/**
	 * @var Picture[]
	 */
	private $pictures = [];
	/**
	 * @var Feedback[]
	 */
	private $feedback = [];

	//--------- Blocks ------------
	/**
	 * @var AccordionBlock[]
	 */
	private $accordionBlocks = [];
	/**
	 * @var FeedbackBlock[]
	 */
	private $feedbackBlocks = [];
	/**
	 * @var ExternalStreamBlock[]
	 */
	private $externalStreamBlocks = [];
	/**
	 * @var PictureBlock[]
	 */
	private $pictureBlocks = [];
	/**
	 * @var RichTextBlock[]
	 */
	private $richtTextBlock = [];
	/**
	 * @var VideoBlock[]
	 */
	private $videoBlock = [];
	/**
	 * @var CommentBlock $commentBlock
	 */
	private $commentBlock;
	/**
	 * @var MapBlock $mapBlock
	 */
	private $mapBlock;
	/**
	 * @var HorizontalLineBlock[] $horizontalLineBlocks
	 */
	private $horizontalLineBlocks = [];
	/**
	 * @var AudioBlock[] $audioBlocks
	 */
	private $audioBlocks = [];
	/**
	 * @var ILIASLinkBlock[] $iliasLinkBlocks
	 */
	private $iliasLinkBlocks = [];
	/**
	 * @var PictureUploadBlock $pictureUploadBlock
	 */
	private $pictureUploadBlock;
	//----- blocks end ------


	/**
	 * @return AccordionBlock[]
	 */
	public function getAccordionBlocks(): array {
		return $this->accordionBlocks;
	}


	/**
	 * @param AccordionBlock[] $accordionBlocks
	 *
	 * @return Learnplace
	 */
	public function setAccordionBlocks(array $accordionBlocks): Learnplace {
		$this->accordionBlocks = $accordionBlocks;

		return $this;
	}


	/**
	 * @return FeedbackBlock[]
	 */
	public function getFeedbackBlocks(): array {
		return $this->feedbackBlocks;
	}


	/**
	 * @param FeedbackBlock[] $feedbackBlocks
	 *
	 * @return Learnplace
	 */
	public function setFeedbackBlocks(array $feedbackBlocks): Learnplace {
		$this->feedbackBlocks = $feedbackBlocks;

		return $this;
	}


	/**
	 * @return ExternalStreamBlock[]
	 */
	public function getExternalStreamBlocks(): array {
		return $this->externalStreamBlocks;
	}


	/**
	 * @param ExternalStreamBlock[] $externalStreamBlocks
	 *
	 * @return Learnplace
	 */
	public function setExternalStreamBlocks(array $externalStreamBlocks): Learnplace {
		$this->externalStreamBlocks = $externalStreamBlocks;

		return $this;
	}


	/**
	 * @return PictureBlock[]
	 */
	public function getPictureBlocks(): array {
		return $this->pictureBlocks;
	}


	/**
	 * @param PictureBlock[] $pictureBlocks
	 *
	 * @return Learnplace
	 */
	public function setPictureBlocks(array $pictureBlocks): Learnplace {
		$this->pictureBlocks = $pictureBlocks;

		return $this;
	}


	/**
	 * @return RichTextBlock[]
	 */
	public function getRichtTextBlock(): array {
		return $this->richtTextBlock;
	}


	/**
	 * @param RichTextBlock[] $richtTextBlock
	 *
	 * @return Learnplace
	 */
	public function setRichtTextBlock(array $richtTextBlock): Learnplace {
		$this->richtTextBlock = $richtTextBlock;

		return $this;
	}


	/**
	 * @return VideoBlock[]
	 */
	public function getVideoBlock(): array {
		return $this->videoBlock;
	}


	/**
	 * @param VideoBlock[] $videoBlock
	 *
	 * @return Learnplace
	 */
	public function setVideoBlock(array $videoBlock): Learnplace {
		$this->videoBlock = $videoBlock;

		return $this;
	}


	/**
	 * @return CommentBlock
	 */
	public function getCommentBlock(): CommentBlock {
		return $this->commentBlock;
	}


	/**
	 * @param CommentBlock $commentBlock
	 *
	 * @return Learnplace
	 */
	public function setCommentBlock(CommentBlock $commentBlock): Learnplace {
		$this->commentBlock = $commentBlock;

		return $this;
	}


	/**
	 * @return MapBlock
	 */
	public function getMapBlock(): MapBlock {
		return $this->mapBlock;
	}


	/**
	 * @param MapBlock $mapBlock
	 *
	 * @return Learnplace
	 */
	public function setMapBlock(MapBlock $mapBlock): Learnplace {
		$this->mapBlock = $mapBlock;

		return $this;
	}


	/**
	 * @return HorizontalLineBlock[]
	 */
	public function getHorizontalLineBlocks(): array {
		return $this->horizontalLineBlocks;
	}


	/**
	 * @param HorizontalLineBlock[] $horizontalLineBlocks
	 *
	 * @return Learnplace
	 */
	public function setHorizontalLineBlocks(array $horizontalLineBlocks): Learnplace {
		$this->horizontalLineBlocks = $horizontalLineBlocks;

		return $this;
	}


	/**
	 * @return AudioBlock[]
	 */
	public function getAudioBlocks(): array {
		return $this->audioBlocks;
	}


	/**
	 * @param AudioBlock[] $audioBlocks
	 *
	 * @return Learnplace
	 */
	public function setAudioBlocks(array $audioBlocks): Learnplace {
		$this->audioBlocks = $audioBlocks;

		return $this;
	}


	/**
	 * @return ILIASLinkBlock[]
	 */
	public function getIliasLinkBlocks(): array {
		return $this->iliasLinkBlocks;
	}


	/**
	 * @param ILIASLinkBlock[] $iliasLinkBlocks
	 *
	 * @return Learnplace
	 */
	public function setIliasLinkBlocks(array $iliasLinkBlocks): Learnplace {
		$this->iliasLinkBlocks = $iliasLinkBlocks;

		return $this;
	}


	/**
	 * @return PictureUploadBlock
	 */
	public function getPictureUploadBlock(): PictureUploadBlock {
		return $this->pictureUploadBlock;
	}


	/**
	 * @param PictureUploadBlock $pictureUploadBlock
	 *
	 * @return Learnplace
	 */
	public function setPictureUploadBlock(PictureUploadBlock $pictureUploadBlock): Learnplace {
		$this->pictureUploadBlock = $pictureUploadBlock;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}

	/**
	 * @param int $id
	 *
	 * @return Learnplace
	 */
	public function setId(int $id): Learnplace {
		$this->id = $id;

		return $this;
	}

	/**
	 * @return Configuration
	 */
	public function getConfiguration(): Configuration {
		return $this->configuration;
	}


	/**
	 * @param Configuration $configuration
	 *
	 * @return Learnplace
	 */
	public function setConfiguration(Configuration $configuration): Learnplace {
		$this->configuration = $configuration;

		return $this;
	}


	/**
	 * @return VisitJournal[]
	 */
	public function getVisitJournals(): array {
		return $this->visitJournals;
	}


	/**
	 * @param VisitJournal[] $visitJournals
	 *
	 * @return Learnplace
	 */
	public function setVisitJournals(array $visitJournals): Learnplace {
		$this->visitJournals = $visitJournals;

		return $this;
	}


	/**
	 * @return int
	 */
	public function getObjectId(): int {
		return $this->objectId;
	}


	/**
	 * @param int $objectId
	 *
	 * @return Learnplace
	 */
	public function setObjectId(int $objectId): Learnplace {
		$this->objectId = $objectId;

		return $this;
	}


	/**
	 * @return Picture[]
	 */
	public function getPictures(): array {
		return $this->pictures;
	}


	/**
	 * @param Picture[] $pictures
	 *
	 * @return Learnplace
	 */
	public function setPictures(array $pictures): Learnplace {
		$this->pictures = $pictures;

		return $this;
	}


	/**
	 * @return Feedback[]
	 */
	public function getFeedback(): array {
		return $this->feedback;
	}


	/**
	 * @param Feedback[] $feedback
	 *
	 * @return Learnplace
	 */
	public function setFeedback(array $feedback): Learnplace {
		$this->feedback = $feedback;

		return $this;
	}
}