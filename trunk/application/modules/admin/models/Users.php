<?php

class Admin_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';
    
    public function getUsers()
     {
         $rows = $this->select();
         return $this->fetchAll($rows);
     }
}

