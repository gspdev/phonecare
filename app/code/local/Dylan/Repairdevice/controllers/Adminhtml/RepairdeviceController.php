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
 
class  Dylan_Repairdevice_Adminhtml_RepairdeviceController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu('repairdevice/repairdevice')
                           ->_addBreadcrumb(
                      Mage::helper('adminhtml')->__('Repairdevice Manager'),            
                      Mage::helper('adminhtml')->__('Repairdevice Manager')
                         );
        return $this;
    }
	public function indexAction()
    {
        $this->_initAction()->renderLayout();
    }
	
	public function newAction()
    {
        $this->_forward('edit');
    }
	
	 public function editAction()
    {
        $id    = $this->getRequest()->getParam('id');
        $model = Mage::getModel('repairdevice/repairdevice')->load($id);
        if ($model->getRepairdeviceId() || $id == 0) {
           $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
           if (!empty($data)) {
               $model->setData($data);
           }
           Mage::register('repairdevice_data', $model);
           $this->loadLayout();
           $this->_setActiveMenu('repairdevice/repairdevice');
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice Manager'),         
                          Mage::helper('adminhtml')->__('Repairdevice Manager')
           );
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice News'),    
                          Mage::helper('adminhtml')->__('Repairdevice News')
           );
           $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           $this->_addContent(
           		$this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit')
		   )->_addLeft(
		   		$this->getLayout()->createBlock('repairdevice/adminhtml_repairdevice_edit_tabs')
		   );
           $this->renderLayout();
        } else {
           Mage::getSingleton('adminhtml/session')->addError(
                          Mage::helper('repairdevice')->__('Item does not exist')
           );
           $this->_redirect('*/*/');
        }
    }
	
	 public function newInvoiceAction()
    {
         $id    = $this->getRequest()->getParam('id');
		 
		// $data = $this->getRequest()->getPost();
		// print_r($data);exit;
		 
        $model = Mage::getModel('repairdevice/repairdevice')->load($id);
        if ($model->getRepairdeviceId() || $id == 0) {
           $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		  // print_r($model);exit;
           if (!empty($data)) {
               $model->setData($data);
           }
           Mage::register('repairdevice_data', $model);
           $this->loadLayout();
           $this->_setActiveMenu('repairdevice/repairdevice');
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice Manager'),         
                          Mage::helper('adminhtml')->__('Repairdevice Manager')
           );
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice News'),    
                          Mage::helper('adminhtml')->__('Repairdevice News')
           );
           $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           $this->_addContent(
           		$this->getLayout()->createBlock('repairdevice/adminhtml_invoice')
		   )->_addLeft(
		   		$this->getLayout()->createBlock('repairdevice/adminhtml_invoice')
		   );
           $this->renderLayout();
        } else {
           Mage::getSingleton('adminhtml/session')->addError(
                          Mage::helper('repairdevice')->__('Item does not exist')
           );
           $this->_redirect('*/*/');
        }
    }
	
	public function saveInvoiceAction()
    {
         $id    = $this->getRequest()->getParam('id');
		 
		 $data = $this->getRequest()->getPost();
		 print_r($data);exit;
		 
        $model = Mage::getModel('repairdevice/repairdevice')->load($id);
		print_r($model);exit;
        if ($model->getRepairdeviceId() || $id == 0) {
           $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
		   print_r($model);exit;
           if (!empty($data)) {
               $model->setData($data);
           }
           Mage::register('repairdevice_data', $model);
           $this->loadLayout();
           $this->_setActiveMenu('repairdevice/repairdevice');
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice Manager'),         
                          Mage::helper('adminhtml')->__('Repairdevice Manager')
           );
           $this->_addBreadcrumb(
                          Mage::helper('adminhtml')->__('Repairdevice News'),    
                          Mage::helper('adminhtml')->__('Repairdevice News')
           );
           $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           $this->_addContent(
           		$this->getLayout()->createBlock('repairdevice/adminhtml_invoice')
		   )->_addLeft(
		   		$this->getLayout()->createBlock('repairdevice/adminhtml_invoice')
		   );
           $this->renderLayout();
        } else {
           Mage::getSingleton('adminhtml/session')->addError(
                          Mage::helper('repairdevice')->__('Item does not exist')
           );
           $this->_redirect('*/*/');
        }
    }

	
	public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {
        	//print_r($data);exit;
            $model = Mage::getModel('repairdevice/repairdevice');

            $model->setData($data)->setRepairdeviceId($this->getRequest()->getParam('id')
            );
           try {
                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('repairdevice')->__('Item was successfully saved')
                );
                Mage::getSingleton('adminhtml/session')->setFormData(false);
 
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getRepairdeviceId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', 
                                 array('id' => $this->getRequest()->getParam('id'))
                );
                return;
           }
        }
        Mage::getSingleton('adminhtml/session')->addError(
                  Mage::helper('repairdevice')->__('Unable to find item to save')
        );
        $this->_redirect('*/*/');
    }
	
	 public function deleteAction() 
	{
	        if( $this->getRequest()->getParam('id') > 0 ) {
	            try {
	                $model = Mage::getModel('repairdevice/repairdevice');
	                $model->setRepairdeviceId($this->getRequest()->getParam('id'))
	                      ->delete();
	                Mage::getSingleton('adminhtml/session')->addSuccess(
	                        Mage::helper('adminhtml')->__('Item was successfully deleted')
	                );
	                $this->_redirect('*/*/');
	            } catch (Exception $e) {
	                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
	                $this->_redirect('*/*/edit', 
	                                 array('id' => $this->getRequest()->getParam('id'))
	                );
	            }
	        }
	        $this->_redirect('*/*/');
	}
	


	
}
