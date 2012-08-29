<?php

class AdController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function newAction()
    {
        $new_ad = new Application_Form_New();
        $new_ad->submit->setLabel("Опубликовать");
        $this->view->new = $new_ad;
    }

    public function listAction()
    {
        // action body
    }


}





