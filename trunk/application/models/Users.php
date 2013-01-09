<?php

class Application_Model_Users extends Zend_Db_Table_Abstract
{
    protected $_name = 'users';
    
    public function addUser($data = array())
    {
        $check = $this->checkData("email",$data["email"]);
        if(!$check)
        {
            return $this->insert($data);
        }
        else
        {
            return $check;
        }
    }
    public function updateUser($id, $data = array())
    {
        $this->update($data, "id = ".$id);
    }
    public function checkData($column,$data)
     {
         $select = $this->select()->where($column.' = ?', $data);
         $row = $this->fetchRow($select);
         return $row['id'];
     }
}

