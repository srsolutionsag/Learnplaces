<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class ExternalStreamBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ExternalStreamBlock extends Block {

	/**
	 * @var string $url
	 */
	private $url;


	/**
	 * @return string
	 */
	public function getUrl() {
		return $this->url;
	}


	/**
	 * @param string $url
	 */
	public function setUrl($url) {
		$this->url = $url;
	}
}