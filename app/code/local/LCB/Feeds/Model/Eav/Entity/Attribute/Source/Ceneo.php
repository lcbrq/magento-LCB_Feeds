<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Model_Eav_Entity_Attribute_Source_Ceneo extends Mage_Eav_Model_Entity_Attribute_Source_Abstract {

    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {

        $data = array();
        $path = Mage::getModuleDir('etc', 'LCB_Feeds') . '/ceneo.xml';
        $xml = new SimpleXMLElement(file_get_contents($path));
        foreach ($xml as $category) {
            $data[] = array('label' => $category->Name, 'value' => $category->Name);
            $data = array_merge($data, $this->appendSubcategories($category, 1, $category->Name));
        }

        return $data;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
            $_options[$option["value"]] = $option["label"];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option["value"] == $value) {
                return $option["label"];
            }
        }
        return false;
    }

    public function appendSubcategories($category, $level = 1, $path = null)
    {
        $prefix = '';
        foreach(range(0, $level) as $i){
            $prefix .= "---";
        }
        $data = array();
        if (isset($category->Subcategories)) {
            if($level++>1){
            $path .= '/' . $category->Name;
            }
            $subcategories = $category->Subcategories->Category;
            foreach ($subcategories as $subcategory) {
                $data[] = array('label' => $prefix . $subcategory->Name, 'value' => $path . '/' .$subcategory->Name);
                $data = array_merge($data, $this->appendSubcategories($subcategory, $level, $path));
            }
        }
        return $data;
    }
    
    /**
     * Retrieve Column(s) for Flat
     *
     * @return array
     */
    public function getFlatColums() {
        $columns = array();
        $columns[$this->getAttribute()->getAttributeCode()] = array(
            "type" => "tinyint(1)",
            "unsigned" => false,
            "is_null" => true,
            "default" => null,
            "extra" => null
        );

        return $columns;
    }

    /**
     * Retrieve Indexes(s) for Flat
     *
     * @return array
     */
    public function getFlatIndexes() {
        $indexes = array();

        $index = "IDX_" . strtoupper($this->getAttribute()->getAttributeCode());
        $indexes[$index] = array(
            "type" => "index",
            "fields" => array($this->getAttribute()->getAttributeCode())
        );

        return $indexes;
    }

    /**
     * Retrieve Select For Flat Attribute update
     *
     * @param int $store
     * @return Varien_Db_Select|null
     */
    public function getFlatUpdateSelect($store) {
        return Mage::getResourceModel("eav/entity_attribute")
                        ->getFlatUpdateSelect($this->getAttribute(), $store);
    }

}
