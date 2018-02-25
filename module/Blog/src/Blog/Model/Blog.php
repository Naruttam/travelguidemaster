<?php

namespace Blog\Model;

class Blog
{
	public $id;
	public $username;
	public $password;
	public $active;
	public $userid;
	public $first_name;
	public $middle_name;
	public $last_name;
	public $gender;
	public $email_id;


	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->username = (!empty($data['user_name'])) ? $data['user_name'] : null;
		$this->password  = (!empty($data['secret_key'])) ? $data['secret_key'] : null;
		$this->active 	=	(!empty($data['active'])) ? $data['active'] : null;
		$this->userid 	=	(!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->first_name 	=	(!empty($data['first_name'])) ? $data['first_name'] : null;
		$this->middle_name 	=	(!empty($data['middle_name'])) ? $data['middle_name'] : null;
		$this->last_name 	=	(!empty($data['last_name'])) ? $data['last_name'] : null;
		$this->gender 	=	(!empty($data['gender'])) ? $data['gender'] : null;
		$this->email_id 	=	(!empty($data['email_id'])) ? $data['email_id'] : null;
	}

	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}