<?php

namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService;

class UserController extends AbstractActionController
{
	public function onDispatch(\Zend\Mvc\MvcEvent $e)
	{
	    $authservice = new AuthenticationService();
	    if (! $authservice->hasIdentity()) {
	        //return $this->redirect()->toRoute('blog/login');
	        return $this->redirect()->toRoute('blog/default', array('controller' => 'login', 'action' => 'index'));
	            //break;
	    }
	    return parent::onDispatch($e);
	}

	public function indexAction()
	{
		return new ViewModel();
	}
}