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
     * @param string $type
     * @return string
     */
    public function getCacheKey($type)
    {
        if ($limit = Mage::app()->getRequest()->getParam('limit')) {
            $type .= '_limit_' . $limit;
        }

        return 'feed_' . $type;
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
        if($xml = $this->_cache->load($this->getCacheKey($type))) {
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
        $cacheLifetime = Mage::getStoreConfig('lcb_feeds/general/cache_lifetime', Mage::app()->getStore());
        
        if(!$cacheLifetime) {
            $cacheLifetime = 86400; // one day in seconds
        }
        
        $this->_cache->save($xml, $this->getCacheKey($type), array($this->getCacheKey($type)), (int) $cacheLifetime);
        return $xml;
    }

    /**
     * Simplify append child in DOMDocument context
     * 
     * @param DOMDocument $doc
     * @param DOMElement $element
     * @param string $child
     * @param string $content
     * @param array $attributes
     * @param bool $cdata
     * @return void
     */
    public function addChild($doc, $element, $child, $content, $attributes = array(), $cdata = false)
    {
        
        $text = $doc->createTextNode($content);

        if ($cdata) {
            $text = $element->ownerDocument->createCDATASection($content);
        }

        $node = $doc->createElement($child);
        $node->appendChild($text);
        
        foreach($attributes as $name => $value) {
            $node->setAttribute($name, $value);
        }

        $element->appendChild($node);
        
    }

}
