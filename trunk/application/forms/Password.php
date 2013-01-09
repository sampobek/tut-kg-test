<?php

class Application_Form_Password extends Zend_Form
{

    public function init()
    {
        $this->setName('password');
        
        $empty = new Zend_Validate_NotEmpty();
        $empty->setMessage('Пожалуйста заполните это поле');
        
        $old_password = new Zend_Form_Element_Password("old_password");
         $old_password->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addValidator($empty);
         
        $password = new Zend_Form_Element_Password('password');
         $password->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addValidator($empty);
         
         $password_confirm = new Zend_Form_Element_Password("password_confirm");
         $password_confirm->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addValidator($empty);
         
         $submit = new Zend_Form_Element_Submit("submit");
         $submit->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description');
         
         $this->addElements(array($old_password, $password, $password_confirm, $submit));
    }
}

