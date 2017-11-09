<?php
/**
 * Model template
 *
 */
class Iphonecare_Repair_Model_Observer extends Mage_Core_Model_Abstract
{
	function appendCustomColumn(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        if (!isset($block)) {
            return $this;
        }
 
        if ($block->getType() == 'adminhtml/sales_order_grid') {
            /* @var $block Mage_Adminhtml_Block_Customer_Grid */
            $block->addColumn('repair_isrepair', array(
                'header'    => 'Reparation',
                'type'    => 'options',
                'options' => array('1' => 'Ja', '0' => 'Nej'),
                'index'     => 'repair_isrepair',
                'width'     => '50px'
            ));
        }
	}

    public function getSalesOrderViewInfo(Varien_Event_Observer $observer)
    {
        $block = $observer->getBlock();
        if (($block->getNameInLayout() == 'order_items') 
            && ($child = $block->getChild('iphonecare.repair.info'))) {
            $transport = $observer->getTransport();
            if ($transport) {
                $html = $transport->getHtml();
                $html .= $child->toHtml();
                $transport->setHtml($html);
            }
        }
    }

    public function addProductToQuote(Varien_Event_Observer $observer)
    {
        $request = Mage::app()->getRequest();
        $item = $observer->getEvent()->getQuoteItem();
        $item->setRepairImei($request->getParam('imei'));
        $item->setRepairProblem($request->getParam('problem'));
        $item->setRepairScreencode($request->getParam('screencode'));
        $item->setRepairShipping($request->getParam('shipping'));
        $item->setRepairStore($request->getParam('store'));
        $item->setProductHash($request->getParam('product_hash'));

        $setIsRepair = (int)$item->getProduct()->getIsRepair();
        if (isset($setIsRepair)) {
            $item->setIsRepair($setIsRepair);
        }

        return $this;
    }

    public function addOrderToSession(Varien_Event_Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $allOrders = (array) json_decode(Mage::getSingleton('checkout/session')->getRepairOrders());

        $allOrders[$order->getIncrementId()]
            = Mage::getUrl('sales/order/view/', array('order_id' => $order->getId()));

        Mage::getSingleton('checkout/session')->setRepairOrders(json_encode($allOrders));
    }
}
