<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\VideoBlockModelMappingAware;

/**
 * Class VideoBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class VideoBlock extends Block {

	use VideoBlockModelMappingAware;

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
	 * @return VideoBlock
	 */
	public function setPath(string $path): VideoBlock {
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
	 * @return VideoBlock
	 */
	public function setCoverPath(string $coverPath): VideoBlock {
		$this->coverPath = $coverPath;

		return $this;
	}

}