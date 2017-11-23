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
	
    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }	
	 
	public function categoryAction(){
			 
        $id = (int)$this->getRequest()->getParam('id');
      
        $categoryModel = Mage::getModel('catalog/category')
                    ->setStoreId(Mage::app()->getStore()->getId())
                    ->load($id);           
           
        $respone = array();
        
        foreach ($categoryModel->getChildrenCategories() as $categoryId) {
            $category = $categoryModel->load($categoryId->getId());
			$categoryData = Mage::getModel('catalog/category')->load($category->getId());
			  array_push($respone, array( "name" => $categoryData->getName(), "id" => $categoryData->getId(), "image" => $categoryData->getImageUrl()));
           
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
	
	 public function saveLoginAction()
    {
      
      if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*/');	
            return;
        }
        $this->_initLayoutMessages('customer/session');
        $session = $this->_getSession();
        if ($this->getRequest()->isPost())
        {
            $login = $this->getRequest()->getPost('login');
            if (!empty($login['username']) && !empty($login['password']))
            {  
		      
		       $customer = Mage::getModel('customer/customer')
			  ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
			   ->loadByEmail($login['username']);
			    $in_id = $customer->getId();
				$data['customer_id'] = $in_id;
				$data['create_at'] = date('Y-m-d');
			    $id = $this->getRequest()->getParam('id');
				$model = Mage::getModel('repairdevice/repairdevice')->load($id);
                //$data['create_at'] = date('Y-m-d H:m:s');

				//$model->setData($data);
					 // $model->addData($data)->setId($this->getRequest()->getParam('repairdevice_id'));
                    try {
						
						//$model->save();
						//print_r($model->save()->getId());exit;
                        $session->login($login['username'], $login['password']);
                        if ($session->getCustomer()->getIsJustConfirmed()) {
                            $this->_welcomeCustomer($session->getCustomer(), true);
                        }

                     }catch (Mage_Core_Exception $e) {
                        switch ($e->getCode()) {
                            case Mage_Customer_Model_Customer::EXCEPTION_EMAIL_NOT_CONFIRMED://1
                                $value = $this->_getHelper('customer')->getEmailConfirmationUrl($login['username']);
                                $message = $this->_getHelper('customer')->__('This account is not confirmed. <a href="%s">Click here</a> to resend confirmation email.', $value);
                                break;
                            case Mage_Customer_Model_Customer::EXCEPTION_INVALID_EMAIL_OR_PASSWORD://2
                                $message = $e->getMessage();
                                break;
                            default:
                                $message = $e->getMessage();
                        }
                        $session->addError($message);
                        $session->setUsername($login['username']);
                    } catch (Exception $e) {
                        Mage::logException($e); // PA DSS violation: this exception log can disclose customer password
                    }

			
            }
			
			  
        }
	     $this->_redirect('*/*/');
           
		
    }
	
	public function saveAction(){
		
		$status = Mage::getSingleton('customer/session')->isLoggedIn();
		if($status){
			//var_dump(__METHOD__);
			if($data = $this->getRequest()->getPost()){
				if (!$this->_validateFormKey()) {
					$this->_redirect('*/*/');
					return;
				}

				//print_r($data);exit;			
				$id = $this->getRequest()->getParam('id');
				$model = Mage::getModel('repairdevice/repairdevice')->load($id);
				//$productId = $data['repairs']; 
				
			  
					
				//$data['status'] = 1;
				$data['create_at'] = date('Y-m-d H:m:s');

					$model->setData($data);
				try {
						
					$model->save();
					$productIdArray = $this->getRequest()->getPost('repairs');
					foreach($productIdArray as $productId){
						
						$resource = Mage::getSingleton('core/resource');
						$inster = Mage::getSingleton('core/resource')->getConnection('core_write');
						$tablePrefix = (string) Mage::getConfig()->getTablePrefix();
						$tableName = $resource->getTableName('repair_product');
						$sql_inster = "INSERT INTO ".$tableName." (repair_id,product_id)VALUES('".$model->save()->getId()."','$productId')";
						$inster->query($sql_inster);  
					}
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
		}
		
		$this->_redirect('*/*/');	

	}
}
