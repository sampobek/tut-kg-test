<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'category';
    
    public function getCategories($parent, $inverse = false)
     {
        ($inverse)? $sym = '<>': $sym = '=';
         $rows =  $this->select()
                 ->where('parent '.$sym.' ?', $parent);
         //echo "query = ".$rows->__toString()."</br>";
         return $this->fetchAll($rows);
     }

}

