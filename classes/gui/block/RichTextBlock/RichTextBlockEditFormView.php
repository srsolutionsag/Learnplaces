<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\gui\block\RichTextBlock;

use ilLearnplacesPlugin;
use ilTextAreaInputGUI;
use SRAG\Learnplaces\gui\block\AbstractBlockEditFormView;
use SRAG\Learnplaces\service\publicapi\model\RichTextBlockModel;
use xsrlRichTextBlockGUI;

/**
 * Class RichTextBlockEditFormView
 *
 * @package SRAG\Learnplaces\gui\block\RichTextBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class RichTextBlockEditFormView extends AbstractBlockEditFormView {

	const POST_CONTENT = 'post_content';
	/**
	 * @var RichTextBlockModel $block
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
		$textArea = new ilTextAreaInputGUI($this->plugin->txt('rich_text_block_content'), self::POST_CONTENT);
		$textArea->setRequired(true);

		$textArea->setRTESupport(\ilObject::_lookupObjId($_GET['ref_id']), "dcl", ilLearnplacesPlugin::PLUGIN_ID, null, false); // We have to prepend that this is a datacollection
		$textArea->setUseRte(true);
		$textArea->setRteTags([
			'p',
			'br',
			'strong',
			'b',
			'i',
			'em',
			'span',
		]);
		$textArea->usePurifier(true);
		$textArea->disableButtons(array(
			'charmap',
			'undo',
			'redo',
			'justifyleft',
			'justifycenter',
			'justifyright',
			'justifyfull',
			'anchor',
			'fullscreen',
			'cut',
			'copy',
			'paste',
			'pastetext',
			'formatselect',
			'bullist',
			'hr',
			'sub',
			'sup',
			'numlist',
			'cite',
			'removeformat',
			'indent',
			'outdent',
			'link',
			'unlink',
			'code',
			'ilimgupload',
			'pasteword',
		));
		$this->addItem($textArea);
	}


	/**
	 * @inheritDoc
	 */
	protected function createValueArrayForSpecificFormParts(): array {
		return [
			self::POST_CONTENT => $this->block->getContent(),
		];
	}


	/**
	 * @inheritDoc
	 */
	protected function getFormActionUrl(): string {
		return $this->ctrl->getFormActionByClass(xsrlRichTextBlockGUI::class);
	}


	/**
	 * @inheritDoc
	 */
	protected function getObject() {
		$this->block->setContent($this->getInput(self::POST_CONTENT));
	}
}