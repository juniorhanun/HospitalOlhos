<?php
/**
 * namespace para nosso modulo Admin\Controller
 */

namespace Admin\Controller;

use Core\Controller\AbstractController;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
/**
 * class AdminController
 * Controller Responsavel por manipular os dados da Entidade Admin
 * @author Winston Hanun Junior <ceo@sisdeve.com.br> skype ceo_sisdeve
 * @copyright (c) 2015, Winston Hanun Junior
 * @link http://www.sisdeve.com.br
 * @version V0.1
 * @package Admin\Controller
 */

class AdminController extends AbstractController
{

    // Método Contrutor
    function __construct()
    {
        $this->form = 'Admin\Form\AdminForm';
        $this->controller = 'Admin';
        $this->route = 'admin-admin/default';
        $this->service = 'Admin\Service\AdminService';
        $this->entity = 'Admin\Entity\Admin';
        $this->itemPorPaigina = 20;
        $this->campoOrder = 'nome';
        $this->order = 'ASC';
        $this->campoPesquisa = 'status';
        $this->dadoPesquisa = '1';
    }

    public function pesquisaAction()
    {
        $nome = $this->params()->fromQuery('query', null);
        if (isset($nome)) {
            // Resebe os dados da Entidade passada
        $list = $this->getEm()->getRepository($this->entity)->BuscaNomeAdmin($nome);

        }
        return new JsonModel($list);
    }

    public function detalhesAction()
    {
        // filtra id passsado pela url
        $id = (int) $this->params()->fromRoute('id', 0);
        // se id = 0 ou não informado redirecione
        $lista = $this->getEm()->getRepository($this->entity)->findBy(array('id' => $id));

        // dados eviados para detalhes.phtml
        return (new ViewModel())
            ->setTerminal($this->getRequest()->isXmlHttpRequest())
            ->setVariable('dados', $lista)
            ;
    }
    /*
    public function inserirAction()
    {
        parent::inserirAction();
    }
    */

    /*
    public function editarAction()
    {
        parent::editarAction();
    }
    */

    /*
    public function excluirAction()
    {
        parent::excluirAction();
    }
    */

}