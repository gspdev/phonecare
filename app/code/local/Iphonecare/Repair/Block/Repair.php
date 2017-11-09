<?php
/**
 * Block template
 *
 */
class Iphonecare_Repair_Block_Repair extends Mage_Core_Block_Template
{
    public function getActiveStoreList()
    {
        $stores = Mage::getModel('iphonecarerepair/stores')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('store_type', 1)
            ->addFieldToFilter('store_status', 1);
                
        return $stores;
    }
}
