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
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 240);

        $xml = Mage::getModel('lcb_feeds/quarticon')->generate();
        $this->getResponse()->setHeader('Content-Type', 'text/xml; charset=utf-8')->setBody($xml);
    }
}
