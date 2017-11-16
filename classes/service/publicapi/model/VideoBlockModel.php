<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\VideoBlockDtoMappingAware;

/**
 * Class VideoBlock
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlockModel extends BlockModel {

	use VideoBlockDtoMappingAware;

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
	public function getPath(): string {
		return $this->path;
	}


	/**
	 * @param string $path
	 *
	 * @return VideoBlockModel
	 */
	public function setPath(string $path): VideoBlockModel {
		$this->path = $path;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getCoverPath(): string {
		return $this->coverPath;
	}


	/**
	 * @param string $coverPath
	 *
	 * @return VideoBlockModel
	 */
	public function setCoverPath(string $coverPath): VideoBlockModel {
		$this->coverPath = $coverPath;

		return $this;
	}

}