<?php
declare(strict_types=1);

use SRAG\Learnplaces\gui\block\AbstractBlockEditFormView;
use SRAG\Learnplaces\service\publicapi\model\ILIASLinkBlockModel;

/**
 * Class IliasLinkBlockEditFormView
 *
 * @package SRAG\Learnplaces\gui\block\IliasLinkBlock
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 * @ilCtrl_Calls xsrlIliasLinkBlockEditFormViewGUI: ilFormPropertyDispatchGUI
 */
final class xsrlIliasLinkBlockEditFormViewGUI extends AbstractBlockEditFormView {

	const POST_REFID = 'post_refid';
	/**
	 * @var ILIASLinkBlockModel $block
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
		$link = new ilLinkInputGUI($this->plugin->txt('ilias_link_block_select_target'), self::POST_REFID);
		$link->setInternalLinkFilterTypes(['RepositoryItem']);
		$link->setRequired(true);
		$link->setAllowedLinkTypes(ilLinkInputGUI::INT);

		$this->addItem($link);
	}


	/**
	 * @inheritDoc
	 */
	protected function createValueArrayForSpecificFormParts(): array {
		$values = [
			self::POST_REFID => $this->denormalizeRefId($this->block->getRefId()),
		];

		return $values;
	}


	/**
	 * @inheritDoc
	 */
	protected function getFormActionUrl(): string {
		return $this->ctrl->getFormActionByClass(xsrlIliasLinkBlockGUI::class);
	}


	/**
	 * @inheritDoc
	 */
	protected function getObject() {
		//raw value looks like "xsrl|74"
		$rawValue = $this->getInput(self::POST_REFID);
		$delimiter = '|';
		$lastElement = end(explode($delimiter, $rawValue));
		$this->block->setRefId(intval($lastElement));
	}


	/**
	 * Denormalize the ref id to a notation for the ilLinkInputGUI which looks like 'xsrl|74'
	 *
	 * @param int $id   The ref id which should be transformed.
	 *
	 * @return string   The transformed ref id.
	 */
	private function denormalizeRefId(int $id): string {
		$isReference = true;
		$type = ilObject::_lookupType($id, $isReference);
		$notation = "$type|$id";
		return $notation;
	}
}