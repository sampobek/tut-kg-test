<?php

class Admin_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = 'category';
    
    public function getCategories()
     {
         $rows =  $this->select()
                 ->where('parent = ?', 0);
         return $this->fetchAll($rows);
     }
     public function getSubcategory($category)
     {
         $rows = $this->select()
                 ->where('parent = ?', $category);
         return $this->fetchAll($rows);
     }
}

