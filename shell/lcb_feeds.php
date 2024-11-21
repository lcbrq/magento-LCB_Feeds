<?php

require_once 'abstract.php';

/**
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2020 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */
class LCB_Feeds_Shell extends Mage_Shell_Abstract 
{

    /**
     * Generate feeds from command line
     */
    public function run()
    {

        $storeId = $this->getArg('store_id');

        if (!$storeId) {
            $storeId = Mage::app()->getWebsite()->getDefaultGroup()->getDefaultStoreId();
        }
        
        $feedType = $this->getArg('type');
        
        if (in_array($feedType, ['ceneo', 'google'])) {
            Mage::getModel("lcb_feeds/ceneo")->generate();
        }
        
    }
        
    /**
     * Retrieve Usage Help Message
     *
     */
    public function usageHelp()
    {
        return <<<USAGE
Usage:  php -f lcb_feeds.php -- [options]

  -store_id
  -type        

USAGE;
    }


}

$shell = new LCB_Feeds_Shell;
$shell->run();

