<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Google extends LCB_Feeds_Helper_Data {

    /**
     * @param Mage_Model_Catalog_Product $product
     * @return string
     */
    public function getGoogleProductType($product)
    {

        $names = array();
        $categoryIds = array_reverse($product->getCategoryIds());
        foreach ($categoryIds as $categoryId) {
            $names[] = Mage::getModel('catalog/category')->load($categoryId)->getName();
        }
        
        return implode(" > ", $names);
    }

}
