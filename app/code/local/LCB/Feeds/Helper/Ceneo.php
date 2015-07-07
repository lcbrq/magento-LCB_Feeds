<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Ceneo extends Mage_Core_Helper_Abstract
{

    public function getCeneoCategory($product) {

        $categories = $product->getCategoryCollection();

        $data = array();
        $path = Mage::getModuleDir('etc', 'LCB_Feeds') . '/ceneo.xml';
        $xml = new SimpleXMLElement(file_get_contents($path));

        if ($categories) {
            $id = $categories->getFirstItem()->getId();
            $category = Mage::getModel('catalog/category')->load($id);
            foreach ($xml as $cat) {
                if ($cat->Id == $category->getCeneoCategory()) {
                    return $cat->Name;
                }
            }
        }
    }

}
