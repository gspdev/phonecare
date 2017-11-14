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
 
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
  public function __construct()
    {
        parent::__construct();
                  
        $this->_objectId   = 'id';
        $this->_blockGroup = 'repairdevice';
        $this->_controller = 'adminhtml_repairdevice';
         
        $this->_updateButton('save', 'label', Mage::helper('repairdevice')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('repairdevice')->__('Delete Item'));
         
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
 
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('detailed') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'detailed');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'detailed');
                }
            }
 
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('repairdevice_data') && Mage::registry('repairdevice_data')->getRepairdeviceId() ) {
            return Mage::helper('repairdevice')->__("Edit Item '%s'", 
                       $this->htmlEscape(Mage::registry('repairdevice_data')->getOrderId())
                   );
        } else {
            return Mage::helper('repairdevice')->__('Add Item');
        }
    }
}