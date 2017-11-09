<?php
$installer = $this;
$tableName = $installer->getTable('iphonecarerepair/stores');
$installer->startSetup();

if (!$installer->getConnection()->isTableExists($tableName)) {
    $table = $installer->getConnection()
        ->newTable($tableName)
        ->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Id')
        ->addColumn('store_type', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => 1,
        ), 'Store type')
        ->addColumn('country_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable'  => false,
        ), 'Country code')
        ->addColumn('region_id', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable'  => false,
        ), 'Region ID')
        ->addColumn('postcode_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable'  => false,
        ), 'Post code')
        ->addColumn('city', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable'  => false,
        ), 'City')
        ->addColumn('address', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
            'nullable'  => false,
        ), 'Address')
        ->addColumn('store_status', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
            'nullable'  => false,
            'default'   => 1,
        ), 'Store type')

        ->setOption('charset', 'utf8')
        ->setOption('type', 'InnoDB')
        ->setComment('IphoneCare Repair stores');

    $installer->getConnection()->createTable($table);
}

$installer->endSetup();
