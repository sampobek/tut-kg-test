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
                $signup_date = date("Y-m-d H:i:s");
             
                $data = array(
                    'user_email' => $email,
                    'user_password' => md5($password),
                    'user_signup_date' => $signup_date,
                    
                );
                $user = new Application_Model_Users();
                $user_id = $user->addUser($data);
                $this->_helper->redirector('signin', 'account');
            }
            else
            {
                $form->populate($formData);
            }
        }
        
    }

    public function signinAction()
    {
        // проверяем, авторизирован ли пользователь
        if (Zend_Auth::getInstance()->hasIdentity())
        {
            // если да, то делаем редирект, чтобы исключить многократную авторизацию
            $this->_helper->redirector('index', 'account');
        }
        $signin = new Application_Form_Signin();
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
                  
                $authAdapter->setIdentityColumn('user_email');
            
                // указываем таблицу, где необходимо искать данные о пользователях
                // колонку, где искать имена пользователей,
                // а также колонку, где хранятся пароли
                $authAdapter->setCredentialColumn('user_password');
            
            
                // подставляем полученные данные из формы
                $authAdapter->setIdentity($username)
                ->setCredential($password);
            
                // получаем экземпляр Zend_Auth
                $auth = Zend_Auth::getInstance();
            
                // делаем попытку авторизировать пользователя
                $result = $auth->authenticate($authAdapter);
            
                // если авторизация прошла успешно
                if ($result->isValid()) {
                    // используем адаптер для извлечения оставшихся данных о пользователе
                    $identity = $authAdapter->getResultRowObject();
                
                    // получаем доступ к хранилищу данных Zend
                    $authStorage = $auth->getStorage();
                
                    // помещаем туда информацию о пользователе,
                    // чтобы иметь к ним доступ при конфигурировании Acl
                    $authStorage->write($identity);
                
                    $user = new Application_Model_Users();
                    $user_id = $user->checkData("user_email", $username);
                    $data = array(
                        "user_last_date" => date("Y-m-d H:i:s"),
                        "user_last_ip" => $_SERVER['REMOTE_ADDR']);
                    $user->updateUser($user_id, $data);
                
                    // Используем библиотечный helper для редиректа
                    // на controller = index, action = index
                    $this->_helper->redirector('index', 'index');
                } 
                else {
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
	    $this->_helper->redirector('index', 'index');
    }


}







