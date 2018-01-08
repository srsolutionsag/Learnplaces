<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\FeedbackBlockModelMappingAware;

/**
 * Class FeedbackBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class FeedbackBlock extends Block {
	use FeedbackBlockModelMappingAware;
}