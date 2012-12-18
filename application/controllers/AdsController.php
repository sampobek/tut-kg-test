<?php

class AdsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = $this->_request->getParam("id"); 
        if(isset($id))
        {
            $ad = new Application_Model_Ads();
            $getad = $ad->getAd($id);
            $this->view->ad = $getad;
        
            $this->view->headTitle($getad->title);
        }        
    }

    public function newAction()
    {
        $this->view->headTitle("Новое объявление");
        
        $new_ad = new Application_Form_New();
        $new_ad->submit->setLabel("Опубликовать");
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $new_ad->email->setValue(Zend_Auth::getInstance()->getIdentity()->email);
        }        
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
                            'email' => $email
                        );
                
                        $user = new Application_Model_Users();
                        $user_id = $user->addUser($data);
                        
                $data = array(
                    "title" => $title,
                    "category" => $category,
                    "subcategory" => $subcategory,
                    "description" => nl2br($description),
                    "name" => $name,
                    "phone" => $phone,
                    "email" => $user_id
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
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->view->id = Zend_Auth::getInstance()->getIdentity()->id;
        } 
        
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
            if($subcat_list!="")foreach($subcat_list as $value)
            {
                $data[$value["id"]] = $value["name"];
            }
            else
            {
                $data[45] = "pusto";
            }
            $data[0] = $subcat_list;
            $this->_helper->json($data);
        }
        
    }

    public function myAction()
    {
        $this->view->headTitle("Мои объявления");
    }


}









