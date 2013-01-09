<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $category = new Application_Model_Category();
        $cat_list = $category->getCategories(0);
        $this->view->cat_list = $cat_list;
    }

    public function addadAction()
    {
        $category = "8";
        $subcategory = "17";
        $url = trim($this->getRequest()->getParam("q"));
        
        if(isset($url)&&$url!="")
        {
            $add = new Application_Model_Ads();            
            echo $add->adding($url, $category, $subcategory);
        }
    }


}



