<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2017 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

$installer = $this;
$installer->startSetup();

$installer->updateAttribute('catalog_category', 'ceneo_category', 'source', 'lcb_feeds/eav_entity_attribute_source_ceneo');

$installer->endSetup();