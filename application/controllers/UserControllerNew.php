<?php
require_once 'Zend/Controller/Action.php';
//require_once 'Zend/Db.php';
//require_once 'Zend/Db/Table/Abstract.php';
require_once 'Zend/Db/Adapter/Pdo/Mysql.php';
require_once 'Zend/Auth.php';
require_once 'Zend/Auth/Adapter/DbTable.php';
require_once 'Zend/Registry.php';
require_once 'Zend/Session/Namespace.php';
require_once 'Zend/Form.php';
require_once 'Zend/View/Abstract.php';

class UserController extends Zend_Controller_Action
{
	 /*public function indexAction()
 	{ 
	   $request = $this->getRequest();  
	   $auth		= Zend_Auth::getInstance(); 
		if(!$auth->hasIdentity()){
		  $this->_redirect('/user/register');
		}else{
			 $this->_redirect('/user/userpage');
		}
	 }*/
  
  public function nameAction()
  {
  
    $request = $this->getRequest();
    $this->view->assign('name', $request->getParam('username'));
    $this->view->assign('gender', $request->getParam('gender'));	  
		
    $this->view->assign('title', 'User Name');
  }
  
   public function registerAction()
  {
    $auth		= Zend_Auth::getInstance();
   	
	if($auth->hasIdentity()){
			 $this->_redirect('/user/userpage');
		}
	
	$request = $this->getRequest();
	
	$this->view->assign('action',"process");
	$this->view->assign('title','Member Registration');
	$this->view->assign('label_uname','User Name');	
	$this->view->assign('label_pass','Password');
	$this->view->assign('label_email','Email');
	$this->view->assign('label_find_us','How did you find us?');
	$this->view->assign('label_submit','Register');		
	$this->view->assign('description','Please enter this form completely:');
	
	$ns = new Zend_Session_Namespace('Zend1');
			
	if(!isset($ns->yourLoginRequest)){
		$ns->yourLoginRequest = 1;
	}else{
		$ns->yourLoginRequest++;
	}
	
	$ns->setExpirationSeconds(60);
	 
	$this->view->assign('request', $ns->yourLoginRequest);
	$this->view->assign('action_login', $request->getBaseURL()."/user/auth");  
	$this->view->assign('title_login', 'Existing Users:');
	$this->view->assign('username_login', 'User Name');	
	$this->view->assign('password_login', 'Password');
	
  }
   public function processAction()
  {
	require_once 'Zend/Loader/Autoloader.php';
	$loader = Zend_Loader_Autoloader::getInstance();
	
	require_once('Zend/Db/Adapter/Pdo/Mysql.php');
	
	$params = array('host' 	=>'localhost',
                'username'	=>'root',
				'password'  =>'',
				'dbname'	=>'zend'
               );
	$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
	$request = $this->getRequest();

   	$data = array('username' => $request->getParam('user_name'),
			  'password' => md5($request->getParam('password')),
			  'email' => $request->getParam('user_email'),
              'find_us' => $request->getParam('user_find_us')
              );
	try {
			$DB->insert('user', $data);
			$this->view->assign('desc', 'Registration Successful');
			$this->view->assign('description','Registration succes');
		}
	catch(Exception $e) {
			$this->view->assign('description', $e->getMessage());
		}	  	

  }
 	  public function listAction()
	 {
	  	$params = array('host'	=>'localhost',
					'username'	=>'root',
					'password'  =>'',
					'dbname'	=>'zend'
				   );
		$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
		try{   
		$DB->setFetchMode(Zend_Db::FETCH_OBJ);
		
		$sql = "SELECT * FROM `user` ORDER BY username ASC";
		$result = $DB->fetchAssoc($sql);
		
			$this->view->assign('title','Member List');
			$this->view->assign('description','Below, our members:');
			$this->view->assign('datas',$result);
		}
		catch(Exception $e) {
			$this->view->assign('description', $e->getMessage());
		}	  			
	 
	 }
	  public function editAction()
	{
	   $params = array('host'		=>'localhost',
					'username'	=>'root',
					'password'  =>'',
					'dbname'	=>'zend'
				   );
		$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
		
		
		$request = $this->getRequest();
		$id 	 = $request->getParam('id');
		try{
			$sql = "SELECT * FROM `user` WHERE `id` = '".$id."'";
			$result = $DB->fetchRow($sql);
				
			$this->view->assign('data',$result);
			$this->view->assign('action',$request->getBaseURL()."/user/processedit");
			$this->view->assign('title','Member Editing');
			$this->view->assign('label_uname','User Name');	
			$this->view->assign('label_email','Email');
			$this->view->assign('label_submit','Edit');		
			$this->view->assign('description','Please update this form completely:');
		
		}
		catch(Exception $e) {
			$this->view->assign('description', $e->getMessage());
		}		
	  		
	}
	public function processeditAction()
	 {
	   $params = array('host'		=>'localhost',
					'username'	=>'root',
					'password'  =>'',
					'dbname'	=>'zend'
				   );
		$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
		$request = $this->getRequest();
		 try{  
		$sql = "UPDATE `user` SET  `username` = '".$request->getParam('username')."',
                           `email` = '".$request->getParam('user_email')."' 
						   WHERE id = '".$request->getParam('id')."'";
		$DB->query($sql);
	
	  	$this->view->assign('title','Editing Process');
		$this->view->assign('description','Editing succes');  	
		}
		catch(Exception $e) {
			$this->view->assign('description', $e->getMessage());
		}
	 }
	 
