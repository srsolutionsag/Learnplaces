<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilObjLearnLoc2ListGUI
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilObjLearnLoc2ListGUI extends ilObjectPluginListGUI
{
    function getGuiClass()
    {
        return ilObjLearnLoc2GUI::class;
    }

    function initCommands()
    {
        return [];
    }

    function initType()
    {
        $this->setType(ilLearnLoc2Plugin::PLUGIN_ID);
    }

}