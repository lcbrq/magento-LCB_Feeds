<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Google extends LCB_Feeds_Helper_Data {

    /**
     * Format each product category id to get the full path from root category
     * for example : Home > Category > SubCategory > ...
     * exclude Magento Root Category (id = 1)
     * @param $product
     * @return array
     */
    public function getGoogleProductType($product)
    {
        $result = [];
        $categoryNames= [];
        $paths = array();
        $categoryIds = array_reverse($product->getCategoryIds());

        foreach ($categoryIds as $categoryId) {
            $paths[$categoryId] = Mage::getModel('catalog/category')->load($categoryId)->getPath();
        }

        foreach ($paths as $catId => $path) {
            $ids = explode('/',$path);
            foreach ($ids as $id) {
                if($id != 1){
                    $categoryNames[$catId][] = Mage::getModel('catalog/category')->load($id)->getName();
                }
            }
        }

        foreach ($categoryNames as $categoryName) {
            $result[] = implode(" > ",$categoryName);
        }
        
        return $result;
    }

    /**
     * Create additional feed tags
     * @param $item
     * @param $doc
     * @param $product
     * @return bool
     */
    public function getAdditionalFeedFields($item,$doc,$product){
        return true;
    }

    /**
     * Get product description
     * @param $product
     * @return mixed
     */
    public function getFeedDescription($product){
        $description = $product->getDescriptionGoogle();
        if ($description) {
            return $description;
        } elseif($product->getDescription()) {
            return $product->getDescription();
        } else {
            return $product->getShortDescription();
        }
    }

}
