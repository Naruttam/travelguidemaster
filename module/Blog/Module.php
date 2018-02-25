<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Blog;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Blog\Model\Blog;
use Blog\Model\UsersTable;
use Blog\Model\UserprofileTable;

class Module implements ConfigProviderInterface, ServiceProviderInterface, AutoloaderProviderInterface 
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(

            'factories' => array(

                'Blog\Model\UsersTable' => function($sm)
                {
                    $tableGateway   =   $sm->get('UsersTableGateway');
                    $table          =   new UsersTable($tableGateway);
                    return $table; 
                },

                'UsersTableGateway' =>    function($sm)
                {
                    $dbAdapter      =   $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype =   new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Users());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },

                'Blog\Model\UserprofileTable' => function($sm)
                {
                    $tableGateway   =   $sm->get('UserprofileTableGateway');
                    $table          =   new UserprofileTable($tableGateway);
                    return $table; 
                },

                'UserprofileTableGateway' =>    function($sm)
                {
                    $dbAdapter      =   $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype =   new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Blog());
                    return new TableGateway('user_profile', $dbAdapter, null, $resultSetPrototype);
                },

            ),
            /*
                To reduce the above reduntant code check the below link.
            */
            /*https://samsonasik.wordpress.com/2012/08/28/set-default-db-adapter-in-zend-framework-2/*/

        );


        //return include __DIR__ . '/config/service.config.php';
    }
}
