<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

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
	public function getContent(): string {
		return $this->content;
	}


	/**
	 * @param string $content
	 *
	 * @return RichTextBlock
	 */
	public function setContent(string $content): RichTextBlock {
		$this->content = $content;

		return $this;
	}

}