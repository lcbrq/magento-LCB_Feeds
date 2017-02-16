<?php

class LCB_Feeds_Model_Abstract {

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

}
