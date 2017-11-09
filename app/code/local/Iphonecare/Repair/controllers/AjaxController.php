<?php
/**
 * Index Controller
 *
 */
class Iphonecare_Repair_AjaxController extends Mage_Core_Controller_Front_Action
{
    protected function _getCart()
    {
        return Mage::getSingleton('checkout/cart');
    }
    
    /**
     * Index Action
     */
    public function categoryAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
      
        $categoryModel = Mage::getModel('catalog/category')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($id);           
           
        $respone = array();
        
        foreach ($categoryModel->getChildrenCategories() as $categoryId) {
            $category = $categoryModel->load($categoryId->getId());
            array_push($respone, array( "name" => $category->getName(), "id" => $category->getId(), "image" => $category->getImageUrl()));
        }      
            
        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'application/json')->setBody(Mage::helper('core')->jsonEncode($respone));
    }
    
    public function productAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $taxHelper = Mage::helper('tax');
        $store = Mage::app()->getStore();
      
        $categoryModel = Mage::getModel('catalog/category')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($id);           
           
        $respone = array();
        
        foreach ($categoryModel->getProductCollection() as $productId) {
            $product = Mage::getModel('catalog/product')->load($productId->getId());
           
//            $price = (float)round($taxHelper->getPrice($product,$product->getPrice(),$taxHelper->displayPriceIncludingTax()));
            $price = Mage::helper('core')->currency($taxHelper->getPrice($product,$product->getPrice(),$taxHelper->displayPriceIncludingTax()), true, false);
            array_push($respone, array( "name" => $product->getName(), "price" =>$price , "id" => $product->getId(), "image" => $product->getImageUrl()));
        }      
            
        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'application/json')->setBody(Mage::helper('core')->jsonEncode($respone));
    }
    
       
    public function saveAction()
    {   
        $request = $this->getRequest();  
        $repairs = $request->getParam("repairs");

        try {
            $cart = Mage::getSingleton('checkout/cart');

            $cart->addProductsByIds($repairs);
            $quote = $cart->getQuote();

//            $quote->setRepairImei($request->getParam("imei"));
//            $quote->setRepairProblem($request->getParam("problem"));
//            $quote->setRepairPincode($request->getParam("pincode"));
//            $quote->setRepairScreencode($request->getParam("screencode"));
//            $quote->setRepairExtracodes($request->getParam("extracodes"));
            $quote->setRepairIsrepair(1);

            $store = Mage::getModel('iphonecarerepair/stores');
            if ($request->getParam('shipping') == 'iphonecarerepair_store') {
                $store->load((int)$request->getParam('store'));
            } else {
                $store = $store->getCollection()
                    ->addFieldToSelect('*')
                    ->addFieldToFilter('store_type', 0)
                    ->addFieldToFilter('store_status', 1)
                    ->setPageSize(1)
                    ->getFirstItem();
            }

            $shippingAddress = $quote->getShippingAddress();
            $shippingAddress
                ->setCountryId($store->getCountryCode())
                ->setRegionId($store->getRegionId())
                ->setPostcode($store->getPostcodeCode())
                ->setCity($store->getCity())
                ->setStreet($store->getAddress())
                ->setShippingMethod($request->getParam("shipping"))
                ->setCollectShippingRates(true)
            ;

            $cart->save();

            $response = array("result" => true);
            Mage::getSingleton('customer/session')->addSuccess($this->__('Products have been successfully added'));
        } catch (Exception $e) {
            $response = array("result" => false);
        }

        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'application/json')->setBody(Mage::helper('core')->jsonEncode($response));
        return;
    }
}