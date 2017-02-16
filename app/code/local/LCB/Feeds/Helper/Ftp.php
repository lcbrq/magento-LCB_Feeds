<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2017 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_Helper_Ftp extends Mage_Core_Helper_Abstract {

    protected $_hostname;
    protected $_username;
    protected $_password;
    protected $_path;

    /**
     * Set ftp hostname
     * 
     * @param string $hostname
     */
    public function setHostname($hostname)
    {
        $this->_hostname = $hostname;
    }

    /**
     * Set ftp username
     * 
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * Set ftp password
     * 
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * Set ftp path
     * 
     * @param string $path
     */
    public function setPath($path)
    {
        $this->_path = $path;
    }

    /**
     * Upload target file to specified ftp
     * 
     * @param string $file filepath
     * @return boolean
     */
    function upload($file)
    {

        $ftp = new Varien_Io_Ftp();

        try {
            $ftp->open(
                    array(
                        'host' => $this->_hostname,
                        'user' => $this->_username,
                        'password' => $this->_password,
                    )
            );
        } catch (Exception $e) {
            return false;
        }

        try {
            $fopen = fopen($file, 'r');
            $ftp->write($this->_path . basename($file), $fopen);
            $ftp->close();
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

}
