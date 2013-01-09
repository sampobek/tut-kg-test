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
        
        $category_id = $this->_request->getParam("category");
        if(isset($category_id))
        {
            $subcat = $category->getSubcategory($category_id);
            $this->view->subcat = $subcat;
        }
        
        $subcategory_id = $this->_request->getParam("subcategory");
        if(isset($subcategory_id))
        {
            $subsubcat = $category->getSubcategory($subcategory_id);
            $this->view->subsubcat = $subsubcat;
        }
    }


}

