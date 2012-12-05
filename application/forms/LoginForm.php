<?php

require_once 'Zend/Form.php';
require_once 'Zend/Filter.php';
require_once 'Zend/Validate.php';
require_once 'Zend/View.php';
class LoginForm extends Zend_Form
{
    public function init()
    {
		$this->setAction('/../auth/form')
			->setMethod('post')
			->setAttrib('id', 'LoginForm');

        $username = $this->createElement('text','username');
        $username->setLabel('Username: *')
                ->addValidator('alnum')
				->setRequired(true)
				->addFilter('StringTrim');
                
        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
				->setRequired(true)
				->addFilter('StringTrim');
                
        $signin = $this->createElement('submit','signin');
        $signin->setLabel('Sign in')
                ->setIgnore(true);
                
        $this->addElements(array(
                        $username,
                        $password,
                        $signin,
        ));
	}
}
?>