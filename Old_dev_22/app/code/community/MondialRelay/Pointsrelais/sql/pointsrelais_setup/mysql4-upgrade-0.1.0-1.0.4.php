<?php
$installer = $this;

$installer->startSetup();
$installer->run("
DROP TABLE IF EXISTS {$this->getTable('mondialrelay_pointsrelaisld1')};
CREATE TABLE {$this->getTable('mondialrelay_pointsrelaisld1')} (
  `id` int(10) unsigned NOT NULL auto_increment,
  `website_id` int(11) NOT NULL default '0',
  `dest_country_id` varchar(4) NOT NULL default '0',
  `dest_region_id` int(10) NOT NULL default '0',
  `dest_zip` varchar(10) NOT NULL default '',
  `condition_name` varchar(20) NOT NULL default '',
  `condition_value` decimal(12,4) NOT NULL default '0.0000',
  `price` decimal(12,4) NOT NULL default '0.0000',
  `cost` decimal(12,4) NOT NULL default '0.0000',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `dest_country` (`website_id`,`dest_country_id`,`dest_region_id`,`dest_zip`,`condition_name`,`condition_value`)
) DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS {$this->getTable('mondialrelay_pointsrelaislds')};
CREATE TABLE {$this->getTable('mondialrelay_pointsrelaislds')} (
  `id` int(10) unsigned NOT NULL auto_increment,
  `website_id` int(11) NOT NULL default '0',
  `dest_country_id` varchar(4) NOT NULL default '0',
  `dest_region_id` int(10) NOT NULL default '0',
  `dest_zip` varchar(10) NOT NULL default '',
  `condition_name` varchar(20) NOT NULL default '',
  `condition_value` decimal(12,4) NOT NULL default '0.0000',
  `price` decimal(12,4) NOT NULL default '0.0000',
  `cost` decimal(12,4) NOT NULL default '0.0000',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `dest_country` (`website_id`,`dest_country_id`,`dest_region_id`,`dest_zip`,`condition_name`,`condition_value`)
) DEFAULT CHARSET=utf8;
");

$storesData = $installer->getConnection()->fetchAll("
    SELECT
        DISTINCT (s.website_id)
    FROM
        {$installer->getTable('core/store')} as s,
        {$this->getTable('mondialrelay_pointsrelaisld1')} as mr
    WHERE
    	s.website_id NOT IN (SELECT DISTINCT (website_id) FROM {$this->getTable('mondialrelay_pointsrelaisld1')})
");
    foreach ($storesData as $storeData) {
		$websiteId = $storeData['website_id'];
		$query = "INSERT INTO {$this->getTable('mondialrelay_pointsrelaisld1')} (`website_id`, `dest_country_id`, `dest_region_id`, `dest_zip`, `condition_name`, `condition_value`, `price`, `cost`) VALUES
			({$websiteId}, 'FR', 0, '', 'package_weight', 0.5000, 4.2000, 4.2000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 1.0000, 4.2000, 4.2000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 2.0000, 5.5000, 5.5000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 3.0000, 6.2000, 6.2000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 5.0000, 7.5000, 7.5000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 7.0000, 9.6000, 9.6000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 10.0000, 11.9500, 11.9500),
			({$websiteId}, 'FR', 0, '', 'package_weight', 15.0000, 14.3500, 14.3500),
			({$websiteId}, 'FR', 0, '', 'package_weight', 20.0000, 17.9500, 17.9500),
			({$websiteId}, 'BE', 0, '', 'package_weight', 0.5000, 4.2000, 4.2000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 1.0000, 4.8000, 4.8000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 2.0000, 5.5000, 5.5000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 3.0000, 6.2000, 6.2000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 5.0000, 7.5000, 7.5000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 7.0000, 9.6000, 9.6000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 10.0000, 11.9500, 11.9500),
			({$websiteId}, 'BE', 0, '', 'package_weight', 15.0000, 14.3500, 14.3500),
			({$websiteId}, 'BE', 0, '', 'package_weight', 20.0000, 17.9500, 17.9500);
			";
		$installer->run($query);
	}

$storesData = $installer->getConnection()->fetchAll("
    SELECT
        DISTINCT (s.website_id)
    FROM
        {$installer->getTable('core/store')} as s,
        {$this->getTable('mondialrelay_pointsrelaislds')} as mr
    WHERE
    	s.website_id NOT IN (SELECT DISTINCT (website_id) FROM {$this->getTable('mondialrelay_pointsrelaislds')})
");
    foreach ($storesData as $storeData) {
		$websiteId = $storeData['website_id'];
		$query = "INSERT INTO {$this->getTable('mondialrelay_pointsrelaislds')} (`website_id`, `dest_country_id`, `dest_region_id`, `dest_zip`, `condition_name`, `condition_value`, `price`, `cost`) VALUES
			({$websiteId}, 'FR', 0, '', 'package_weight', 0.5000, 4.2000, 4.2000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 1.0000, 4.2000, 4.2000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 2.0000, 5.5000, 5.5000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 3.0000, 6.2000, 6.2000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 5.0000, 7.5000, 7.5000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 7.0000, 9.6000, 9.6000),
			({$websiteId}, 'FR', 0, '', 'package_weight', 10.0000, 11.9500, 11.9500),
			({$websiteId}, 'FR', 0, '', 'package_weight', 15.0000, 14.3500, 14.3500),
			({$websiteId}, 'FR', 0, '', 'package_weight', 20.0000, 17.9500, 17.9500),
			({$websiteId}, 'BE', 0, '', 'package_weight', 0.5000, 4.2000, 4.2000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 1.0000, 4.8000, 4.8000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 2.0000, 5.5000, 5.5000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 3.0000, 6.2000, 6.2000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 5.0000, 7.5000, 7.5000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 7.0000, 9.6000, 9.6000),
			({$websiteId}, 'BE', 0, '', 'package_weight', 10.0000, 11.9500, 11.9500),
			({$websiteId}, 'BE', 0, '', 'package_weight', 15.0000, 14.3500, 14.3500),
			({$websiteId}, 'BE', 0, '', 'package_weight', 20.0000, 17.9500, 17.9500);
			";
		$installer->run($query);
	}
	
$entityTypeId     = $installer->getEntityTypeId('catalog_product');
$attributeSetId   = $installer->getDefaultAttributeSetId($entityTypeId);


// On cree l'attribut shipping_method
$attribute = array(
    'developed_length'         => array(
		'input'         => 'text',
		'type'          => 'int',
	    'label'         => 'developed length in cm',
	    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
	    'visible'       => 1,
        'sort'  		=> 10,
		'required'		=> false,
    ),
);

// On ajoute l'attribut cree
foreach ($attribute as $attributeCode => $attributeInfos) {
	$installer->addAttribute($entityTypeId, $attributeCode, $attributeInfos);
}
$installer->endSetup();
