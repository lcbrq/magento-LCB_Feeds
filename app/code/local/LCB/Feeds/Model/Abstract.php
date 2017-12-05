<?php

class LCB_Feeds_Model_Abstract {

    /**
     * @var Varien_Cache_Core
     */
    protected $_cache;
    
    public function __construct()
    {
        $this->_cache = Mage::app()->getCache();
    }
    
    /**
     * Upload file to target ftp
     * 
     * @param array $args
     * @param string $file absolute path
     * @return void
     */
    public function ftpUpload($args, $file)
    {

        $ftp = Mage::helper('lcb_feeds/ftp');

        if (!isset($args['hostname']) || !isset($args['username']) || !isset($args['password']) || !$file) {
            Mage::throwException($ftp->__("Invalid connection params specified"));
        }

        $ftp->setHostname($args['hostname']);
        $ftp->setUsername($args['username']);
        $ftp->setPassword($args['password']);
        if (isset($args['path'])) {
            $ftp->setPath($args['path']);
        }
        $ftp->upload($file);
    }
    
    /**
     * Load XML from cache
     * 
     * @return boolean
     */
    public function getXml($type)
    {
        if($xml = $this->_cache->load("feed_$type")){
            return $xml;
        }
        
        return false;
    }
    
    /**
     * Save XML to cache
     * 
     * @param string $type
     * @param DOMDocument $doc
     * @return string $xml
     */
    public function saveXml($type, $doc)
    {        
        $xml = $doc->saveXml();
        $this->_cache->save($xml, "feed_$type", array("feed_$type"), 3600);
        return $xml;
    }

}
