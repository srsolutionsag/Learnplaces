<?php

use League\Flysystem\FilesystemInterface;
use SRAG\Learnplaces\container\PluginContainer;

require_once __DIR__ . '/bootstrap.php';

/**
 * Class ilLearnplacesPlugin
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class ilLearnplacesPlugin extends ilRepositoryObjectPlugin {

	const PLUGIN_NAME = "Learnplaces";
	const PLUGIN_ID = "xsrl";
	/**
	 * @var ilLearnplacesPlugin $instance
	 */
	private static $instance;


	/**
	 * ilLearnplacesPlugin constructor.
	 */
	public function __construct() {
		parent::__construct();

		self::$instance = $this;
	}


	public static function getInstance() {
		if(is_null(self::$instance))
			self::$instance = new self();
		return self::$instance;
	}



	public function getPluginName() {
		return self::PLUGIN_NAME;
	}




	protected function uninstallCustom() {
		$this->dropDatabase();
		$this->deleteFiles();
	}

	private function dropDatabase() {

		$database = PluginContainer::resolve(ilDB::class);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\AccordionBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\AccordionBlockMember::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Answer::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\AudioBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Block::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Comment::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\CommentBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Configuration::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\ExternalStreamBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\FeedbackBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Feedback::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\HorizontalLineBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\ILIASLinkBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Learnplace::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\LearnplaceConstraint::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Location::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\MapBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Picture::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\PictureBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\PictureGalleryEntry::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\PictureUploadBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\RichTextBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\VideoBlock::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\Visibility::returnDbTableName(), false);
		$database->dropTable(\SRAG\Learnplaces\persistence\entity\VisitJournal::returnDbTableName(), false);
	}

	private function deleteFiles() {
		/**
		 * @var FilesystemInterface $filesystem
		 */
		$filesystem = PluginContainer::resolve(FilesystemInterface::class);
		$directories = $filesystem->listContents(ilUtil::getWebspaceDir());

		$regex = '/\/' . ilLearnplacesPlugin::PLUGIN_ID . '_\d{1,}$/'; // matches for example /xsrl_254
		foreach ($directories as $directory) {
			$path = $directory['path'];
			if(preg_match($regex, $path) === 1)
				$filesystem->deleteDir($path);
		}
	}
}