<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block;

use xsrlPictureUploadBlockGUI;

/**
 * Class PictureUploadBlockEditFormView
 *
 * @package SRAG\Learnplaces\gui\block
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PictureUploadBlockEditFormView extends AbstractBlockEditFormView {

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
		return $this->ctrl->getFormActionByClass(xsrlPictureUploadBlockGUI::class);
	}


	/**
	 * @inheritDoc
	 */
	protected function initBlockSpecificForm() {
	}


	/**
	 * @inheritDoc
	 */
	protected function fillBlockSpecificFormParts() {
	}


	/**
	 * @inheritDoc
	 */
	protected function getObject() {
	}
}