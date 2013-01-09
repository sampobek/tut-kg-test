<?php

class Application_Model_Messages extends Zend_Db_Table_Abstract
{
    protected $_name = 'messages';
    protected $_name2 = 'ads';
    protected $_name3 = 'users';


    public function addMessage($data = array())
    {
        return $this->insert($data);
    }
    public function getMessages($id, $user = false)
     {
         $rows = $this->select()
                 ->where('messages.ad_id = ?', $id)
                 ->where('messages.from = ?', $user)
                 ->orWhere('messages.to = ?', $user)
                 ->where('messages.ad_id = ?', $id);
         //echo "query = ".$rows->__toString()."</br>";
         return $this->fetchAll($rows);
     }
     public function getMessageTitles($id, $from = false)
     {
        if($from)
        {
            $to = "from";
            $equal = "<>";
        }
        else
        {
            $to = "to";
            $equal = "=";
        }
         $rows = $this->select()
                 ->setIntegrityCheck(false)
                 ->from(array('mes' => 'messages'))
                 ->joinInner(array($this->_name2),'mes.ad_id = ads.id')
                 ->joinInner(array($this->_name3),'mes.from = users.id')
                 ->where('ads.email '.$equal.' ?', $id)
                 ->where('mes.'.$to.' = ?', $id)
                 ->group('ad_id')
                 ->group('from');
         return $this->fetchAll($rows);
     }
}
