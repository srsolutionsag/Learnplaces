<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\AudioBlockDtoMappingAware;

/**
 * Class AudioBlockModelModel
 *
 * @package SRAG\Learnplaces\service\publicapi\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AudioBlockModel extends BlockModel {

	use AudioBlockDtoMappingAware;

	/**
	 * @var string $path
	 */
	private $path = "";


	/**
	 * @return string
	 */
	public function getPath(): string {
		return $this->path;
	}


	/**
	 * @param string $path
	 *
	 * @return AudioBlockModel
	 */
	public function setPath(string $path): AudioBlockModel {
		$this->path = $path;

		return $this;
	}

}