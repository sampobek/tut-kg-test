<?php

class Application_Form_Signin extends Zend_Form
{

    public function init()
    {
        $this->setName('signin');

         $email = new Zend_Form_Element_Text('email');
         $email->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim');
         
         $password = new Zend_Form_Element_Password('password');
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
         
         $this->addElements(array($email, $password, $submit));
    }


}

