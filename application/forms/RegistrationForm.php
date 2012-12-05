<?php
require_once 'Zend/Form.php';
class RegistrationForm extends Zend_Form
{
    public function init()
    {
        $this->setAction("#")
			 ->setMethod('post')
			 ->setAttrib('id', 'RegistrationForm');
			           
        $email = $this->createElement('text','email');
        $email->setLabel('Email: *')
                ->setRequired(false);
                
        $username = $this->createElement('text','username');
        $username->setLabel('Username: *')
                ->setRequired(true);
                
        $password = $this->createElement('password','password');
        $password->setLabel('Password: *')
                ->setRequired(true);
				
		$find_us = $this->createElement('text','find_us');
        $find_us->setLabel('How Did you find us?: ')
                ->setRequired(false);
                
        $register = $this->createElement('submit','register');
        $register->setLabel('Register')
                ->setIgnore(true);
                
        $this->addElements(array(
                        $username,
						$email,
                        $password,
                        $find_us,
                        $register
        ));
    }
}
?>