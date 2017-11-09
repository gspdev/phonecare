<?php
$installer = $this;

$installer->startSetup();

$options =  array('type' => 'varchar', 'required' => false);

$installer->addAttribute('quote_item', 'repair_imei', $options);
$installer->addAttribute('quote_item', 'repair_problem', $options);
$installer->addAttribute('quote_item', 'repair_screencode',$options);

$installer->addAttribute('order_item', 'repair_imei', $options);
$installer->addAttribute('order_item', 'repair_problem', $options);
$installer->addAttribute('order_item', 'repair_screencode', $options);

$installer->endSetup();
