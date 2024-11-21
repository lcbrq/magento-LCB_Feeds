<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Google extends LCB_Feeds_Helper_Data
{

    /**
     * @var array
     */
    private $categoryNames = [];

    /**
     * @param Mage_Model_Catalog_Product $product
     * @return string
     */
    public function getGoogleProductType($product)
    {
        $names = array();
        $categoryIds = array_reverse($product->getCategoryIds());
        foreach ($categoryIds as $categoryId) {
            if ($categoryId > 3) {
                $names[] = $this->getCategoryName($categoryId);
            }
        }
        
        return implode(" > ", $names);
    }

    /**
     * @param int $categoryId
     * @return string
     */
    private function getCategoryName($categoryId)
    {
        if (!isset($this->categoryNames[$categoryId])) {
            $this->categoryNames[$categoryId] = Mage::getModel('catalog/category')->load($categoryId)->getName();
        }

        return $this->categoryNames[$categoryId];
    }
}
