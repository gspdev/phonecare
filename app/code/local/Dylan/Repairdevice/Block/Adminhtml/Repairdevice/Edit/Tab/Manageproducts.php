<?php
class Dylan_Repairdevice_Block_Adminhtml_Repairdevice_Edit_Tab_Manageproducts extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('manageproductsGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
       $this->setUseAjax(true);
    }
	
	 protected function _addProductAttributesAndPrices(Mage_Catalog_Model_Resource_Product_Collection $collection)
    {
        return $collection
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
            ->addUrlRewrite();
    }

    protected function _prepareCollection()
    {
		
       // $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
		    ->addAttributeToSelect('required_options')
           // ->setPositionOrder()
            ->addStoreFilter()
            //->addAttributeToSelect('sku')
           // ->addAttributeToSelect('name')
            //->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('*');

        // Add our custom attributes
        // $collection->addAttributeToSelect('color')
                // ->addAttributeToSelect('manufacturer');

        // if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            // $collection->joinField('qty',
                // 'cataloginventory/stock_item',
                // 'qty',
                // 'product_id=entity_id',
                // '{{table}}.stock_id=1',
                // 'left');
        // }
        // if ($store->getId()) {

            // $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            // $collection->addStoreFilter($store);
            // $collection->joinAttribute('name', 'catalog_product/name', 'entity_id', null, 'inner', $adminStore);
            // $collection->joinAttribute('custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $store->getId());
            // $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner', $store->getId());
            // $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner', $store->getId());
            // $collection->joinAttribute('price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId());
        // }
        // else {
            // $collection->addAttributeToSelect('price');
            // $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            // $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        // }
	  // if (Mage::helper('catalog')->isModuleEnabled('Mage_Checkout')) {
            // Mage::getResourceSingleton('checkout/cart')->addExcludeProductFilter($collection,
                // Mage::getSingleton('checkout/session')->getQuoteId()
            // );
            // $this->_addProductAttributesAndPrices($collection);
        // }
// //        Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($this->_itemCollection);
        // Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);

        // $collection->load();

        // foreach ($collection as $product) {
            // $product->setDoNotUseCategoryId(true);
        //}	
		//print_r($collection);exit;
        $this->setCollection($collection);
        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

	 protected function _getProduct()
    {
        return Mage::getModel('catalog/product');
    }
	
	 public function isReadonly()
    {
        return $this->_getProduct()->getReadonly();
    }

    protected function _prepareColumns()
    {
        if (!$this->isReadonly()) {
            $this->addColumn('in_products', array(
                'header_css_class'  => 'a-center',
                'type'              => 'checkbox',
                'name'              => 'in_products',
               // 'values'            => $this->_getSelectedProducts(),
                'align'             => 'center',
                'index'             => 'entity_id'
            ));
        }

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id',
			'type'  => 'number',
        ));
		
		$this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => 100,
            'index'     => 'sku'
        ));

        $this->addColumn('price', array(
            'header'        => Mage::helper('catalog')->__('Price'),
            'type'          => 'currency',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'         => 'price'
        ));


        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));

        $this->addColumn('type', array(
            'header'    => Mage::helper('catalog')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name', array(
            'header'    => Mage::helper('catalog')->__('Attrib. Set Name'),
            'width'     => 130,
            'index'     => 'attribute_set_id',
            'type'      => 'options',
            'options'   => $sets,
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('catalog')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('visibility', array(
            'header'    => Mage::helper('catalog')->__('Visibility'),
            'width'     => 90,
            'index'     => 'visibility',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));

      
        // $this->addColumn('position', array(
            // 'header'            => Mage::helper('catalog')->__('Position'),
            // 'name'              => 'position',
            // 'type'              => 'number',
            // 'validate_class'    => 'validate-number',
            // 'index'             => 'position',
            // 'width'             => 60,
            // 'editable'          => !$this->_getProduct()->getRelatedReadonly(),
            // 'edit_only'         => !$this->_getProduct()->getId()
        // ));

        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    // public function getGridUrl()
    // {
        // return $this->getData('grid_url')
            // ? $this->getData('grid_url')
            // : $this->getUrl('*/*/relatedGrid', array('_current' => true));
    // }

    /**
     * Retrieve selected related products
     *
     * @return array
     */
    protected function _getSelectedProducts()
    {
        $products = $this->getProductsRelated();
        if (!is_array($products)) {
            $products = array_keys($this->getSelectedRelatedProducts());
        }
        return $products;
    }

    /**
     * Retrieve related products
     *
     * @return array
     */
    public function getSelectedRelatedProducts()
    {
        $products = array();
        foreach (Mage::getModel('catalog/product')->getCollection() as $product) {
            $products[$product->getId()] = array('position' => $product->getPosition());
        }
        return $products;
    }
}