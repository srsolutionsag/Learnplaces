<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilLearnLoc2Plugin
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilLearnLoc2Plugin extends ilRepositoryObjectPlugin
{
    const PLUGIN_NAME = "LearnLoc2";
    const PLUGIN_ID = "xle2";

    public function getPluginName()
    {
        return self::PLUGIN_NAME;
    }

    protected function uninstallCustom()
    {
        // TODO: what do we need to do here?
    }


}