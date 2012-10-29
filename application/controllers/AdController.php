<?php

class AdController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = $this->_request->getParam("id"); 
        
        $ad = new Application_Model_Ads();
        $getad = $ad->getAd($id);
        $this->view->ad = $getad;
        
        $this->view->headTitle($getad->title);
    }

    public function newAction()
    {
        $this->view->headTitle("Новое объявление");
        
        $new_ad = new Application_Form_New();
        $new_ad->submit->setLabel("Опубликовать");
        $this->view->new = $new_ad;
        
        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            if($new_ad->isValid($formData))
            {
                $title = $new_ad->getValue('title');
                $description = $new_ad->getValue('description');
                $category = $new_ad->getValue('category');
                $subcategory = $new_ad->getValue('subcategory');
                $name = $new_ad->getValue('name');
                $phone = $new_ad->getValue('phone');
                $email = $new_ad->getValue('email');
                
                $data = array(
                    "title" => $title,
                    "category" => $category,
                    "subcategory" => $subcategory,
                    "description" => nl2br($description),
                    "name" => $name,
                    "phone" => $phone,
                    "email" => $email
                );
                $addAd = new Application_Model_Ads();
                $addAd->addAd($data);
                $this->_helper->redirector('index', 'index');
            }
            else
            {
                $new_ad->populate($formData);
            }
        }
    }

    public function listAction()
    {
        $category = $this->_request->getParam("category");
        $subcategory = $this->_request->getParam("subcategory");
        
        if(isset($subcategory))
        {
            $ads = new Application_Model_Ads();
            $adlist = $ads->getAds($category, $subcategory);
            $this->view->adlist = $adlist;
        }
        elseif(isset($category))
        {
            $subcategorylist = new Application_Model_Category();
            $subcat_list = $subcategorylist->getCategories($category);
            $this->view->subcat_list = $subcat_list;
            
            $ads = new Application_Model_Ads();
            $adlist = $ads->getAds($category);
            $this->view->adlist = $adlist;
        }
        
        
    }

    public function getcategoryAction()
    {
        $category = $this->_request->getParam("category_id");
        if(isset($category))
        {
            $subcategory = new Application_Model_Category();
            $subcat_list = $subcategory->getCategories($category);
            foreach($subcat_list as $value)
            {
                $data[$value["id"]] = $value["name"];
            }
            $this->_helper->json($data);
        }
    }
}







