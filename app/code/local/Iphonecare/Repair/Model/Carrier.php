<?php
class Iphonecare_Repair_Model_Carrier
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{
    protected $_code = 'iphonecarerepair';

    public function collectRates(
        Mage_Shipping_Model_Rate_Request $request
    )
    {
        $result = Mage::getModel('shipping/rate_result');
        /* @var $result Mage_Shipping_Model_Rate_Result */

        $items = Mage::getSingleton('checkout/session')->getQuote()->getAllVisibleItems();
        $isShow = true;
        foreach ($items as $item) {
            if ($item->getIsRepair() != 1) {
                $isShow = false;
            }
        }

        if ($isShow) {
            $result->append($this->_getStoreShippingRate());
            $result->append($this->_getPostShippingRate());
        }

        return $result;
    }

    protected function _getPostShippingRate()
    {
        $rate = Mage::getModel('shipping/rate_result_method');
        /* @var $rate Mage_Shipping_Model_Rate_Result_Method */

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));

        $rate->setMethod('post');
        $rate->setMethodTitle(Mage::helper('core')->__('Send in the mail'));

        $rate->setPrice('0.00');
        $rate->setCost('0.00');

        return $rate;
    }

    protected function _getStoreShippingRate()
    {
        $rate = Mage::getModel('shipping/rate_result_method');
        /* @var $rate Mage_Shipping_Model_Rate_Result_Method */

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));

        $rate->setMethod('store');
        $rate->setMethodTitle(Mage::helper('core')->__('Shipping to the store'));

        $rate->setPrice('0.00');
        $rate->setCost('0.00');

        return $rate;
    }

    public function getAllowedMethods()
    {
        return array(
            'post' => $this->__('Send in the mail'),
            'store' => $this->__('Shipping to the store'),
        );
    }

    public function isTrackingAvailable()
    {
        return true;
    }
}
