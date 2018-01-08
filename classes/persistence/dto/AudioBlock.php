<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\AudioBlockModelMappingAware;

/**
 * Class AudioBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class AudioBlock extends Block {

	use AudioBlockModelMappingAware;

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
	 * @return AudioBlock
	 */
	public function setPath(string $path): AudioBlock {
		$this->path = $path;

		return $this;
	}

}