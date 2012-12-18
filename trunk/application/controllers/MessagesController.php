<?php

class MessagesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $id = Zend_Auth::getInstance()->getIdentity()->id;
        $this->view->headTitle("Мои сообщения");
        
        $list  = new Application_Model_Messages();
        $meslist = $list->getMessages($id);
        $this->view->meslist = $meslist;
    }

    public function myAction()
    {
        $id = Zend_Auth::getInstance()->getIdentity()->id;
        $this->view->headTitle("Мои сообщения");
        
        $list  = new Application_Model_Messages();
        $meslist = $list->getMessages($id, 1);
        $this->view->meslist = $meslist;
    }

    public function newAction()
    {
        $this->view->headTitle("Новое сообщение");
        
        $id = $this->_request->getParam("id"); 
        if(isset($id))
        {
            $ad = new Application_Model_Ads();
            $getad = $ad->getAd($id);
            $this->view->ad = $getad;
        
            $this->view->headTitle($getad->title);
            
            $form = new Application_Form_Message();
            $form->submit->setLabel("Отправить");
            if(Zend_Auth::getInstance()->hasIdentity())
            {
                $form->email->setValue(Zend_Auth::getInstance()->getIdentity()->email);
            }
            $this->view->form = $form;
        }
        
        if($this->getRequest()->isPost())
        {
            $id = $this->_request->getParam("id");
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData))
            {
                $email = $form->getValue('email');
                $description = $form->getValue('description');
                
                $data = array(
                            'email' => $email
                        );
                        $user = new Application_Model_Users();
                        $user_id = $user->addUser($data);
                        
                $data = array(
                    "ad_id" => $id,
                    "from" => $user_id,
                    "to" => $getad->email,
                    "message" => nl2br($description),
                    "date" => date("Y-m-d H:i:s"),
                    "read" => "0"
                );
                $addAd = new Application_Model_Messages();
                $addAd->addMessage($data);
                //$this->_helper->redirector('index', 'index');
            }
            else
            {
                $new_ad->populate($formData);
            }
        }
    }


}
