<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Ceneo extends Mage_Core_Helper_Abstract
{

    const DELIVERY_24H = 1;
    const DELIVERY_72H = 3;
    const DELIVERY_WEEK = 7;
    const DELIVERY_DELAY = 14;
    const DELIVERY_UNKNOWN = 99;
    const CATEGORY_PATH = 'Biżuteria i zegarki/Biżuteria dla kobiet/Pozostała biżuteria';
    
    public function getCeneoCategory($product) {

        $categories = $product->getCategoryCollection();

        $data = array();
        $path = Mage::getModuleDir('etc', 'LCB_Feeds') . '/ceneo.xml';
        $xml = new SimpleXMLElement(file_get_contents($path));

        if ($categories) {
            $id = $categories->getFirstItem()->getId();
            $category = Mage::getModel('catalog/category')->load($id);
            foreach ($xml as $cat) {
                return self::CATEGORY_PATH;
                if(empty($cat->Id)){
                    $cat->Id = 1109;
                }
                return $cat->Id;
                if ($cat->Id == $category->getCeneoCategory()) {
                    return $cat->Name;
                }
            }
        }
    }

}
