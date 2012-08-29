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
         
         $password = new Zend_Form_Element_Text('qwe');
         $password->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true);
         
         $submit = new Zend_Form_Element_Submit("submit");
         $submit->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description');
         
         $this->addElements(array($title, $password, $submit));
    }


}

