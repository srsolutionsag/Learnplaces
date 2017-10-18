<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class VideoBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlock extends Block {

	/**
	 * @var string $path
	 */
	private $path;
	/**
	 * @var string $coverPath
	 */
	private $coverPath;


	/**
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}


	/**
	 * @param string $path
	 */
	public function setPath($path) {
		$this->path = $path;
	}


	/**
	 * @return string
	 */
	public function getCoverPath() {
		return $this->coverPath;
	}


	/**
	 * @param string $coverPath
	 */
	public function setCoverPath($coverPath) {
		$this->coverPath = $coverPath;
	}
}