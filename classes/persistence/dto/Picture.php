<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class Picture
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Picture {

	/**
	 * @var int $id
	 */
	private $id;

	/**
	 * @var string $originalPath
	 */
	private $originalPath;
	/**
	 * @var string $previewPath
	 */
	private $previewPath;


	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Picture
	 */
	public function setId($id) {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getOriginalPath() {
		return $this->originalPath;
	}


	/**
	 * @param string $originalPath
	 *
	 * @return Picture
	 */
	public function setOriginalPath($originalPath) {
		$this->originalPath = $originalPath;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getPreviewPath() {
		return $this->previewPath;
	}


	/**
	 * @param string $previewPath
	 *
	 * @return Picture
	 */
	public function setPreviewPath($previewPath) {
		$this->previewPath = $previewPath;

		return $this;
	}
}