<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $category = new Application_Model_Category();
        $cat_list = $category->getMainCat();
        $this->view->cat_list = $cat_list;
    }


}

