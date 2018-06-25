<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Data extends Mage_Core_Helper_Abstract {


    CONST PRODUCT_FEED_GROUP_NAME = 'Product Feed';
    
    /**
     * @param Mage_Model_Catalog_Product $product
     * @return string
     */
    public function getProductDescription($product)
    {
        if ($product->getDescription()) {
            return $product->getDescription();
        } else {
            return $product->getShortDescription();
        }
    }

}
