<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'category';
    
    public function getMainCat()
     {
         $rows =  $this->select()
                 ->setIntegrityCheck(false)
                 ->where('parent = ?', 0);
         return $this->fetchAll($rows);
     }

}

