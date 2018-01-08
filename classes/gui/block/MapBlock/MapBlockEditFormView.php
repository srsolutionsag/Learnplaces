<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\PictureUploadBlock;

use SRAG\Learnplaces\gui\block\AbstractBlockEditFormView;
use xsrlMapBlockGUI;

/**
 * Class MapBlockEditFormView
 *
 * @package SRAG\Learnplaces\gui\block\PictureUploadBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class MapBlockEditFormView extends AbstractBlockEditFormView {

	/**
	 * @inheritDoc
	 */
	protected function hasBlockSpecificParts(): bool {
		return false;
	}


	/**
	 * @inheritDoc
	 */
	protected function getFormActionUrl(): string {
		return $this->ctrl->getFormActionByClass(xsrlMapBlockGUI::class);
	}


	/**
	 * @inheritDoc
	 */
	protected function initBlockSpecificForm() {
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
	protected function getObject() {
	}
}