<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class AudioBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AudioBlock extends Block {

	/**
	 * @var string $path
	 */
	private $path;


	/**
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}


	/**
	 * @param string $path
	 *
	 * @return AudioBlock
	 */
	public function setPath($path) {
		$this->path = $path;

		return $this;
	}

}