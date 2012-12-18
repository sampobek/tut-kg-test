<?php

class Application_Model_Messages extends Zend_Db_Table_Abstract
{
    protected $_name = 'messages';
    
    public function addMessage($data = array())
    {
        return $this->insert($data);
    }
    public function getMessages($id, $from = false)
     {
        if($from)
        {
            $to = "from";
        }
        else
        {
            $to = "to";
        }
         $rows = $this->select()
                 ->where('messages.'.$to.' = ?', $id);
         //echo "query = ".$rows->__toString()."</br>";
         return $this->fetchAll($rows);
     }
}
