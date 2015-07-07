<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_GoogleController extends Mage_Core_Controller_Front_Action {

    public function IndexAction() {

        Mage::app()->setCurrentStore(1);
        
        $helper = Mage::helper('feeds/ceneo');
        
        header("Content-type: text/xml; charset=utf-8");
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->formatOutput = true;

        $rss = $doc->createElement("rss");
        $rss->setAttribute("version", '2.0');
        $rss->setAttribute("xmlns:g", 'http://base.google.com/ns/1.0');
        $doc->appendChild($rss);

        $channel = $doc->createElement("channel");
        $rss->appendChild($channel);
        
        $collection = Mage::getModel('feeds/catalog_product')->getCollection();
        foreach ($collection as $_product) {

            $product = Mage::getModel('catalog/product')->load($_product->getId());

            $item = $doc->createElement("item");
            
            $title = $doc->createElement("title");
            $title->appendChild(
                    $doc->createTextNode($product->getName())
            );
            $item->appendChild($title);
            
            $link = $doc->createElement("link");
            $link->appendChild(
                    $doc->createTextNode($product->getProductUrl())
            );
            $item->appendChild($link);

            $description = $doc->createElement("description");
            $description->appendChild(
                    $doc->createTextNode($product->getDescription())
            );
            $item->appendChild($description);

            $id = $doc->createElement("g:id");
            $id->appendChild(
                    $doc->createTextNode($product->getSku())
            );
            $item->appendChild($id);
            
            $price = $doc->createElement("g:price");
            $price->appendChild(
                    $doc->createTextNode($product->getFinalPrice() . ' ' . Mage::app()->getStore()->getCurrentCurrencyCode())
            );
            $item->appendChild($price);
            
            $image = $doc->createElement("g:image_link");
            $image->appendChild(
                    $doc->createTextNode($product->getImageUrl())
            );
            $item->appendChild($image);
            
            $channel->appendChild($item);
        }

        echo $doc->saveXML();

        exit();

    }

}