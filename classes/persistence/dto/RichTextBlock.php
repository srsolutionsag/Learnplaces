<?php

namespace SRAG\Lernplaces\persistence\dto;

/**
 * Class RichTextBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class RichTextBlock extends Block {

	/**
	 * @var string $content
	 */
	private $content;


	/**
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}


	/**
	 * @param string $content
	 *
	 * @return RichTextBlock
	 */
	public function setContent($content) {
		$this->content = $content;

		return $this;
	}
}