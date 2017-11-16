<?php
declare(strict_types=1);

namespace SRAG\Learnplaces\service\publicapi\model;

use SRAG\Lernplaces\persistence\mapping\PictureUploadBlockDtoMappingAware;

/**
 * Class PictureUploadBlock
 *
 * @package SRAG\Learnplaces\service\model
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class PictureUploadBlockModel extends BlockModel {
	use PictureUploadBlockDtoMappingAware;
}