<?php
require dirname(__FILE__) . "/config.php";


//set product qty is 0
//UPDATE cataloginventory_stock_item SET `qty` = 0,`is_in_stock` = 0;
define("__ATTR_PRODUCT_QTY__" , 0);
define("__ATTR_PRODUCT_IS_IN_STOCK__" , 0);
define("__ATTR_PRODUCT_STOCK_ITEM__" , "cataloginventory_stock_item");

   global $db;
   $sql = "UPDATE " . __ATTR_PRODUCT_STOCK_ITEM__ . " SET `qty`=" . __ATTR_PRODUCT_QTY__.",`is_in_stock`=".__ATTR_PRODUCT_IS_IN_STOCK__." ";
    $db->query($sql);
	echo " Inventory update successfully<br>";

