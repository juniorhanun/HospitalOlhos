<?php

namespace Admin\Controller;

use Core\Form\LoginForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage;

class AuthController extends AbstractActionController
{

    public function indexAction()
    {
        $form = new LoginForm;
        $error = false;

        $request = $this->getRequest();

        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $data = $request->getPost()->toArray();

                // Criando Storage para gravar sessão da authtenticação
                $sessionStorage = new SessionStorage("AdminUser");

                $auth = new AuthenticationService;
                $auth->setStorage($sessionStorage); // Definindo o SessionStorage para a auth

                $authAdapter = $this->getServiceLocator()->get("Core\Auth\Adapter");
                $authAdapter
                    ->setEntity('Admin\Entity\Admin') // Entidade
                    ->setMetodoLogin('loginAdmin') // Método do Login
                    ->setLogin($data['login']) // Campo para pesquisar geramente vai ser login
                    ->setSenha($data['senha']); // Senha
                //var_dump($authAdapter);die();

                $result = $auth->authenticate($authAdapter);

                if($result->isValid())
                {
                    $sessionStorage->write($auth->getIdentity()['login'],null);
                    // Redireciona para a index do Controller
                    return $this->redirect()
                        ->toRoute('admin-admin/default', array('controller' => 'admin',));
                }
                else

                    $this->flashMessenger()->addErrorMessage("Não foi possivel conectar ao banco \n login ou seja não conferem");
                    // Redireciona para a index do Controller Auth
                    return $this->redirect()
                        ->toRoute('admin-auth', array('controller' => 'auth',));
            }
        }

        return new ViewModel(array('form'=>$form,));
    }

    public function logoutAction()
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("AdminUser"));
        $auth->clearIdentity();

        // Redireciona para a index do Controller Auth
        return $this->redirect()
            ->toRoute('admin-auth', array('controller' => 'auth',));
    }


}

