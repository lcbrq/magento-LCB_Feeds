<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */


$installer = $this;
$installer->startSetup();

$installer->removeAttribute('catalog_category', 'ceneo_category');
$installer->addAttribute("catalog_category", "ceneo_category", array(
    "type" => "varchar",
    "backend" => "",
    "frontend" => "",
    "label" => "Kategoria Ceneo",
    "input" => "select",
    "class" => "",
    "source" => "feeds/eav_entity_attribute_source_ceneo",
    "global" => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    "visible" => true,
    "required" => false,
    "user_defined" => false,
    "default" => "",
    "searchable" => false,
    "filterable" => false,
    "comparable" => false,
    "visible_on_front" => true,
    "unique" => false,
    "note" => "Powiązanie z kategorią Ceneo"
));

$installer->endSetup();
