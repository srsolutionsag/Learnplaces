<?php

namespace SRAG\Learnplaces\gui\helper;

use ILIAS\DI\Container;

/**
 * Class DIC
 *
 * @author Fabian Schmid <fs@studer-raimann.ch>
 */
trait DIC {

	/**
	 * @var \ilAccessHandler
	 */
	private $access;
	/**
	 * @var \ilObjUser
	 */
	private $user;
	/**
	 * @var \ilCtrl
	 */
	private $ctrl;
	/**
	 * @var \ilTemplate
	 */
	private $tpl;
	/**
	 * @var \ilLanguage
	 */
	private $language;
	/**
	 * @var \ilTabsGUI
	 */
	private $tabs;


	/**
	 * Ctrl constructor.
	 */
	public function __construct(\ilCtrl $ctrl, \ilTemplate $tpl, \ilLanguage $lng, \ilTabsGUI $tabs, \ilObjUser $user, \ilAccessHandler $access) {
		$this->ctrl = $ctrl;
		$this->tpl = $tpl;
		$this->language = $lng;
		$this->tabs = $tabs;
		$this->user = $user;
		$this->access = $access;
	}


	/**
	 * @param \ILIAS\DI\Container $dic
	 */
	public function initFromDIC(Container $dic) {
		$this->ctrl = $dic->ctrl();
		$this->tpl = $dic->ui()->mainTemplate();
		$this->language = $dic->language();
		$this->tabs = $dic->tabs();
		$this->user = $dic->user();
		$this->access = $dic->access();
	}


	/**
	 * @return \ILIAS\DI\Container
	 */
	private function dic() {
		return $GLOBALS['DIC'];
	}


	/**
	 * @return \ilCtrl
	 */
	protected function ctrl() {
		return $this->ctrl;
	}


	/**
	 * @param $variable
	 *
	 * @return string
	 */
	public function ptxt($variable) {
		return $this->language->txt($variable);
	}


	/**
	 * @return \ilTemplate
	 */
	protected function tpl() {
		return $this->tpl;
	}


	/**
	 * @return \ilLanguage
	 */
	protected function language() {
		return $this->language;
	}


	/**
	 * @return \ilTabsGUI
	 */
	protected function tabs() {
		return $this->tabs;
	}


	/**
	 * @return \ILIAS\DI\UIServices
	 */
	protected function ui() {
		return $this->dic()->ui();
	}


	/**
	 * @return \ilObjUser
	 */
	protected function user() {
		return $this->user;
	}


	/**
	 * @return \ilAccessHandler
	 */
	public function access() {
		return $this->dic()->access();
	}


	public function getCurrentRefId() {
		//		try {
		//			$http = $this->dic()->http();
		//			$ref_id = $http->request()->getQueryParams()["ref_id"];
		//		} catch (\Exception $e) {
		//		}
		$ref_id = $_GET['ref_id'];

		return $ref_id;
	}
}
