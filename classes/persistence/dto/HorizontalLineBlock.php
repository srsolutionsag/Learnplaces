<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\HorizontalLineBlockModelMappingAware;

/**
 * Class HorizontalLineBlock
 *
 * @package SRAG\Lernplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class HorizontalLineBlock extends Block {
	use HorizontalLineBlockModelMappingAware;
}