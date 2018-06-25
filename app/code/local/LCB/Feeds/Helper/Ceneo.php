<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Ceneo extends LCB_Feeds_Helper_Data {

    const DELIVERY_24H = 1;
    const DELIVERY_72H = 3;
    const DELIVERY_WEEK = 7;
    const DELIVERY_DELAY = 14;
    const DELIVERY_UNKNOWN = 99;
    
    CONST CENEO_CATEGORY_ATTRIBUTE_CODE = 'ceneo_category';

    /**
     * @param Mage_Model_Catalog_Product $product
     * @return string
     */
    public function getCeneoCategory($product)
    {

        if (!$product->getCategoryIds()) {
            return false;
        }
        $categoryIds = array_reverse($product->getCategoryIds());
        foreach ($categoryIds as $categoryId) {
            $ceneoCategory = Mage::getModel('catalog/category')->load($categoryId)->getCeneoCategory();
            if ($ceneoCategory) {
                return $ceneoCategory;
            }
        }
        
        return false;
    }

}
