<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\PictureBlock;

use ilFileInputGUI;
use const ILIAS_VERSION_NUMERIC;
use ilTextAreaInputGUI;
use ilTextInputGUI;
use SRAG\Learnplaces\gui\block\AbstractBlockEditFormView;
use SRAG\Learnplaces\service\publicapi\model\PictureBlockModel;
use SRAG\Learnplaces\service\publicapi\model\PictureUploadBlockModel;
use function version_compare;
use xsrlPictureBlockGUI;

/**
 * Class PictureBlockEditFormView
 *
 * @package SRAG\Learnplaces\gui\block\PictureBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PictureBlockEditFormView extends AbstractBlockEditFormView {

	const POST_TITLE = 'post_title';
	const POST_DESCRIPTION = 'post_description';
	const POST_IMAGE = 'post_image';

	/**
	 * @var PictureBlockModel $model
	 */
	protected $block;


	/**
	 * PictureBlockEditFormView constructor.
	 *
	 * @param PictureBlockModel $model
	 */
	public function __construct(PictureBlockModel $model) {
		parent::__construct($model);
	}


	/**
	 * @inheritDoc
	 */
	protected function hasBlockSpecificParts(): bool {
		return true;
	}


	/**
	 * @inheritDoc
	 */
	protected function initBlockSpecificForm() {
		$title = new ilTextInputGUI($this->plugin->txt('picture_block_enter_title'), self::POST_TITLE);
		$title->setMaxLength(256);
		$description = new ilTextAreaInputGUI($this->plugin->txt('picture_block_enter_description'), self::POST_DESCRIPTION);
		if(version_compare(ILIAS_VERSION_NUMERIC, '5.3') >= 0)
			$description->setMaxNumOfChars(2000);

		$fileUpload = new ilFileInputGUI($this->plugin->txt('picture_block_select_picture'), self::POST_IMAGE);
		$fileUpload->setSuffixes(['jpg', 'png']);
		$fileUpload->setRequired($this->block->getId() <= 0);

		$this->addItem($title);
		$this->addItem($description);
		$this->addItem($fileUpload);
	}


	/**
	 * @inheritDoc
	 */
	protected function createValueArrayForSpecificFormParts(): array {
		$values = [
			self::POST_TITLE => $this->block->getTitle(),
			self::POST_DESCRIPTION => $this->block->getDescription(),
		];

		return $values;
	}


	/**
	 * @inheritDoc
	 */
	protected function getFormActionUrl(): string {
		return $this->ctrl->getFormActionByClass(xsrlPictureBlockGUI::class);
	}


	/**
	 * @inheritDoc
	 */
	protected function getObject() {
		$this->block->setTitle($this->getInput(self::POST_TITLE));
		$this->block->setDescription($this->getInput(self::POST_DESCRIPTION));
	}
}