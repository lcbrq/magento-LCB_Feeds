<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Google extends LCB_Feeds_Helper_Data {

    CONST CONDITION = 'new';
    CONST CATEGORY = '188';

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
    public function getAdditionalFeedFields($item,$doc,$product,$postParams){
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

    /**
     * @param $doc
     * @param $rss
     * @param $channel
     * @return void
     */
    public function addAdditionalChannelElements($doc,$rss,$channel){
        $feedTitle = $doc->createElement('title');
        $feedTitle->appendChild(
            $doc->createTextNode($this->getFeedTitle())
        );

        $channel->appendChild($feedTitle);

        $feedLink = $doc->createElement('link');
        $feedLink->appendChild(
            $doc->createTextNode($this->getFeedLink())
        );

        $channel->appendChild($feedLink);

        $feedMainDescription = $doc->createElement('description');
        $feedMainDescription->appendChild(
            $doc->createTextNode($this->getFeedMainDescription())
        );

        $channel->appendChild($feedMainDescription);
    }

    /**
     * @return string
     */
    protected function getFeedTitle(){
        return 'Google Feed';
    }

    /**
     * @return string
     */
    protected function getFeedLink(){
        return  Mage::getBaseUrl().'datafeeds/google';
    }

    /**
     * @return string
     */
    protected function getFeedMainDescription(){
        return 'Google Feed';
    }

    /**
     * @param $product
     * @return string
     */
    public function getProductCondition($product){
        return self::CONDITION;
    }

    /**
     * @param $product
     * @return string
     */
    public function getCategory($product){
        return self::CATEGORY;
    }

}
