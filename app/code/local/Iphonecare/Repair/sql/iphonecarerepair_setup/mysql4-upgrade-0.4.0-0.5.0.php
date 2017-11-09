<?php
$installer = $this;

$installer->startSetup();

$options =  array('type' => 'varchar', 'required' => false);

$installer->addAttribute('quote_item', 'product_hash', $options);

$installer->endSetup();
