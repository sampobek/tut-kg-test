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
     public function getAdByUser($id)
     {
         $rows = $this->select()
                 ->where('email = ?', $id);
         return $this->fetchAll($rows);
     } 
     public function getAdsByMessage($id)
     {
         $rows = $this->select()
                 ->where('email = ?', $id)
                 ->where('messages > 0');
         return $this->fetchAll($rows);
     } 
     public function getAll()
     {
         $rows = $this->select();
         return $this->fetchAll($rows);
     } 
     
     public function search($words)
     {
         $rows = $this->select();
         foreach ($words as $word)
         {
             $rows->orwhere('title like ?', '%'.$word.'%');
         }
         //echo "query = ".$rows->__toString()."</br>";
         return $this->fetchAll($rows);         
     }
     public function adding($url, $category, $subcategory)
     {
         $mainfile = file_get_contents($url);
            
            $file = explode('<h1 class="lheight28 offertitle brkword">', $mainfile);
            $file = explode('</h1>', $file[1]);
            $title = $file[0]."</br>";
            
            $file = explode('<p class="marginbott20 lheight20 large marginright40">', $mainfile);
            $file = explode('</p>', $file[1]);
            $description = $file[0]."</br>";
            
            $file = explode('<span class="block brkword lheight16">', $mainfile);
            $file = explode('</span>', $file[1]);
            $name = $file[0]."</br>";
            
            if(isset($title,$description,$name)){
                $data = array(
                    "title" => $title,
                    "category" => $category,
                    "subcategory" => $subcategory,
                    "description" => $description,
                    "name" => $name,
                    "phone" => "+79235".date("His"),
                    "email" => rand(1,3),
                    "active" => "1"
                );
                return $this->insert($data);
            }
            else 
            {
                return "Какая то ошибка";
            }
     }
}


