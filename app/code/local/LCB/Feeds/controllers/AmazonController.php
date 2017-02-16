<?php

/*
 * @category    LCB
 * @package     LCB_Feeds
 * @copyright   Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_AmazonController extends Mage_Core_Controller_Front_Action {

    public function indexAction()
    {
        Mage::getModel('lcb_feeds/amazon')->export("Amazon.csv");
    }

}
