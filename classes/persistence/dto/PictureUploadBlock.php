<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\persistence\dto;

use SRAG\Lernplaces\persistence\mapping\PictureUploadBlockMappingAware;

/**
 * Class PictureUploadBlock
 *
 * @package SRAG\Learnplaces\persistence\dto
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureUploadBlock extends Block {

	use PictureUploadBlockMappingAware;
}