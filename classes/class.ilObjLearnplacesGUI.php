<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilObjLearnLoc2GUI
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 *
 * @ilCtrl_isCalledBy ilObjLiveVotingGUI: ilRepositoryGUI, ilObjPluginDispatchGUI, ilAdministrationGUI
 * @ilCtrl_Calls      ilObjLiveVotingGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI
 */
class ilObjLearnLoc2GUI extends ilObjectPluginGUI
{


    /**
     * @inheritDoc
     */
    function executeCommand()
    {
        throw new Exception("Not Implemented yet.");
    }

    /**
     * @inheritDoc
     */
    function getType()
    {
        return ilLearnLoc2Plugin::PLUGIN_ID;
    }

    /**
     * This command will be executed after a new repository object was created.
     * @return string
     */
    function getAfterCreationCmd()
    {
        throw new Exception("Not Implemented yet.");
    }

    /**
     * This command will be executed if no command was supplied.
     * @return string
     */
    function getStandardCmd()
    {
        throw new Exception("Not Implemented yet.");
    }


}