<?php

class AccountController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function signupAction()
    {
        $this->view->headTitle("Регистрация");
        
        $form = new Application_Form_Signup();
        $form->submit->setLabel("Зарегистрироваться");
        $this->view->signup = $form;
        
        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData))
            {
                $email = $form->getValue('email');
                $password = $form->getValue('password');
                $password_confirm = $form->getValue('password_confirm');
                
                $email_validate = new Zend_Validate_EmailAddress();
                if($email_validate->isValid($email))
                {
                    if($password == $password_confirm)
                    {
                        $signup_date = date("YmdHis");
             
                        $data = array(
                            'email' => $email,
                            'password' => md5($password),
                            'signup_date' => $signup_date,
                        );
                        $user = new Application_Model_Users();
                        $user_id = $user->addUser($data);
                        if($user_id)
                        {
                            $this->_helper->redirector('signin', 'account');
                        }
                        else
                        {
                            echo "Такой пользователь существует";
                        }
                    }
                    else
                    {
                        $form->password->setValue($password);
                        $this->view->pass_error = "Пароли не совпадают";
                    }
                }
                else
                {
                    $this->view->email_error = "Неправильный email";
                }
            }
            else
            {
                $form->populate($formData);
            }
        }
        
    }

    public function signinAction()
    {
        $this->view->headTitle("Войти");
        
        // проверяем, авторизирован ли пользователь
        if (Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_helper->redirector('index', 'account');
            // если да, то делаем редирект, чтобы исключить многократную авторизацию
        }
        $signin = new Application_Form_Signin();
        //$redirect = $_SERVER["HTTP_REFERER"];
        //$signin->setAction("?redirect=".$redirect);
        $signin->submit->setLabel("Войти");
        $this->view->signin = $signin;
        
        if ($this->getRequest()->isPost()) 
        {
            // Принимаем его
            $formData = $this->getRequest()->getPost();
        
            // Если форма заполнена верно
            if ($signin->isValid($formData))
            {
                // Получаем адаптер подключения к базе данных
                $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
                
                // получаем введённые данные
                $username = $this->getRequest()->getPost('email');
                $password = md5($this->getRequest()->getPost('password'));
                
                $authAdapter->setTableName('users');
                  
                $authAdapter->setIdentityColumn('email');
            
                // указываем таблицу, где необходимо искать данные о пользователях
                // колонку, где искать имена пользователей,
                // а также колонку, где хранятся пароли
                $authAdapter->setCredentialColumn('password');
            
            
                // подставляем полученные данные из формы
                $authAdapter->setIdentity($username)
                ->setCredential($password);
            
                // получаем экземпляр Zend_Auth
                $auth = Zend_Auth::getInstance();
            
                // делаем попытку авторизировать пользователя
                $result = $auth->authenticate($authAdapter);
            
                // если авторизация прошла успешно
                if ($result->isValid()) 
                {
                    // используем адаптер для извлечения оставшихся данных о пользователе
                    $identity = $authAdapter->getResultRowObject();
                
                    // получаем доступ к хранилищу данных Zend
                    $authStorage = $auth->getStorage();
                
                    // помещаем туда информацию о пользователе,
                    // чтобы иметь к ним доступ при конфигурировании Acl
                    $authStorage->write($identity);
                
                    $user = new Application_Model_Users();
                    $user_id = $user->checkData("email", $username);
                    $data = array(
                        "signin_date" => date("YmdHis"),
                        "ip" => $_SERVER['REMOTE_ADDR']);
                    $user->updateUser($user_id, $data);
                
                    // Используем библиотечный helper для редиректа
                    // на controller = index, action = index
                    $redirect = $this->_request->getParam("redirect");
                    if(isset($redirect)&&$redirect!="")
                    {
                        header("Location: ".$redirect);
                    }
                    else
                    {
                        $this->_helper->redirector('index', 'index');
                    }
                } 
                else 
                {
                    $signin->populate($formData);
                    $this->view->errMessage = 'Неправильный email и/или пароль';
                }
            }
        }  
    
    }

    public function signoutAction()
    {
        // уничтожаем информацию об авторизации пользователя
	Zend_Auth::getInstance()->clearIdentity();
	// и отправляем его на главную
	$redirect = $_SERVER["HTTP_REFERER"];
        header("Location: ".$redirect);
    }

    public function settingsAction()
    {
        $this->view->headTitle("Настройки аккаунта");
        
        $my_id = Zend_Auth::getInstance()->getIdentity()->id;
        
        $emailform = new Application_Form_Email();
        $emailform->submit->setLabel("Сохранить");
        $this->view->email = $emailform;
        
        $passwordform = new Application_Form_Password();
        $passwordform->submit->setLabel("Сохранить");
        $this->view->password = $passwordform;
        
        if($this->getRequest()->isPost())
        {
            $formData = $this->getRequest()->getPost();
            if($emailform->isValid($formData))
            {
                $email = $emailform->getValue('email');
                
                $email_validate = new Zend_Validate_EmailAddress();
                if($email_validate->isValid($email))
                {
                    $data = array(
                            'email' => $email
                        );
                        $user = new Application_Model_Users();
                        $user_id = $user->updateUser($my_id,$data);
                        if($user_id)
                        {
                            $this->_helper->redirector('signin', 'account');
                        }
                        else
                        {
                            echo "Такой пользователь существует";
                        }
                }
                else
                {
                    $this->view->email_error = "Неправильный email";
                }
            }
            else if($passwordform->isValid($formData))
            {
                $password = $passwordform->getValue('password');
                $password_confirm = $passwordform->getValue('password_confirm');
                
                if($password == $password_confirm)
                    {
                        $data = array(
                            'password' => md5($password)
                        );
                        $user = new Application_Model_Users();
                        $user_id = $user->updateUser($my_id,$data);
                        if($user_id)
                        {
                            $this->_helper->redirector('signin', 'account');
                        }
                        else
                        {
                            echo "Такой пользователь существует";
                        }
                    }
                    else
                    {
                        $passwordform->password->setValue($password);
                        $this->view->pass_error = "Пароли не совпадают";
                    }
            }
            else
            {
                $emailform->populate($formData);
                $passwordform->populate($formData);
            }
        }
    }

}













