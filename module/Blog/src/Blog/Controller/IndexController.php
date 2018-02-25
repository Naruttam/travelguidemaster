<?php
namespace Blog\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Blog\Model\Blog;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

class IndexController extends AbstractActionController
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
		$user = "";
        $userID = "";
        if($user = $this->identity()){
            $userID = $user->id;
        }

        $userprofileTable = $this->getuserprofileTable();
        $users = $userprofileTable->getUsersbyParentId($userID);

        return new ViewModel(
            array('users' => $users)
        );
	}

    public function getuserprofileTable()
    {
        if(!$this->userprofileTable){
            $sm = $this->getServiceLocator();
            $this->userprofileTable = $sm->get('Blog\Model\UserprofileTable');
        }
        return $this->userprofileTable;
    }


    public function signoutAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if($auth->hasIdentity())
        {
            $identity = $auth->getIdentity();
        }
        $auth->clearIdentity();
        return $this->redirect()->toRoute('blog/default', array('controller'=>'login','action'=>'index'));
    }


}