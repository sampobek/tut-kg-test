<?php

class Application_Form_New extends Zend_Form
{

    public function init()
    {
        $this->setName('new');

         $title = new Zend_Form_Element_Text('title');
         $title->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
         
         $category = new Zend_Form_Element_Select('category');
         $category->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->setAttrib("onchange", "getcategory(); return false;");
         $getcategory = new Application_Model_Category();
         $category->addMultiOption("-1","Выберите категорию");
         $cat_list = $getcategory->getCategories(0);
         foreach($cat_list as $value)
         {
             $category->addMultiOption($value["id"],$value["name"]);
         }
         
         $subcategory = new Zend_Form_Element_Select('subcategory');
         $subcategory->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->setAttrib("style", "visibility: hidden");
         $subcategory->addMultiOption(0,"Нет подкатегории");
         $getsubcategory = new Application_Model_Category();
         $subcat_list = $getsubcategory->getCategories(0,1);
         foreach($subcat_list as $value)
         {
             $subcategory->addMultiOption($value["id"],$value["name"]);
         }
              
         $text = new Zend_Form_Element_Textarea('description');
         $text->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
         
         $name = new Zend_Form_Element_Text('name');
         $name->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
         
         $phone = new Zend_Form_Element_Text('phone');
         $phone->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
         
         $email = new Zend_Form_Element_Text('email');
         $email->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
         
         $submit = new Zend_Form_Element_Submit("submit");
         $submit->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description');
         
         $this->addElements(array($title, $category, $subcategory, $text, $name, $phone, $email, $submit));
    }


}

