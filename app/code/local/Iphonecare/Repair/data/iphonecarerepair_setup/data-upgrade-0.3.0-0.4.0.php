<?php

$installer = $this;
$connection = $installer->getConnection();
$installer->startSetup();
$data = array(
    array(
        'store_type'    => 0,
        'country_code'  => 'SE',
        'postcode_code' => '11346',
        'region_id'     => '0',
        'city'          => 'Stockholm',
        'address'       => 'Kungsgatan 10',
        'store_status'  => 1,
    ),
    array(
        'store_type'    => 1,
        'country_code'  => 'SE',
        'postcode_code' => '18145',
        'region_id'     => '0',
        'city'          => 'Stockholm',
        'address'       => 'Arenaslingan 7',
        'store_status'  => 1,
    ),
    array(
        'store_type'    => 1,
        'country_code'  => 'SE',
        'postcode_code' => '18122',
        'region_id'     => '0',
        'city'          => 'Stockholm',
        'address'       => 'Sehlstedtgatan 4',
        'store_status'  => 1,
    ),
);
$connection = $installer->getConnection()->insertArray(
    $installer->getTable('iphonecarerepair/stores'),
    array('store_type', 'country_code', 'postcode_code',
        'region_id', 'city', 'address', 'store_status'
    ),
    $data
);
$installer->endSetup();
