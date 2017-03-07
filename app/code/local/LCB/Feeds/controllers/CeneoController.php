<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_CeneoController extends Mage_Core_Controller_Front_Action {

    const DELIVERY_ATTRIBUTE = 'data_dostawy';
    
    public function indexAction() {

        Mage::app()->setCurrentStore(1);
        
        $helper = Mage::helper('lcb_feeds/ceneo');
        
        header("Content-type: text/xml; charset=utf-8");
        $doc = new DOMDocument();
        $doc->formatOutput = true;

        $offers = $doc->createElement("offers");
        $offers->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
        $offers->setAttribute("version", "1");
        $doc->appendChild($offers);

        $collection = Mage::getModel('lcb_feeds/catalog_product')->getCollection();
        foreach ($collection as $_product) {

            $product = Mage::getModel('catalog/product')->load($_product->getId());
            $category = $helper->getCeneoCategory($product);
    
            if(!$category){
                continue;
            }
            
            $offer = $doc->createElement("o");
            $offer->setAttribute("id", $product->getId());
            $offer->setAttribute("url", $product->getProductUrl());
            $offer->setAttribute("price", number_format($product->getFinalPrice(), 2, '.', ''));
            $offer->setAttribute("avail", 1);
            /*
            switch ($product->getData(self::DELIVERY_ATTRIBUTE)) {
                case 97:
                $offer->setAttribute("avail", $helper::DELIVERY_24H);
                break;
                case 89:
                $offer->setAttribute("avail", $helper::DELIVERY_72H);
                break;
                default:
                $offer->setAttribute("avail", $helper::DELIVERY_WEEK);
            }
            */
            $offer->setAttribute("stock", rand(10,99));

            $weight = explode('-', $product->getWeight());

            if($masa[count($weight) - 1])
                $offer->setAttribute("weight", $weight[count($weight) - 1]/1000);
            else
                $offer->setAttribute("weight", 0.001);

            $cat = $doc->createElement("cat");
            $cat->appendChild($doc->createTextNode($category));
            $offer->appendChild($cat);

            $name = $doc->createElement("name");
            $name->appendChild($doc->createTextNode($product->getName()));
            $offer->appendChild($name);

            $images = $doc->createElement("imgs");
            $main = $doc->createElement("main");
            $main->setAttribute("url", Mage::helper('catalog/image')->init($product,'image'));
            $images->appendChild($main);
            foreach($product->getMediaGalleryImages() as $image){
                if ($image->getFile() != $product->getImage()){
                $i = $doc->createElement("i");
                $i->setAttribute("url", $image->getUrl());
                $images->appendChild($i);
            }
            }
            $offer->appendChild($images);

            $description = $doc->createElement("desc");
            $description->appendChild($doc->createTextNode($helper->getProductDescription($product)));
            $offer->appendChild($description);

            $offers->appendChild($offer);
        }

        echo $doc->saveXML();

        exit();

        //file_put_contents($file,$doc->saveXML(),FILE_APPEND);
        // $xml->save("sitemap.xml");
    }

}
