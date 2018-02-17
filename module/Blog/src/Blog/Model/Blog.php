<?php

namespace Blog\Model;

class Blog
{
	public $id;
	public $username;
	public $password;
	public $active;

	public function exchangeArray($data)
	{
		$this->id     = (!empty($data['id'])) ? $data['id'] : null;
		$this->username = (!empty($data['username'])) ? $data['username'] : null;
		$this->password  = (!empty($data['password'])) ? $data['password'] : null;
		$this->active 	=	(!empty($data['active'])) ? $data['active'] : null;
	}
}