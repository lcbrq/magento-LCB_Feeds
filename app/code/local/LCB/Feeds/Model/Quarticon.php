<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2018 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Model_Quarticon extends LCB_Feeds_Model_Abstract
{

    /**
     * @param array $args
     * @return string
     */
    public function generate($args = array())
    {
        
        Mage::app()->setCurrentStore(1);

        if ($xml = $this->getXml('quarticon')) {
            return $xml;
        }

        $doc = new DOMDocument();
        $doc->formatOutput = true;
        $products = $doc->createElement("products");
        $products->setAttribute('xmlns', 'http://cp.quarticon.com/docs/catalog/1.1/schema');
        $products->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $products->setAttribute('xmlns:schemaLocation', 'http://cp.quarticon.com/docs/catalog/1.1/schema/quartic_catalog_1.1.xsd');
        $doc->appendChild($products);

        $collection = Mage::getModel('lcb_feeds/catalog_product')->getCollection();

        foreach ($collection as $_product) {

            $product = Mage::getModel('catalog/product')->load($_product->getId());
            $categories = $product->getCategoryIds();

            $element = $doc->createElement('product');

            $this->addChild($doc, $element, 'id', $_product->getId());
            $this->addChild($doc, $element, 'title', $_product->getName(), true);
            $this->addChild($doc, $element, 'link', $_product->getProductUrl());
            $this->addChild($doc, $element, 'status', $_product->getStatus());
            $this->addChild($doc, $element, 'price', number_format((float) $_product->getFinalPrice(), 2));
            $this->addChild($doc, $element, 'custom_1', $_product->getManufacturer());

            $i = 1;
            foreach ($categories as $categoryId) {
                $category = Mage::getModel('catalog/category')->load($categoryId);
                $this->addChild($doc, $element, "category_$i", $category->getName(), true);
                $i++;
            }

            $this->addChild($doc, $element, 'thumb', Mage::helper('catalog/product')->getImageUrl($_product));

            $products->appendChild($element);
        }

        return $this->saveXml('quarticon', $doc);
    }

}
