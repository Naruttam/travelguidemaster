<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;


use Zend\Authentication\AuthenticationService;
use Blog\Model\Blog;

ini_set('display_errors', 'On');
error_reporting(E_ALL);


class ProfileController extends AbstractActionController
{
	protected $userprofileTable;

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
		
		$userprofileTable = $this->getuserprofileTable();
		$user = $userprofileTable->fetchAllusers();

		//$user = $this->getusersTable()->select();
		//$user = $this->getUsersTable()->fetchAll();
		//echo "<pre>"; print_r($user);
		return new ViewModel(array('resultset' => $user));
	}

	public function getuserprofileTable()
    {
    	if(!$this->userprofileTable){
    		/*$this->userstable = new tableGateway(
    			'users',
    			$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')       
    		);*/
    		$sm = $this->getServiceLocator();
            $this->userprofileTable = $sm->get('Blog\Model\UserprofileTable');
    	}
    	return $this->userprofileTable;
    }
}