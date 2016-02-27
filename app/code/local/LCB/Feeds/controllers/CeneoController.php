<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_CeneoController extends Mage_Core_Controller_Front_Action {

    public function IndexAction() {

        Mage::app()->setCurrentStore(1);
        
        $helper = Mage::helper('feeds/ceneo');
        
        header("Content-type: text/xml; charset=utf-8");
        $doc = new DOMDocument();
        $doc->formatOutput = true;

        $offers = $doc->createElement("offers");
        $doc->appendChild($offers);

        $collection = Mage::getModel('feeds/catalog_product')->getCollection();
        foreach ($collection as $_product) {

            $product = Mage::getModel('catalog/product')->load($_product->getId());

            $offer = $doc->createElement("o");
            $offer->setAttribute("id", $product->getId());
            $offer->setAttribute("url", $product->getProductUrl());
            $offer->setAttribute("price", $product->getFinalPrice());
            $offer->setAttribute("avail", Mage::getModel('cataloginventory/stock_item')->loadByProduct($product)->getQty());
            $offer->setAttribute("weight", $product->getWeight());

            $cat = $doc->createElement("cat");
            $cat->appendChild(
                    $doc->createTextNode($helper->getCeneoCategory($product))
            );
            $offer->appendChild($cat);

            $name = $doc->createElement("name");
            $name->appendChild(
                    $doc->createTextNode($product->getName())
            );
            $offer->appendChild($name);

            $images = $doc->createElement("imgs");
            $main = $doc->createElement("main");
            $main->setAttribute("url", $product->getImageUrl());
            $images->appendChild($main);
            $offer->appendChild($images);

            $description = $doc->createElement("desc");
            $description->appendChild(
                    $doc->createTextNode($product->getDescription())
            );
            $offer->appendChild($description);

            $offers->appendChild($offer);
        }

        echo $doc->saveXML();

        exit();

        //file_put_contents($file,$doc->saveXML(),FILE_APPEND);
        // $xml->save("sitemap.xml");
    }

}
