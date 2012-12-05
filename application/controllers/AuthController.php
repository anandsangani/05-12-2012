<?php

require_once 'Zend/Controller/Action.php';
require_once 'Zend/Form.php';
require_once 'Zend/Auth.php';
require_once 'Zend/Auth/Storage/Session.php';
require_once 'Zend/Auth/Adapter/DbTable.php';
require_once '/../application/models/User.php';
require_once '/../application/forms/LoginForm.php';
require_once '/../application/forms/RegistrationForm.php';

class AuthController extends Zend_Controller_Action
{
 
    /*public function loginAction()
    {
        $db = $this->_getParam('db');
 
        $loginForm = new Default_Form_Auth_Login();
 
        if ($loginForm->isValid($_POST)) {
 
            $adapter = new Zend_Auth_Adapter_DbTable(
                $db,
                'users',
                'username',
                'password',
                'MD5(CONCAT(?, password_salt))'
                );
 
            $adapter->setIdentity($loginForm->getValue('username'));
            $adapter->setCredential($loginForm->getValue('password'));
 
            $auth   = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter);
 
            if ($result->isValid()) {
                $this->_helper->FlashMessenger('Successful Login');
                $this->_redirect('/');
                return;
            }
 
        }
 
        $this->view->loginForm = $loginForm;
 
    }
	
	public function identifyAction()
	{
		if ($this->getRequest()->isPost()) {
			$formData = $this->_getFormData();
	if (empty($formData['username'])|| empty($formData['password'])) {
		$this->_flashMessage('Empty username or password.');
		}
	else {
	// do the authentication
		$authAdapter = $this->_getAuthAdapter($formData);
		$auth = Zend_Auth::getInstance();
		$result = $auth->authenticate($authAdapter);
		if (!$result->isValid()) {
			$this->_flashMessage('Login failed');
			}
		else {
		$data = $authAdapter->getResultRowObject(null,'password');
		$auth->getStorage()->write($data);
		$this->_redirect($this->_redirectUrl);
		return;
			}
		}
	}
	$this->_redirect('/auth/login');
	}
	
	protected function _getAuthAdapter($formData)
	{
		$dbAdapter = Zend_Registry::get('db');
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		$authAdapter->setTableName('users')
		->setIdentityColumn('username')
		->setCredentialColumn('password')
		->setCredentialTreatment('SHA1(?)');
		// get "salt" for better security
		$config = Zend_Registry::get('config');
		$salt = $config->auth->salt;
		$password = $salt.$formData['password'];
		$authAdapter->setIdentity($formData['username']);
		$authAdapter->setCredential($password);
		return $authAdapter;
	}
 
	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		$this->_redirect('/');
	}
*/
	public function indexAction()
	{
		if (null === Zend_Auth::getInstance()->getIdentity()) {
		$this->_forward('form');
		}
	}
	public function formAction()
	{
		$form = new LoginForm('/../auth/form');
		$this->view->formResponse = '';
		if ($this->_request->isPost()) {
		if ($form->isValid($_POST)) 
		{
			$values = $form->getValues();
			return $this->_forward('login');
			}
		else {
			/*$this->view->formResponse = '
			Sorry, there was a problem with your submission.
			Please check the following:';*/
			
			$this->view->form = $form;
			return $this->render('form');
			}
		}
		$this->view->form = $form;
	}

    /*public function homeAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $data = $storage->read();
        if(!$data){
            $this->_redirect('auth/login');
        }
        $this->view->username = $data->username;                
    }
    
    public function loginAction()
    {
        $user = new User();
        $form = new LoginForm('');
        $this->view->form = $form;
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                $auth = Zend_Auth::getInstance();
                $authAdapter = new Zend_Auth_Adapter_DbTable($user->getAdapter(),'user');
                $authAdapter->setIdentityColumn('username')
                            ->setCredentialColumn('password');
                $authAdapter->setIdentity($data['username'])
                            ->setCredential($data['password']);
                $result = $auth->authenticate($authAdapter);
                if($result->isValid()){
                    $storage = new Zend_Auth_Storage_Session();
                    $storage->write($authAdapter->getResultRowObject());
                    $this->_redirect('auth/home');
                } else {
                    $this->view->errorMessage = "Invalid username or password. Please try again.";
                }         
            }
        }
    }
    public function signupAction()
    {
        $user = new User();
        $form = new RegistrationForm();
        $this->view->form=$form;
        if($this->getRequest()->isPost()){
            if($form->isValid($_POST)){
                $data = $form->getValues();
                if($user->checkUnique($data['username'])){
                    $this->view->errorMessage = "Name already taken. Please choose another one.";
                    return;
                }
                $user->insert($data);
                $this->_redirect('auth/login');
            }
        }
    }
    
    public function logoutAction()
    {
        $storage = new Zend_Auth_Storage_Session();
        $storage->clear();
        $this->_redirect('auth/login');
    }*/
}

?>