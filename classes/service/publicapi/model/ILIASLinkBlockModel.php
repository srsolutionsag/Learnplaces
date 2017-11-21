<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\ILIASLinkBlockDtoMappingAware;

/**
 * Class ILIASLinkBlock
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ILIASLinkBlockModel extends BlockModel {

	use ILIASLinkBlockDtoMappingAware;

	/**
	 * @var int $refId
	 */
	private $refId = 0;


	/**
	 * @return int
	 */
	public function getRefId(): int {
		return $this->refId;
	}


	/**
	 * @param int $refId
	 *
	 * @return ILIASLinkBlockModel
	 */
	public function setRefId(int $refId): ILIASLinkBlockModel {
		$this->refId = $refId;

		return $this;
	}
}