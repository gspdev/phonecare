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
 
class Dylan_Repairdevice_Block_Repairdevice extends Mage_Core_Block_Template
{
	protected $_repairdevice;
	protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->_repairdevice = Mage::getModel('repairdevice/repairdevice');
        if ($id = $this->getRequest()->getParam('repairdevice_id')) {
            $this->_repairdevice->load($id);
        }
    }
	public function getRepairdevice(){
		return $this->_repairdevice;
	}
	
	
	// public function getShippingMethod(){
		// if($this->getRepairdevice()->getShippingMethod()==1){
			// return Mage::helper('repairdevice')->__('Open');
		// }else{
			// return Mage::helper('repairdevice')->__('Close');
		// }
	// }
	
	public function getBackUrl(){
		return $this->getUrl('repairdevice/index/',array('_secure'=>true));
	}
	
	public function getCustomerId(){
		
		return Mage::getSingleton('customer/session')->getId();
	}
	
	public function getTitle()
    {
        if ($title = $this->getData('title')) {
            return $title;
        }
        if ($this->getRepairdevice()->getRepairdeviceId()) {
            $title = Mage::helper('repairdevice')->__('View Repairdevice');
        }
        else {
            $title = Mage::helper('repairdevice')->__('Add New Repairdevice');
        }
        return $title;
    }
	
}