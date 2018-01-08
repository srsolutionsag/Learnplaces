<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\VideoBlock;

use ilFileInputGUI;
use SRAG\Learnplaces\gui\block\AbstractBlockEditFormView;
use xsrlVideoBlockGUI;

/**
 * Class VideoBlockEditFormView
 *
 * @package SRAG\Learnplaces\gui\block\VideoBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class VideoBlockEditFormView extends AbstractBlockEditFormView {

	const POST_VIDEO = 'post_video';

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

		$fileUpload = new ilFileInputGUI($this->plugin->txt('video_block_select_video'), self::POST_VIDEO);
		$fileUpload->setSuffixes(['mp4']);
		$fileUpload->setRequired($this->block->getId() <= 0);

		$this->addItem($fileUpload);
	}


	/**
	 * @inheritDoc
	 */
	protected function createValueArrayForSpecificFormParts(): array {
		return [];
	}


	/**
	 * @inheritDoc
	 */
	protected function getFormActionUrl(): string {
		return $this->ctrl->getFormActionByClass(xsrlVideoBlockGUI::class);
	}


	/**
	 * @inheritDoc
	 */
	protected function getObject() {

	}
}