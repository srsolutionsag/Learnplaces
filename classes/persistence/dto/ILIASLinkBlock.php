<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\ILIASLinkBlockModelMappingAware;

/**
 * Class ILIASLinkBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ILIASLinkBlock extends Block {

	use ILIASLinkBlockModelMappingAware;

	/**
	 * @var int $refId
	 */
	private $refId;


	/**
	 * @return int
	 */
	public function getRefId(): int {
		return $this->refId;
	}


	/**
	 * @param int $refId
	 *
	 * @return ILIASLinkBlock
	 */
	public function setRefId(int $refId): ILIASLinkBlock {
		$this->refId = $refId;

		return $this;
	}
}