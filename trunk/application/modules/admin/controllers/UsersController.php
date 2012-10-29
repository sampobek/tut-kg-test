<?php

class Admin_UsersController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->users = "selected";
    }

    public function indexAction()
    {
        $users = new Admin_Model_Users();
        $get_users = $users->getUsers();
        $this->view->get_users = $get_users;
    }


}

