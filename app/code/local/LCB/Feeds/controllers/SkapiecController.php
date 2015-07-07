<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_SkapiecController extends Mage_Core_Controller_Front_Action {

    public function IndexAction() {

        header("Content-type: text/xml; charset=utf-8");
        $doc = new DOMDocument();
        $doc->formatOutput = true;

        $xmldata = $doc->createElement("xmldata");
        $doc->appendChild($xmldata);

        $version = $doc->createElement("version");
        $version->appendChild(
                $doc->createTextNode('10')
        );
        $xmldata->appendChild($version);

        $header = $doc->createElement("header");
        $xmldata->appendChild($header);
        $www = $doc->createElement("www");
        $www->appendChild(
                $doc->createTextNode(Mage::getBaseUrl())
        );
        $header->appendChild($www);

        $category = $doc->createElement("category");

        $categories = Mage::getModel('catalog/category')->getCollection()->addUrlRewriteToResult();
        foreach ($categories as $cat) {

            $catitem = $doc->createElement("catitem");

            $catid = $doc->createElement("catid");
            $catid->appendChild(
                    $doc->createTextNode($cat->getId())
            );
            $catitem->appendChild($catid);

            $catname = $doc->createElement("catname");
            $catname->appendChild(
                    $doc->createTextNode($cat->getUrl())
            );
            $catitem->appendChild($catname);

            $category->appendChild($catitem);
        }


        $xmldata->appendChild($category);


        $data = $doc->createElement("data");
        $xmldata->appendChild($data);

        $collection = Mage::getModel('feeds/catalog_product')->getCollection();
        foreach ($collection as $_product) {

            $product = Mage::getModel('catalog/product')->load($_product->getId());

            $item = $doc->createElement("item");

            $id = $doc->createElement("compid");
            $id->appendChild(
                    $doc->createTextNode($product->getId())
            );
            $item->appendChild($id);

            $description = $doc->createElement("desc");
            $description->appendChild(
                    $doc->createTextNode($product->getName())
            );
            $item->appendChild($description);

            $price = $doc->createElement("price");
            $price->appendChild(
                    $doc->createTextNode($product->getFinalPrice())
            );
            $item->appendChild($price);

            $data->appendChild($item);
        }

        echo $doc->saveXML();

        exit();

        //file_put_contents($file,$doc->saveXML(),FILE_APPEND);
        // $xml->save("sitemap.xml");
    }

}