	  public function delAction()
		 {
		   $params = array('host'		=>'localhost',
						'username'	=>'root',
						'password'  =>'',
						'dbname'	=>'zend'
					   );
			$DB = new Zend_Db_Adapter_Pdo_Mysql($params);
			$request = $this->getRequest();
			
			$DB->delete('user', 'id = '.$request->getParam('id'));
			
		    $this->view->assign('title','Delete Data');
			$this->view->assign('description','Deleting succes');  		  
		    $this->view->assign('list',$request->getBaseURL()."/user/list");  
		}
		
		public function userpageAction()
		{
			$auth	 = Zend_Auth::getInstance(); 
			
			$ns = new Zend_Session_Namespace('Zend1');
			if(!$auth->hasIdentity()){
	 			 $this->_redirect('/user/register');
			}
  
			if(!isset($ns->yourLoginRequest)){
				$ns->yourLoginRequest = 1;
			}else{
				$ns->yourLoginRequest++;
			}
			$request = $this->getRequest(); 
			$user	 = $auth->getIdentity();
			$username	= $user->username;
			$logoutUrl = $request->getBaseURL().'/user/logout';
			
			$this->view->assign('request', $ns->yourLoginRequest);
			$this->view->assign('username', $username);
			$this->view->assign('urllogout',$logoutUrl);
							
		}
		  public function authAction()
		  {
			    $request 	= $this->getRequest();
			    $auth		= Zend_Auth::getInstance(); 
				
				$params = array('host'		=>'localhost',
						'username'	=>'root',
						'password'  =>'',
						'dbname'	=>'zend'
					   );
				$DB 		= new Zend_Db_Adapter_Pdo_Mysql($params);
				$registry 	= Zend_Registry::getInstance();
				
				$DB->setFetchMode(Zend_Db::FETCH_OBJ);

				Zend_Registry::set('DB',$DB);
				$DB = $registry['DB'];
				
			   $authAdapter = new Zend_Auth_Adapter_DbTable($DB);
			   $authAdapter->setTableName('users')
						   ->setIdentityColumn('username')
						   ->setCredentialColumn('password');    
			
			// Set the input credential values
			$uname = $request->getParam('username_login');
			$paswd = $request->getParam('password_login');
			   $authAdapter->setIdentity($uname);
			   $authAdapter->setCredential(md5($paswd));
			
			   // Perform the authentication query, saving the result
			   $result = $auth->authenticate($authAdapter);
			
			   if($result->isValid()){
			  $data = $authAdapter->getResultRowObject(null,'password');
			  $auth->getStorage()->write($data);
			  $this->_redirect('/user/userpage');
			}else{
			  $this->_redirect('/user/register');
			}
		}
		
		 public function logoutAction()
		 {
			$auth = Zend_Auth::getInstance();
			$auth->clearIdentity();
			$this->_redirect('/user');
		 }
		 
		 public function statsAction()
		{
			$ns = new Zend_Session_Namespace('Zend1');
			foreach ($ns as $index => $value) {
			echo "ns->$index = '$value';";
			echo "<br />";
		  }
		}
		 public function registerAction()
		  {
			$auth		= Zend_Auth::getInstance();
			
			if($auth->hasIdentity()){
					 $this->_redirect('/user/userpage');
				}
			
			$ns = new Zend_Session_Namespace('Zend1');
					
			if(!isset($ns->yourLoginRequest)){
				$ns->yourLoginRequest = 1;
			}else{
				$ns->yourLoginRequest++;
			}
			
			$ns->setExpirationSeconds(60);
			 
			$this->view->assign('request', $ns->yourLoginRequest);
			$this->view->assign('action_login', $request->getBaseURL()."/user/auth");  
			$this->view->assign('title_login', 'Existing Users:');
			$this->view->assign('username_login', 'User Name');	
			$this->view->assign('password_login', 'Password');
			
		  }

		public function getForm()
			{
			$form = new Zend_Form();
			$form->setAction('/user/auth')
				 ->setMethod('post');
			 
			// Create and configure username element:
			$username = $form->createElement('text', 'username_login');
			$username->addValidator('alnum')
					 ->addValidator('regex', false, array('/^[a-z]+/'))
					 ->addValidator('stringLength', false, array(6, 20))
					 ->setRequired(true)
					 ->addFilter('StringToLower');
			 
			// Create and configure password element:
			$password = $form->createElement('password', 'password_login');
			$password->addValidator('StringLength', false, array(6))
					 ->setRequired(true);
			 
			// Add elements to form:
			$form->addElement($username)
				 ->addElement($password)
				 // use addElement() as a factory to create 'Login' button:
				 ->addElement('submit', 'login', array('label' => 'Login'));
			return $form;
			}
			
			public function indexAction()
			{
				// render user/form.phtml
				$this->view->form = $this->getForm();
				$this->render('form');
			}
			
			public function loginAction()
			{
				if (!$this->getRequest()->isPost()) {
					return $this->_forward('index');
				}
				$form = $this->getForm();
				if (!$form->isValid($_POST)) {
					// Failed validation; redisplay form
					$this->view->form = $form;
					return $this->render('form');
				}
		 
				$values = $form->getValues();
				// now try and authenticate....
			}
}
?>