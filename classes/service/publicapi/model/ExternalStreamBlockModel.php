<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\ExternalStreamBlockDtoMappingAware;

/**
 * Class ExternalStreamBlock
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ExternalStreamBlockModel extends BlockModel {

	use ExternalStreamBlockDtoMappingAware;

	/**
	 * @var string $url
	 */
	private $url;


	/**
	 * @return string
	 */
	public function getUrl(): string {
		return $this->url;
	}


	/**
	 * @param string $url
	 *
	 * @return ExternalStreamBlockModel
	 */
	public function setUrl(string $url): ExternalStreamBlockModel {
		$this->url = $url;

		return $this;
	}

}