<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Model_Catalog_Product
{

    public function getCollection() {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->joinField('is_in_stock', 'cataloginventory/stock_item', 'is_in_stock', 'product_id=entity_id', '{{table}}.stock_id=1', 'left')
                ->addAttributeToSelect(array('sku', 'name'))
                ->addFieldToFilter('type_id', 'simple')
                ->addAttributeToFilter('is_in_stock', array('neq' => 0))
                ->addAttributeToFilter('visibility', array(
                    'in' => 4
        ));
        return $collection;
    }

}