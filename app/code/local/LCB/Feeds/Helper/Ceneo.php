<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Ceneo extends Mage_Core_Helper_Abstract {

    const DELIVERY_24H = 1;
    const DELIVERY_72H = 3;
    const DELIVERY_WEEK = 7;
    const DELIVERY_DELAY = 14;
    const DELIVERY_UNKNOWN = 99;

    public function getCeneoCategory($product)
    {

        if (!$product->getCategoryIds()) {
            return false;
        }
        $categoryIds = array_reverse($product->getCategoryIds());
        return Mage::getModel('catalog/category')->load(array_shift($categoryIds))->getCeneoCategory();
    }

}
