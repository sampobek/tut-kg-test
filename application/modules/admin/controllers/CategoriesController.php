<?php

class Admin_CategoriesController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->categories = "selected";
    }

    public function indexAction()
    {
        $category = new Admin_Model_Category();
        $cat = $category->getCategories();
        $this->view->cat = $cat;
    }


}

