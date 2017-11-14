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
 
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
 public function __construct()
  {
      parent::__construct();
      $this->setId('webGrid');
      $this->setDefaultSort('repairdevice_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }
 
  protected function _prepareCollection()
  {
      $collection = Mage::getModel('repairdevice/repairdevice')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }
 
  protected function _prepareColumns()
  {
      $this->addColumn('repairdevice_id', array(
          'header'    =>  Mage::helper('repairdevice')->__('ID'),
          'align'     =>  'right',
          'width'     =>  '50px',
          'index'     =>  'repairdevice_id',
      ));
	  
	 $this->addColumn('product_id', array(
          'header'    =>  Mage::helper('repairdevice')->__('Product Name:'),
          'align'     =>  'left',
          'width'     =>  '100px',
          'index'     =>  'product_id',
      ));
 
      $this->addColumn('imei', array(
          'header'    =>  Mage::helper('repairdevice')->__('Serie/IMEI-nummer:'),
          'align'     =>  'left',
          'width'     =>  '100px',
          'index'     =>  'imei',
      ));
	  
	  $this->addColumn('screencode', array(
          'header'    =>  Mage::helper('repairdevice')->__('Skärmlås:'),
          'align'     =>  'left',
          'width'     =>  '100px',
          'index'     =>  'screencode',
      ));
 

      $this->addColumn('detailed', array(
          'header'    =>  Mage::helper('repairdevice')->__('Beskriv problemet:'),
          'width'     =>  '150px',
          'index'     =>  'detailed',
      ));
	  
      $this->addColumn('shipping_method', array(
          'header'    =>  Mage::helper('repairdevice')->__('Shipping Method'),
          'align'     =>  'left',
          'width'     =>  '80px',
          'index'     =>  'shipping_method',
          'type'      =>  'options',
          'options'   =>  array(
                             1 => '1',
                             2 => '2',
          ),
      ));
	  
	  // $this->addColumn('administrator_id', array(
          // 'header'    =>  Mage::helper('refund')->__('admin Id'),
          // 'width'     =>  '100px',
          // 'index'     =>  'administrator_id',
      // ));
       
	$this->addColumn('action', array(
          'header'    =>  Mage::helper('repairdevice')->__('Action'),
          'width'     =>  '100',
          'type'      =>  'action',
          'getter'    =>  'getId',
          'actions'   =>  array(
                             array(
                                'caption'   =>  Mage::helper('repairdevice')->__('Edit'),
                                'url'       =>  array('base'=> '*/*/edit'),
                                'field'     =>  'id'
                             )
          ),
          'filter'    =>  false,
          'sortable'  =>  false,
          'index'     =>  'stores',
          'is_system' =>  true,
      ));
       
      return parent::_prepareColumns();
  }
 
 
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }
}