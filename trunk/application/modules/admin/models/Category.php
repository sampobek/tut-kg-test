<?php

class Admin_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'category';
    
    public function getCategories()
     {
         $rows =  $this->select();
         return $this->fetchAll($rows);
     }
}

