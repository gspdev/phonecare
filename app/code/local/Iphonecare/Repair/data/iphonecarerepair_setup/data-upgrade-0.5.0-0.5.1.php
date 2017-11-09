<?php

$installer = $this;
$connection = $installer->getConnection();
$installer->startSetup();

$iphoneCareRepair = Mage::getModel('iphonecarerepair/stores')->getCollection();

foreach($iphoneCareRepair as $item) {
    if($item->getAddress() == 'Arenaslingan 7') {
        $item->setAddress('Kungsgatan 29')
            ->setPostcodeCode('11156')
            ->setCity('Stockholm')
            ->save();
    }
    elseif ($item->getAddress() == 'Sehlstedtgatan 4'){
        $item->setAddress('Tivolivägen 2')
            ->setPostcodeCode('12631')
            ->setCity('Hägersten')
            ->save();
    }
}

$installer->endSetup();