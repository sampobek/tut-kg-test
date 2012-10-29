<?php

class Application_Model_Ads extends Zend_Db_Table_Abstract
{
    protected $_name = 'ads';
    
    public function addAd($data = array())
    {
        return $this->insert($data);
    }
    public function getAds($category, $subcategory = false)
     {
        if($subcategory)
        {
            $category = $subcategory;
            $cat = "subcategory";
        }
        else
        {
            $cat = "category";
        }
         $rows = $this->select()
                 ->where($cat.' = ?', $category);
         //echo "query = ".$rows->__toString()."</br>";
         return $this->fetchAll($rows);
     }
     public function getAd($id)
     {
         $rows = $this->select()
                 ->where('id = ?', $id);
         return $this->fetchRow($rows);
     }
}

