<?php

class Iphonecare_Repair_Model_Resource_Stores_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('iphonecarerepair/stores');
    }
}
