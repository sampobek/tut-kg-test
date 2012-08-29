<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';
    
    public function addUser($data = array())
    {
        return $this->insert($data);
    }
    public function updateUser($email, $data = array())
    {
        $this->update($data, "user_email = "."{$email}");
    }
    public function checkData($column,$data)
     {
         $select = $this->select()->where($column.' = ?', $data);
         $row = $this->fetchRow($select);
         return $row[$column];
     }
}

