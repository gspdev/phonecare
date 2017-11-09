<?php

class Iphonecare_Repair_Block_Onepage_Success
    extends Mage_Checkout_Block_Onepage_Success
{
    public function getOrders()
    {
        $orders = (array) json_decode(Mage::getSingleton('checkout/session')->getRepairOrders());
        Mage::getSingleton('checkout/session')->unsRepairOrders();

        return $orders;
    }
}
