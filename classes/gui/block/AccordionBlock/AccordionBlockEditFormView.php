<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\AccordionBlock;

use function boolval;
use ilCheckboxInputGUI;
use ilTextInputGUI;
use SRAG\Learnplaces\gui\block\AbstractBlockEditFormView;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use xsrlAccordionBlockGUI;

/**
 * Class AccordionBlockEditFormView
 *
 * @package SRAG\Learnplaces\gui\block\AccordionBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class AccordionBlockEditFormView extends AbstractBlockEditFormView {

	const POST_TITLE = 'post_title';
	const POST_EXPAND = 'post_expand';
	/**
	 * @var AccordionBlockModel $block
	 */
	protected $block;

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
		$title = new ilTextInputGUI($this->plugin->txt('accordion_block_title'), self::POST_TITLE);
		$title->setMaxLength(256);
		$title->setRequired(true);

		$expand = new ilCheckboxInputGUI($this->plugin->txt('accordion_block_expand'), self::POST_EXPAND);
		$expand->setChecked(true);

		$this->addItem($title);
		$this->addItem($expand);
	}


	/**
	 * @inheritDoc
	 */
	protected function createValueArrayForSpecificFormParts(): array {
		return [
			self::POST_TITLE => $this->block->getTitle(),
			self::POST_EXPAND => $this->block->isExpand(),
		];
	}


	/**
	 * @inheritDoc
	 */
	protected function getFormActionUrl(): string {
		return $this->ctrl->getFormActionByClass(xsrlAccordionBlockGUI::class);
	}


	/**
	 * @inheritDoc
	 */
	protected function getObject() {
		$this->block->setTitle($this->getInput(self::POST_TITLE));
		$this->block->setExpand(boolval($this->getInput(self::POST_EXPAND)));
	}
}