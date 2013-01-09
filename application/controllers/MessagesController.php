<?php

class MessagesController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $functions = new Application_Model_Additional();
        $my_id = $functions->id();
        $this->view->myid = $my_id;
        $list  = new Application_Model_Messages();
        $this->view->headTitle("Мои сообщения");
        
        $ad_id = $this->_request->getParam("id");
        $user = $this->_request->getParam("user");
        
        if(isset($ad_id,$user)&&$ad_id!=""&&$user!=""){
            $this->view->message_list = $list->getMessages($ad_id, $user);
            $form = new Application_Form_Message();
            $form->submit->setLabel("Отправить");
            if(Zend_Auth::getInstance()->hasIdentity())
            {
                $form->email->setValue(Zend_Auth::getInstance()->getIdentity()->email);
                $form->email->setAttrib("style", "display:none");
            }
            $this->view->form = $form;
        }
        $this->view->messages = $list->getMessageTitles($my_id);
        
        if($this->getRequest()->isPost())
        {
            $id = $this->_request->getParam("id");
            $user_to = $this->_request->getParam("user");
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData))
            {
                $email = $form->getValue('email');
                $description = $form->getValue('description');
                
                $data = array('email' => $email);
                $user = new Application_Model_Users();
                $user_id = $user->addUser($data);
                $data = array(
                    "ad_id" => $id,
                    "from" => $user_id,
                    "to" => $user_to,
                    "message" => nl2br($description),
                    "date" => date("YmdHis"),
                    "read" => "0"
                );
                $addAd = new Application_Model_Messages();
                $addAd->addMessage($data);
            }
            else
            {
                $form->populate($formData);
            }
        }
    }

    public function myAction()
    {
        $functions = new Application_Model_Additional();
        
        $id = $functions->id();
        $this->view->myid = $id;
        
        $list  = new Application_Model_Messages();
        $this->view->headTitle("Мои сообщения");
        
        $ad_id = $this->_request->getParam("id");
        if(isset($ad_id)&&$ad_id!=""){
            $this->view->message_list = $list->getMessages($ad_id, $id);
            $form = new Application_Form_Message();
            $form->submit->setLabel("Отправить");
            if($functions->id())
            {
                $form->email->setValue(Zend_Auth::getInstance()->getIdentity()->email);
                $form->email->setAttrib("style", "display:none");
            }
            $this->view->form = $form;
        }
                
        $this->view->messages = $list->getMessageTitles($id,1);
        
        if($this->getRequest()->isPost())
        {
            $id = $this->_request->getParam("id");
            $ad = new Application_Model_Ads();
            $getad = $ad->getAd($id);
            
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData))
            {
                $email = $form->getValue('email');
                $description = $form->getValue('description');
                
                $data = array('email' => $email);
                
                $user = new Application_Model_Users();
                $user_id = $user->addUser($data);
                
                $data = array(
                    "ad_id" => $id,
                    "from" => $user_id,
                    "to" => $getad->email,
                    "message" => nl2br($description),
                    "date" => date("YmdHis"),
                    "read" => "0"
                );
                $addAd = new Application_Model_Messages();
                $addAd->addMessage($data);
            }
            else
            {
                $form->populate($formData);
            }
        }
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
                $form->email->setAttrib("style", "display:none");
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
                    "date" => date("YmdHis"),
                    "read" => "0"
                );
                $addAd = new Application_Model_Messages();
                $addAd->addMessage($data);
                $this->_helper->redirector('index', 'index');
            }
            else
            {
                $form->populate($formData);
            }
        }
    }


}
