<?php
/**
 * IDEALIAGroup srl
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@idealiagroup.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this module to newer
 * versions in the future.
 *
 * @category   IG
 * @package    IG_LightBox
 * @copyright  Copyright (c) 2010-2011 IDEALIAGroup srl (http://www.idealiagroup.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Riccardo Tempesta <tempesta@idealiagroup.com>
*/
 
class Dylan_Repairdevice_IndexController extends Mage_Core_Controller_Front_Action
{

	 public function indexAction(){
		$this->loadLayout();
		$headBlock = $this->getLayout()->getBlock('head');
        if ($headBlock) {
            $headBlock->setTitle(Mage::helper('repairdevice')->__('Repair-device'));
        }
    	$this->renderLayout();
	 }
	 
	 
	    public function categoryAction(){
			 
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
	
	
	public function saveAction(){
		//var_dump(__METHOD__);
		if($data = $this->getRequest()->getPost()){
			if (!$this->_validateFormKey()) {
	            $this->_redirect('*/*/');
	            return;
	        }			
			$id = $this->getRequest()->getParam('id');
            $model = Mage::getModel('repairdevice/repairdevice')->load($id);
          
				
			//$data['status'] = 1;
			$data['create_at'] = date('Y-m-d H:m:s');

				$model->setData($data);
			try {
                	
                $model->save();
                Mage::getSingleton('core/session')->
                addSuccess(Mage::helper('repairdevice')
                ->__('Your information was submitted successfully.'));
                
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
              Mage::getSingleton('core/session')->addError($e->getMessage());
              return;
            }

		}
		$this->_redirect('*/*/');	

	}
}
