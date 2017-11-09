<?php

class Iphonecare_Repair_Model_Resource_Stores extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('iphonecarerepair/stores', 'entity_id');
    }
}
