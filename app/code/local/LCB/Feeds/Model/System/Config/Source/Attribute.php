<?php

/**
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2019 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */
class LCB_Feeds_Model_System_Config_Source_Attribute
{

        /**
         * @var array
         */
	protected $_options = null;

        /**
         * @return array
         */
	public function toOptionArray()
	{
            if (is_null($this->_options)) {

                $entityTypeId = Mage::getModel('eav/entity_type')->loadByCode('catalog_product')->getId();
                $attributes = Mage::getResourceModel('eav/entity_attribute_collection')->setAttributeSetFilter($entityTypeId);

                $this->_options = array(array(
                    'value' => '',
                    'label' => Mage::helper('adminhtml')->__('Default')
                ));

                foreach ($attributes as $attribute) {
                    $this->_options[] = array('value' => $attribute->getAttributeCode(), 'label' => $attribute->getFrontendLabel());
                }

            }

            return $this->_options;
	}

}
