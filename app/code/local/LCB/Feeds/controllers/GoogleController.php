<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

/**
 * Class LCB_Feeds_GoogleController
 */
class LCB_Feeds_GoogleController extends Mage_Core_Controller_Front_Action {

    /** @var  */
    public $product;

    public function indexAction() {
        
        $helper = Mage::helper('lcb_feeds/google');
        
        header("Content-type: text/xml; charset=utf-8");
        $doc = new DOMDocument('1.0', 'utf-8');
        $doc->formatOutput = true;

        $rss = $doc->createElement("rss");
        $rss->setAttribute("version", '2.0');
        $rss->setAttribute("xmlns:g", 'http://base.google.com/ns/1.0');
        $doc->appendChild($rss);

        $channel = $doc->createElement("channel");
        $rss->appendChild($channel);
        
        $this->addAdditionalChannelElements($doc,$rss,$channel);
        
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
                    $doc->createTextNode($this->getDescription($product))
            );
            $item->appendChild($description);

            $id = $doc->createElement("g:id");
            $id->appendChild(
                    $doc->createTextNode($product->getSku())
            );
            $item->appendChild($id);

            $condition = $helper->getProductCondition($product);
            
            $id = $doc->createElement("g:condition");
            $id->appendChild(
                    $doc->createTextNode($condition)
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

            $this->addAdditionalFeedELements($item,$doc,$product);
            
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

            $category = $helper->getCategory($product);
            
            $id = $doc->createElement("g:google_product_category");
            $id->appendChild(
                    $doc->createTextNode($category)
            );
            $item->appendChild($id);

            /**
             * Create product_type tag for feed
             * @important: Only the first product_type tag will be used
             * @see: https://support.google.com/merchants/answer/6324406
             */

            $times = 10; // Max available repeats of the product type tag
            $index = 0;

            $googleProductTypes = $helper->getGoogleProductType($_product);

            foreach ($googleProductTypes as $googleProductType) {
                $type = $doc->createElement("g:product_type");
                $type->appendChild(
                    $doc->createTextNode($googleProductType)
                );
                $item->appendChild($type);
                $index++;
                if($times == $index){
                    break;
                }
            }
            
            $channel->appendChild($item);
        }

        $doc->save('google_feed.xml');
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

    /**
     * @param $product
     * @return mixed
     */
    public function getDescription($product) {
        return Mage::helper('lcb_feeds/google')->getFeedDescription($product);
    }

    /**
     * @param $doc
     * @param $rss
     * @param $channel
     * @return mixed
     */
    public function addAdditionalChannelElements($doc,$rss,$channel){
        return Mage::helper('lcb_feeds/google')->addAdditionalChannelElements($doc,$rss,$channel);
    }

    /**
     * @param $item
     * @param $doc
     * @return mixed
     */
    public function addAdditionalFeedELements($item,$doc,$product){
        return Mage::helper('lcb_feeds/google')->getAdditionalFeedFields($item,$doc,$product);
    }

}