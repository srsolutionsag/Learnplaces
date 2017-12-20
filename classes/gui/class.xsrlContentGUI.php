<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface;
use SRAG\Learnplaces\container\PluginContainer;
use SRAG\Learnplaces\gui\block\BlockAddFormGUI;
use SRAG\Learnplaces\gui\block\BlockType;
use SRAG\Learnplaces\gui\block\RenderableBlockViewFactory;
use SRAG\Learnplaces\gui\block\util\AccordionAware;
use SRAG\Learnplaces\gui\block\util\ReferenceIdAware;
use SRAG\Learnplaces\gui\component\PlusView;
use SRAG\Learnplaces\gui\ContentPresentationView;
use SRAG\Learnplaces\gui\helper\CommonControllerAction;
use SRAG\Learnplaces\service\publicapi\block\AccordionBlockService;
use SRAG\Learnplaces\service\publicapi\block\LearnplaceService;
use SRAG\Learnplaces\service\publicapi\model\AccordionBlockModel;
use SRAG\Learnplaces\service\publicapi\model\BlockModel;
use SRAG\Learnplaces\service\publicapi\model\MapBlockModel;
use SRAG\Learnplaces\service\security\AccessGuard;
use SRAG\Learnplaces\service\visibility\LearnplaceServiceDecoratorFactory;

