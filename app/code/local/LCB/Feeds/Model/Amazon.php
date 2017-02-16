<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2017 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Model_Amazon extends LCB_Feeds_Model_Abstract {

    public $feed;
    public $attributes = array("sku", "ean", "name", "weight", "width", "length", "height", "amazon_prijs", "offer_description");
    public $columns = array();

    /**
     * Export Amazon csv file
     * 
     * @param $filename
     * @return string $path
     */
    public function export($filename)
    {

        $path = Mage::getBaseDir() . DS . 'feeds';

        $collection = Mage::getModel('lcb_feeds/catalog_product')->getCollection()
                ->addAttributeToSelect("*")
                ->addAttributeToFilter("amazon_enabled", true);

        $headers = array();
        $data = $collection->getFirstItem()->getData();
        foreach ($data as $attribute => $value) {
            if (in_array($attribute, $this->attributes)) {
                $this->columns[] = $attribute;
            }
        }

        $this->columns[] = "category";

        try {
            $this->file = new Varien_Io_File();
            $this->file->setAllowCreateFolders(true);
            $this->file->open(array('path' => $path));
            $this->file->streamOpen($path . DS . $filename, 'w+');
            $this->file->streamLock(true);
            $this->file->streamWriteCsv($this->columns);
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

        Mage::getSingleton('core/resource_iterator')->walk($collection->getSelect(), array(array($this, 'generate')));

        return $path . DS . $filename;
    }

    public function generate($args)
    {
        $row = array();

        $product = Mage::getModel('catalog/product');
        $product->setId($args['row']['entity_id']);

        foreach ($this->columns as $column) {
            switch ($column) {
                case "category":
                    $categoryIds = $product->getResource()->getCategoryIds($product);
                    if ($categoryIds) {
                        $row[] = Mage::getModel('catalog/category')->load(max($categoryIds))->getName();
                    }
                    break;
                default:
                    $row[] = $this->prepareColumn(Mage::getResourceModel("catalog/product")->getAttributeRawValue($product->getId(), $column, Mage::app()->getStore()));
                    break;
            }
        }

        $this->file->streamWriteCsv($row);
    }

    /**
     * Prepare column for csv export
     * 
     * @param string $value
     * @return string
     */
    public function prepareColumn($value)
    {
        $value = str_replace('"', "'", $value);
        $value = str_replace("'", "", $value);
        $value = preg_replace('/\s\s+/', ' ', $value);
        return $value;
    }

}
