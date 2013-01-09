<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->headTitle("Результаты поиска");
        
        $query = $this->_request->getParam("q");
        $this->view->q = $query;
        
        if(isset($query)&&$query!="")
        {
        
            $search = new Application_Model_Search();
            $result = $search->explodeQuery($query);
        
            $ads = new Application_Model_Ads();
            $this->view->ads = $ads->search($result);
        }
        else
        {
            $this->_helper->redirector('list','ads');
        }
    }


}

