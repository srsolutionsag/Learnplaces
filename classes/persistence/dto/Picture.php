<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\PictureModelMappingAware;

/**
 * Class Picture
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class Picture {

	use PictureModelMappingAware;

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
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return Picture
	 */
	public function setId(int $id): Picture {
		$this->id = $id;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getOriginalPath(): string {
		return $this->originalPath;
	}


	/**
	 * @param string $originalPath
	 *
	 * @return Picture
	 */
	public function setOriginalPath(string $originalPath): Picture {
		$this->originalPath = $originalPath;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getPreviewPath(): string {
		return $this->previewPath;
	}


	/**
	 * @param string $previewPath
	 *
	 * @return Picture
	 */
	public function setPreviewPath(string $previewPath): Picture {
		$this->previewPath = $previewPath;

		return $this;
	}
}