/**
 *
 *
 * Wie https://git.studer-raimann.ch/ILIAS/Core/blob/feature/5-4/bibliographic-improvements/Modules/Bibliographic/classes/FieldFilter/class.ilBiblFieldFilterGUI.php
 *
 *
 * Class xsrlContentGUI
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
final class xsrlContentGUI {

	use ReferenceIdAware;
	use AccordionAware;

	const TAB_ID = 'content';
	/**
	 * Command to store the sequence numbers
	 */
	const CMD_SEQUENCE = 'sequence';

	private static $blockTypeViewMapping = [
		//BlockType::PICTURE_UPLOAD   => xsrlPictureUploadBlockGUI::class,
		BlockType::PICTURE          => xsrlPictureBlockGUI::class,
		BlockType::RICH_TEXT        => xsrlRichTextBlockGUI::class,
		BlockType::ILIAS_LINK       => xsrlIliasLinkBlockGUI::class,
		BlockType::MAP              => xsrlMapBlockGUI::class,
		BlockType::VIDEO            => xsrlVideoBlockGUI::class,
		BlockType::ACCORDION        => xsrlAccordionBlockGUI::class,
	];

	/**
	 * @var ilTabsGUI $tabs
	 */
	private $tabs;
	/**
	 * @var ilTemplate $template
	 */
	private $template;
	/**
	 * @var ilCtrl $controlFlow
	 */
	private $controlFlow;
	/**
	 * @var ilLearnplacesPlugin $plugin
	 */
	private $plugin;
	/**
	 * @var RenderableBlockViewFactory $renderableFactory
	 */
	private $renderableFactory;
	/**
	 * @var LearnplaceService $learnplaceService
	 */
	private $learnplaceService;
	/**
	 * @var AccordionBlockService $accordionService
	 */
	private $accordionService;
	/**
	 * @var LearnplaceServiceDecoratorFactory $learnplaceServiceDecorationFactory
	 */
	private $learnplaceServiceDecorationFactory;
	/**
	 * @var BlockAddFormGUI $blockAddGUI
	 */
	private $blockAddGUI;
	/**
	 * @var ServerRequestInterface $request
	 */
	private $request;
	/**
	 * @var AccessGuard $accessGuard
	 */
	private $accessGuard;


	/**
	 * xsrlContentGUI constructor.
	 *
	 * @param ilTabsGUI                         $tabs
	 * @param ilTemplate                        $template
	 * @param ilCtrl                            $controlFlow
	 * @param ilLearnplacesPlugin               $plugin
	 * @param RenderableBlockViewFactory        $renderableFactory
	 * @param LearnplaceService                 $learnplaceService
	 * @param AccordionBlockService             $accordionService
	 * @param LearnplaceServiceDecoratorFactory $learnplaceServiceDecorationFactory
	 * @param BlockAddFormGUI                   $blockAddGUI
	 * @param ServerRequestInterface            $request
	 * @param AccessGuard                       $accessGuard
	 */
	public function __construct(ilTabsGUI $tabs, ilTemplate $template, ilCtrl $controlFlow, ilLearnplacesPlugin $plugin, RenderableBlockViewFactory $renderableFactory, LearnplaceService $learnplaceService, AccordionBlockService $accordionService, LearnplaceServiceDecoratorFactory $learnplaceServiceDecorationFactory, BlockAddFormGUI $blockAddGUI, ServerRequestInterface $request, AccessGuard $accessGuard) {
		$this->tabs = $tabs;
		$this->template = $template;
		$this->controlFlow = $controlFlow;
		$this->plugin = $plugin;
		$this->renderableFactory = $renderableFactory;
		$this->learnplaceService = $learnplaceService;
		$this->accordionService = $accordionService;
		$this->learnplaceServiceDecorationFactory = $learnplaceServiceDecorationFactory;
		$this->blockAddGUI = $blockAddGUI;
		$this->request = $request;
		$this->accessGuard = $accessGuard;
	}


	public function executeCommand() {

		$this->template->getStandardTemplate();
		$cmd = $this->controlFlow->getCmd(CommonControllerAction::CMD_INDEX);
		$this->tabs->activateTab(self::TAB_ID);

		switch ($cmd) {
			case CommonControllerAction::CMD_INDEX:
				if ($this->accessGuard->hasReadPermission()) {
					$this->index();
					$this->template->show();
					return true;
				}
				break;
			case CommonControllerAction::CMD_ADD:
			case CommonControllerAction::CMD_CANCEL:
			case CommonControllerAction::CMD_CONFIRM:
			case CommonControllerAction::CMD_CREATE:
			case CommonControllerAction::CMD_DELETE:
			case CommonControllerAction::CMD_EDIT:
			case CommonControllerAction::CMD_UPDATE:
			case self::CMD_SEQUENCE:
				if ($this->accessGuard->hasWritePermission()) {
					$this->{$cmd}();
					$this->template->show();
					return true;
				}
				break;
		}

		ilUtil::sendFailure($this->plugin->txt('common_access_denied'), true);
		$this->controlFlow->redirectByClass(ilRepositoryGUI::class);

		return false;
	}

	//actions
	private function index() {

		$toolbar = new ilToolbarGUI();
		$saveSequenceButton = ilSubmitButton::getInstance();
		$saveSequenceButton->setCommand(self::CMD_SEQUENCE);
		$saveSequenceButton->setCaption($this->plugin->txt('content_save_sequence'), false);
		$toolbar->addStickyItem($saveSequenceButton);

		$writePermission = $this->accessGuard->hasWritePermission();
		$template = new ilTemplate('./Customizing/global/plugins/Services/Repository/RepositoryObject/Learnplaces/templates/default/tpl.block_list.html', true, true);

		//decorate the learnplace only if the user has no write rights
		$learnplaceService = ($writePermission) ? $this->learnplaceService : $this->learnplaceServiceDecorationFactory->decorate($this->learnplaceService);

		$learnplace = $learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		/**
		 * @var ContentPresentationView $view
		 */
		$view = PluginContainer::resolve(ContentPresentationView::class);
		$view->setBlocks($learnplace->getBlocks());
		$view->setReadonly(!$writePermission);

		if($writePermission) {
			$template->setVariable('FORM_ACTION', $this->controlFlow->getFormAction($this, self::CMD_SEQUENCE));
			$template->setVariable('TOOLBAR', $toolbar->getHTML());
		}

		$template->setVariable('CONTENT', $view->getHTML());

		$this->template->setContent($template->get());
	}

	private function add() {
		$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		foreach ($learnplace->getBlocks() as $block) {
			if($block instanceof MapBlockModel) {
				$this->blockAddGUI->setMapEnabled(false);
				break;
			}
		}

		$this->blockAddGUI->setAccordionEnabled($this->getCurrentAccordionId($this->request->getQueryParams()) === 0);

		$this->template->setContent($this->blockAddGUI->getHTML());
	}

	private function create() {
		$blockAdd = $this->blockAddGUI;
		if($blockAdd->checkInput()) {
			$input = intval($blockAdd->getInput(BlockAddFormGUI::POST_BLOCK_TYPES, true));
			$controller = static::$blockTypeViewMapping[$input];
			$this->controlFlow->saveParameterByClass($controller, PlusView::POSITION_QUERY_PARAM);
			$this->controlFlow->saveParameterByClass($controller, PlusView::ACCORDION_QUERY_PARAM);

			//dispatch to controller which knows how to handle that block
			$this->controlFlow->redirectByClass($controller, CommonControllerAction::CMD_ADD);
			return;
		}

		ilUtil::sendFailure($this->plugin->txt('message_create_failure'), true);
		$this->controlFlow->redirect($this, CommonControllerAction::CMD_INDEX);
	}

	private function cancel() {
		$this->controlFlow->redirect($this, CommonControllerAction::CMD_INDEX);
	}

	private function sequence() {
		$learnplace = $this->learnplaceService->findByObjectId(ilObject::_lookupObjectId($this->getCurrentRefId()));
		$blockIterator = new AppendIterator();

		foreach ($learnplace->getBlocks() as $block) {
			if($block instanceof AccordionBlockModel)
				$blockIterator->append(new ArrayIterator($block->getBlocks()));
		}

		$blockIterator->append(new ArrayIterator($learnplace->getBlocks()));

		$post = $this->request->getParsedBody();

		//yield ['block_12' => '5']
		$iterator = new RegexIterator(new ArrayIterator($post),  '/^(?:block\_\d+)$/',RegexIterator::MATCH, RegexIterator::USE_KEY);

		//yield [12 => 5]
		$mappedBlockGenerator = function (Iterator $iterator) {
			foreach ($iterator as $key => $entry) {
				$id = intval(str_replace('block_', '', $key));
				yield $id => intval($entry);
			}
			return;
		};


		$mappedBlocks = $mappedBlockGenerator($iterator);


		//set the new sequence numbers
		foreach ($mappedBlocks as $id => $sequence) {
			foreach ($blockIterator as $block) {
				if($block->getId() === $id) {
					$block->setSequence($sequence);

					//sort accordion blocks
					if($block instanceof AccordionBlockModel) {
						$block->setBlocks($this->sortBlocksBySequence($block->getBlocks()));
					}

					break;
				}
			}
		}

		$blocks = $learnplace->getBlocks();
		$learnplace->setBlocks($this->sortBlocksBySequence($blocks));

		//store new sequence
		$this->learnplaceService->store($learnplace);

		$this->controlFlow->redirect($this, CommonControllerAction::CMD_INDEX);
	}

	private function sortBlocksBySequence(array $blocks): array {
		usort($blocks, function(BlockModel $a, BlockModel $b) { return $a->getSequence() >= $b->getSequence() ? 1 : -1;});
		return $blocks;
	}
}