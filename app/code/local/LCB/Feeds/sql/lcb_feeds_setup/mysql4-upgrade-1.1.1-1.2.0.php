<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2017 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$this->removeAttribute(Mage_Catalog_Model_Product::ENTITY, 'ceneo_export');
$this->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'ceneo_export', array(
    'type' => 'int',
    'input' => 'select',
    'group' => 'General',
    'sort_order' => 999,
    'label' => 'Ceneo',
    'source' => 'eav/entity_attribute_source_boolean',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'required' => '0',
    'comparable' => '0',
    'searchable' => '0',
    'is_configurable' => '0',
    'user_defined' => '1',
    'visible_on_front' => 0,
    'visible_in_advanced_search' => 0,
    'is_html_allowed_on_front' => 0,
    'required' => 0,
    'default' => 1,
    'unique' => false,
    'is_configurable' => false
));

$installer->endSetup();
