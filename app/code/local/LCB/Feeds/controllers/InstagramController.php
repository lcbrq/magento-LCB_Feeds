<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_InstagramController extends Mage_Core_Controller_Front_Action {
    
    CONST CONDITION = 'new';
    CONST CATEGORY = '188';

    public $product;
    
    public function IndexAction() {
        
        $helper = Mage::helper('lcb_feeds/ceneo');
        
        header("Content-type: text/xml; charset=utf-8");
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->formatOutput = true;

        $rss = $doc->createElement("rss");
        $rss->setAttribute("version", '2.0');
        $rss->setAttribute("xmlns:g", 'http://base.google.com/ns/1.0');
        $doc->appendChild($rss);

        $channel = $doc->createElement("channel");
        $rss->appendChild($channel);
        
        $productMediaConfig = Mage::getModel('catalog/product_media_config');
        $collection = Mage::getModel('lcb_feeds/catalog_product')->getCollection();
        foreach ($collection as $_product) {

            $product = Mage::getModel('catalog/product')->load($_product->getId());
            $this->product = $product;

            $item = $doc->createElement("item");
            
            $title = $doc->createElement("title");
            $title->appendChild(
                    $doc->createTextNode($this->getName())
            );
            $item->appendChild($title);
            
            $link = $doc->createElement("link");
            $link->appendChild(
                    $doc->createTextNode($product->getProductUrl())
            );
            $item->appendChild($link);

            $description = $doc->createElement("description");
            $description->appendChild(
                    $doc->createTextNode($this->getDescription())
            );
            $item->appendChild($description);

            $id = $doc->createElement("g:id");
            $id->appendChild(
                    $doc->createTextNode($product->getSku())
            );
            $item->appendChild($id);
            
            $id = $doc->createElement("g:condition");
            $id->appendChild(
                    $doc->createTextNode(self::CONDITION)
            );
            $item->appendChild($id);
            
            $availability = $doc->createElement("g:availability");
            $availability->appendChild(
                    $doc->createTextNode($this->getAvailability())
            );
            $item->appendChild($availability);
            
            $price = $doc->createElement("g:price");
            $price->appendChild(
                    $doc->createTextNode($product->getFinalPrice() . ' ' . Mage::app()->getStore()->getCurrentCurrencyCode())
            );
            $item->appendChild($price);
            
            $brand = $doc->createElement("g:brand");
            $brand->appendChild(
                    $doc->createTextNode($product->getManufacturer())
            );
            $item->appendChild($brand);
            
            $mpn = $doc->createElement("g:mpn");
            $mpn->appendChild(
                    $doc->createTextNode($product->getSku())
            );
            $item->appendChild($mpn);
            
            $image = $doc->createElement("g:image_link");
            $image->appendChild(
                    $doc->createTextNode($productMediaConfig->getMediaUrl($product->getImage()))
            );
            $item->appendChild($image);
            
            $id = $doc->createElement("g:google_product_category");
            $id->appendChild(
                    $doc->createTextNode(self::CATEGORY)
            );
            $item->appendChild($id);
         //   $item->appendChild($type);
            
            $channel->appendChild($item);
        }

        echo $doc->saveXML();

        exit();

    }
    
    public function getAvailability(){
        $stock = $this->product->getIsInStock();
        if($stock){
            return 'in stock';
        } else {
            return 'out of stock';
        }
    }
    
    public function getName() {
        $name = $this->product->getNameGoogle();
        if ($name) {
            return $name;
        } else {
            return $this->product->getName();
        }
    }

    public function getDescription() {
        $description = $this->product->getDescriptionGoogle();
        if ($description) {
            return $description;
        } elseif($this->product->getDescription()) {
            return $this->product->getDescription();
        } else {
            return $this->product->getShortDescription();
        }
    }

}
