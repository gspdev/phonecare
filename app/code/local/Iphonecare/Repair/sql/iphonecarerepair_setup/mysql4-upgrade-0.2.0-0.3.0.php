<?php
$installer = $this;

$installer->startSetup();

$options =  array('type' => 'varchar', 'required' => false);

$installer->addAttribute('quote_item', 'repair_shipping', $options);
$installer->addAttribute('quote_item', 'repair_store', $options);

$installer->addAttribute('order_item', 'repair_shipping', $options);
$installer->addAttribute('order_item', 'repair_store', $options);

$installer->endSetup();
