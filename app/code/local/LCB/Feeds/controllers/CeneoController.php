<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_CeneoController extends Mage_Core_Controller_Front_Action {

    /**
     * Render xml
     * 
     * @return void
     */
    public function indexAction()
    {
        header("Content-type: text/xml; charset=utf-8");
        Mage::getModel('lcb_feeds/ceneo')->generate();
    }

}
