<?php

class Application_Form_Signup extends Zend_Form
{

    public function init()
    {
        $this->setName('signup');
        
        $email_validator = new Zend_Validate_EmailAddress();
        $email_validator->setMessages(
                Array(
                    'emailAddressInvalidFormat'=> 'Пожалуйста заполните это поле',
                    'emailAddressInvalid'=> 'sdf',
                    'emailAddressInvalidHostname' => 'sdghgfhf',
                    'emailAddressInvalidMxRecord' => 'sdfghfghf',
                    'emailAddressInvalidSegment' => 'dfdfghfghf',
                    'emailAddressDotAtom' => 'dfgfhfgg',
                    'emailAddressQuotedString' => 'dffghfg',
                    'emailAddressInvalidLocalPart' => 'dfghfghfg',
                    'emailAddressLengthExceeded' => 'dfgdhfghg',
                    ));
        
        $empty = new Zend_Validate_NotEmpty();
        $empty->setMessage('Пожалуйста заполните это поле');
        
         $email = new Zend_Form_Element_Text('email');
         $email->removeDecorator('Label')
                 ->removeDecorator('HtmlTag')
                 ->removeDecorator('DtDdWrapper')
                 ->removeDecorator('Description')
                 ->setRequired(true)
                 ->addFilter('StripTags')
                 ->addFilter('StringTrim')
                 ->addValidator($email_validator)
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
         
         $this->addElements(array($email, $password, $password_confirm, $submit));
    }


}

