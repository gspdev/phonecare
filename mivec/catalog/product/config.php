<?php
require dirname(dirname(__FILE__)) . "/config.php";

//table
define("__TABLE_PRODUCT__" , "catalog_product_entity");
define("__TABLE_PRODUCT_PRICE__" , "catalog_product_entity_decimal");
define("__TABLE_PRODUCT_MEDIA__" , "catalog_product_entity_media_gallery");
define("__TABLE_PRODUCT_INT__" , "catalog_product_entity_int");

//attribute
define("__ATTR_PRICE__" , 75);

//image for category
define("__ATTR_CATEGORY_IMG__" , 45);


define("__ATTR_PRODUCT_IMG__" , 88);


//media path
define("__PATH_MEDIA__" , Mage::getBaseDir('media'));
define("__PATH_MEDIA_CATEGORY__" , __PATH_MEDIA__ . "/catalog/category/");
define("__PATH_MEDIA_PRODUCT__" , __PATH_MEDIA__ . "/catalog/product/");
