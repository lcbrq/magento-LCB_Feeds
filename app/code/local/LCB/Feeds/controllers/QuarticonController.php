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
        $xml = Mage::getModel('lcb_feeds/quarticon')->generate();
        $this->getResponse()->setBody($xml);
        $this->getResponse()->setHeader('Content-type', 'text/xml');
    }

}
