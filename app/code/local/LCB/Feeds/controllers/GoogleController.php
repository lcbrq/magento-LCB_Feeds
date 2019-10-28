<?php

/*
 * @category 	LCB
 * @package 	LCB_Feeds
 * @copyright 	Copyright (c) 2015 LeftCurlyBracket (http://www.leftcurlybracket.com/)
 */

class LCB_Feeds_GoogleController extends Mage_Core_Controller_Front_Action {
    
    CONST CONDITION = 'new';
    CONST CATEGORY = '188';

    public $product;
    
    public function indexAction() {
        header("Content-type: text/xml; charset=utf-8");
        Mage::getModel('lcb_feeds/google')->generate();
    }

}
