<?php
namespace Blog\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter as DbAdapter;

use Zend\Authentication\Result;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;

/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

class LoginController extends AbstractActionController
{
	private $userstable;
	public function indexAction()
	{	
		$user 				=	$this->identity();
		$request            =   $this->getRequest();

		if($request->isPost())
		{
			$sm             =   $this->getServiceLocator();
			$dbAdapter 		=	$sm->get('Zend\Db\Adapter\Adapter');

			$formData 		=	$request->getPost();
			
			$password 		=	MD5($formData['password']);
			
			$authAdapter 	=	new AuthAdapter($dbAdapter);			

			$authAdapter->setTableName('users')
						->setIdentityColumn('user_name')
						->setCredentialColumn('secret_key');
						//->setCredentialTreatment('MD5(?)');


			$authAdapter->setIdentity($formData['username'])
						->setCredential($password);

			//$authAdapter->getDbSelect()->where('active = 1');
			$auth 			=	new AuthenticationService();
			$result 		=	$auth->authenticate($authAdapter);

			$auth           =   new AuthenticationService();
            $result         =   $auth->authenticate($authAdapter);

			switch($result->getcode())
			{
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

		return new ViewModel(array('result' => $result));
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
}