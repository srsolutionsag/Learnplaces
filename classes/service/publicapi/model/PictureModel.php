<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\PictureDtoMappingAware;

/**
 * Class Picture
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class PictureModel {

	use PictureDtoMappingAware;

	/**
	 * @var int $id
	 */
	private $id = 0;

	/**
	 * @var string $originalPath
	 */
	private $originalPath = "";
	/**
	 * @var string $previewPath
	 */
	private $previewPath = "";


	/**
	 * @return int
	 */
	public function getId(): int {
		return $this->id;
	}


	/**
	 * @param int $id
	 *
	 * @return PictureModel
	 */
	public function setId(int $id): PictureModel {
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
	 * @return PictureModel
	 */
	public function setOriginalPath(string $originalPath): PictureModel {
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
	 * @return PictureModel
	 */
	public function setPreviewPath(string $previewPath): PictureModel {
		$this->previewPath = $previewPath;

		return $this;
	}
}