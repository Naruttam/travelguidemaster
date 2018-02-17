<?php

namespace Application\Form;

use Zend\Form\Form;

class LoginAuth extends Form
{
	public function __construct($name = null)
	{
		parent::__construct( 'application' );

		$this->setMethod('post');

		$this->add(
			'text','username',array(
				'label'	=> 'Username :',
				'required' => true,
				'filters'	=> 	array('StringTrim'),
			)
		);

		$this->addElement('password', 'password', array(
			'label' => 'Password :',
			'required' => true,
		));

		$this->addElement('submit', 'submit', array(
			'ignore'	=>	true,
			'label'		=> 	'Login'
		));
	}
}