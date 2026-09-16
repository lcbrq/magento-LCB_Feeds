<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_GoogleController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $xml = Mage::getModel('lcb_feeds/google')->generate();
        $this->getResponse()->setHeader('Content-Type', 'text/xml; charset=utf-8')->setBody($xml);
    }
}
