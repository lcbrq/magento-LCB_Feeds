<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2018 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_QuarticonController extends Mage_Core_Controller_Front_Action
{

    /**
     * View Quarticon feed action
     */
    public function indexAction()
    {
        
        try {
            ini_set('memory_limit', '1024M');
            ini_set('max_execution_time', 240);
        } catch (\Exception $e) {
            
        }
        
        $xml = Mage::getModel('lcb_feeds/quarticon')->generate();
        $this->getResponse()->setBody($xml);
        $this->getResponse()->setHeader('Content-type', 'text/xml');
    }

}
