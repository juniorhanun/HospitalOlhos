<?php
namespace Admin;

use Admin\Service\AdminService,
    Core\Auth\Adapter as AuthAdapter;
use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;


class Module
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

    /**
     * Resitar os EntityManager dos Serviços
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Admin\Service\AdminService' => function($em){
                    return new AdminService($em->get('Doctrine\ORM\EntityManager'));
                },
            ),
        );
    }

    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();

        $sharedEvents->attach("Zend\Mvc\Controller\AbstractActionController",
            MvcEvent::EVENT_DISPATCH,
            array($this,'validaAuth'),100);
    }

    public function validaAuth($e)
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("AdminUser"));

        // Pega o Controller
        $controller = $e->getTarget();
        $matchedRoute = $controller->getEvent()->getRouteMatch()->getMatchedRouteName();

        /*var_dump($auth->hasIdentity());die("ModuleAdmin L 62");
        if(!$auth->hasIdentity()):
            // Redireciona para a index do Controller Auth
            //return $controller->redirect()->toRoute('admin-auth', array('controller' => 'auth',));
        endif;
        */
        if($auth->hasIdentity()):
            return;
        endif;
        if($matchedRoute == 'admin-auth'):
            return;
        else:
            return $controller->redirect()->toRoute("admin-auth");
        endif;


    }
}
