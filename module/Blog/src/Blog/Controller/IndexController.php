<?php

namespace Blog\Controller;
error_reporting( E_ALL );
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\TableGateway\TableGateway;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;

use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Blog\Model\Blog;

class IndexController extends AbstractActionController
{
	private $userstable;
	public function indexAction()
	{
		return new ViewModel();
	}

	public function loginAction()
    {
        //$layout             =   $this->layout();
        //$layout->setTemplate('layout/login');
        $user               =   $this->identity();
        $request            =   $this->getRequest();
        //echo "<pre>"; print_r($request->getPost());
        if($request->isPost()){

            $sm             =   $this->getServiceLocator();
            $dbAdapter      =   $sm->get('Zend\Db\Adapter\Adapter');
            //$config = $this->getServiceLocator()->get('Config');
            $formData       =   $request->getPost();

           
            //$staticSalt = $config['static_salt'];
            $secretKey      =   MD5($formData['password']);
            $authAdapter    =   new AuthAdapter($dbAdapter,
                    'users',
                    'user_name',
                    'secret_key' 
            );

            $authAdapter 
                    ->setIdentity($formData['username'])
                    ->setCredential($secretKey);
            $auth           =   new AuthenticationService();
            $result         =   $auth->authenticate($authAdapter);
           //echo "<pre>"; print_r($formData);exit();
            switch($result->getCode()){
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    //do stuff for non existent identity
                    $result = "Invalid Credentials";
                    return new ViewModel(array('result' => $result));
                break;

                case Result::FAILURE_CREDENTIAL_INVALID:
                    //do stuff for invalid credential.
                    $result = "Invalid Credentials";
                    return new ViewModel(array('result' => $result));
                break;

                case Result::SUCCESS:
                    $storage = $auth->getStorage();
                    $storage->write($authAdapter->getResultRowObject(
                        null,
                        'secret_key'
                    ));
                    return $this->redirect()->toRoute('blog/default', array('controller' => 'index', 'action' => 'index'));
                break;

                default:
                break;
            }
        }
        
    	//return new ViewModel(array('result' => $result));
    }

	public function getusersTable()
    {
    	if(!$this->userstable){
    		$this->userstable = new tableGateway(
    			'users',
    			$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
    		);
    	}
    	return $this->userstable;
    }

    public function signoutAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

        if($auth->hasIdentity())
        {
            $identity = $auth->getIdentity();
        }
        $auth->clearIdentity();
        return $this->redirect()->toRoute('blog/default', array('controller'=>'index','action'=>'login'));
    }


}