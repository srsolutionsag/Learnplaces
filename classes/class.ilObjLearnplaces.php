<?php
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Class ilObjLearnLoc2
 *
 * @author  Nicolas Schäfli <ns@studer-raimann.ch>
 */
class ilObjLearnplaces extends ilObjectPlugin
{


    /**
     * ilObjLearnLoc2 constructor.
     *
     * @param int $refId    The reference id of the current object.
     */
    public function __construct($refId = 0)
    {
        parent::__construct($refId);
    }

    protected function initType()
    {
        $this->setType(ilLearnplacesPlugin::PLUGIN_ID);
    }

    protected function doCreate()
    {
        throw new Exception("Not Implemented yet.");
    }

    protected function doRead()
    {
        throw new Exception("Not Implemented yet.");
    }

    protected function doUpdate()
    {
        throw new Exception("Not Implemented yet.");
    }

    protected function doDelete()
    {
        throw new Exception("Not Implemented yet.");
    }

    protected function doCloneObject($new_obj, $a_target_id, $a_copy_id = null)
    {
        throw new Exception("Not Implemented yet.");
    }


}