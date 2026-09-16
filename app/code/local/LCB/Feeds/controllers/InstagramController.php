<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_InstagramController extends Mage_Core_Controller_Front_Action
{
    /**
     * Render Instagram catalog feed (reuses the Google Shopping feed format)
     *
     * @return void
     */
    public function indexAction()
    {
        $xml = Mage::getModel('lcb_feeds/google')->generate();
        $this->getResponse()->setHeader('Content-Type', 'text/xml; charset=utf-8')->setBody($xml);
    }
}
