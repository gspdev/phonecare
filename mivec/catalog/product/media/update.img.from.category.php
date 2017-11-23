<?php
require dirname(__FILE__) . '/config.php';

//从category的图复制记录更新到产品数据表中
$sql = "";

$_categoryId = 2511;

$_category = getCategory($_categoryId);
//print_r($_category->getData());

$_productIds = getProductIdByCategory($_category);
print_r($_productIds);exit;


function getCategory($_categoryId)
{
    global $db;
    return Mage::getModel('catalog/category')->load($_categoryId);
}


function getProductIdByCategory($_category)
{
    $_productCollection = Mage::getModel('catalog/product')
        ->getCollection()
        ->addCategoryFilter($_category)
        ->setOrder("entity_id" , "DESC");
    if ($_productCollection) {
        $data = array();
        foreach ($_productCollection->getItems() as $_item) {
            $data[] = $_item->getId();
        }
        return $data;
    }
    return false;
}