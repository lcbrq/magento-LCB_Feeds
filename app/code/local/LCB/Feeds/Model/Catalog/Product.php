<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2019 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Model_Catalog_Product extends Mage_Catalog_Model_Product
{

    /**
     * @var int
     */
    const COLLECTION_LIMIT = 3600;

    /**
     * @var array
     */
    public $attributesMap = array();

    /**
     * @return Mage_Catalog_Model_Product_Collection
     */
    public function getCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->joinField('is_in_stock', 'cataloginventory/stock_item', 'is_in_stock', 'product_id=entity_id', '{{table}}.stock_id=1', 'left')
                ->addAttributeToSelect(array('sku', 'name', 'description'))
                ->addAttributeToFilter('is_in_stock', array('neq' => 0))
                ->addAttributeToFilter('visibility', array(
                    'in' => 4
                ))->addAttributeToFilter(
                'status', array('eq' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED));

        if (Mage::getStoreConfig('lcb_feeds/general/hide_no_description', Mage::app()->getStore())) {
            $collection
                    ->addAttributeToFilter(array(
                        array(
                            'attribute' => 'description',
                            'neq' => '&nbsp;'),
                        array(
                            'attribute' => 'short_description',
                            'neq' => '&nbsp;'),
                    ))
                    ->addAttributeToFilter(array(
                        array(
                            'attribute' => 'description',
                            'null' => false),
                        array(
                            'attribute' => 'short_description',
                            'null' => false),
            ));
        }

        $limit = Mage::app()->getRequest()->getParam('limit') ? Mage::app()->getRequest()->getParam('limit') : self::COLLECTION_LIMIT;
        $collection->getSelect()->limit($limit);

        return $collection;
    }

    /**
     * @param string $attribute
     * @return mixed
     */
    public function getAttribute($attribute)
    {
        if (!isset($this->attributesMap[$attribute])) {
            $this->attributesMap[$attribute] = Mage::getStoreConfig("lcb_feeds/attributes/$attribute", $this->getStoreId());
        }

        return $this->attributesMap[$attribute];
    }

    /**
     * Get product image for feed, use custom attribute if exists
     *
     * @return mixed
     */
    public function getImage()
    {
        if (($attribute = $this->getAttribute('image')) && ($value = $this->getData($attribute))) {
            if ($value !== 'no_selection') {
                return $value;
            }
        }

        return parent::getImage();
    }

}
