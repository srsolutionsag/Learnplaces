<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class ILIASLinkBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ILIASLinkBlock extends Block {

	/**
	 * @var int $refId
	 */
	private $refId;


	/**
	 * @return int
	 */
	public function getRefId() {
		return $this->refId;
	}


	/**
	 * @param int $refId
	 *
	 * @return ILIASLinkBlock
	 */
	public function setRefId($refId) {
		$this->refId = $refId;

		return $this;
	}
}