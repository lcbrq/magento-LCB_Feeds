<?php

/*
 * Create Product feed tab and assign Ceneo category attribute to that tab
 * 
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2018 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

$installer = new Mage_Catalog_Model_Resource_Setup('core_setup');
$installer->startSetup();

$entittyTypeId = $installer->getEntityTypeId('catalog_category');
$attributeSetId = $installer->getDefaultAttributeSetId($entittyTypeId);

$installer->addAttributeGroup($entittyTypeId, $attributeSetId, LCB_Feeds_Helper_Data::PRODUCT_FEED_GROUP_NAME, 100);

$attributeGroupId = $installer->getAttributeGroupId($entittyTypeId, $attributeSetId, LCB_Feeds_Helper_Data::PRODUCT_FEED_GROUP_NAME);

$attributeId = $installer->getAttributeId($entittyTypeId, LCB_Feeds_Helper_Ceneo::CENEO_CATEGORY_ATTRIBUTE_CODE);

$installer->addAttributeToGroup($entittyTypeId, $attributeSetId, $attributeGroupId, $attributeId, null);


$installer->endSetup();
