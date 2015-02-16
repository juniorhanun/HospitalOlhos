<?php
/**
 * namespace para nosso modulo Core\View
 */

namespace Core\View;

use Zend\View\Helper\AbstractHelper;
use Doctrine\ORM\EntityManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * class ViewHead
 * Responsavel por busca informações das entidades Empresas, Ofertas,
 * e jogar no head
 * @author Winston Hanun Junior <ceo@sisdeve.com.br> skype ceo_sisdeve
 * @copyright (c) 2015, Winston Hanun Junior
 * @link http://www.sisdeve.com.br
 * @version V0.1
 * @package Core\View
 */
class ViewHead extends AbstractHelper implements ServiceManagerAwareInterface
{
    /*
     * @var Doctrine\ORM\EntityManager
     */

    protected $em;
    protected $sm;

    public function __construct($e, $sm) {
        $app = $e->getParam('application');
        $this->sm = $sm;
        $em = $this->getEntityManager();
    }

    /**
     * Invoke Helper
     * @return boolean
     */
    public function __invoke() {
        //Neste metodo você pode fazer o que quiser por ex: buscar um valor e retornar
        //$param = $this->params()->fromRoute('id', 0);
        $ofertas = $this->getEntityManager()->find('Admin\Entity\Ofertas', 1);
        if(!empty($ofertas)){
            return $ofertas;
        }
        return false;

    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->sm->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    /**
     *
     * @param \Doctrine\ORM\EntityManager $em
     */
    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Retrieve service manager instance
     *
     * @return ServiceManager
     */
    public function getServiceManager() {
        return $this->sm->getServiceLocator();
    }

    /**
     * Set service manager instance
     *
     * @param ServiceManager $locator
     * @return void
     */
    public function setServiceManager(ServiceManager $serviceManager) {
        $this->sm = $serviceManager;
    }

    /**
     * get repository
     * @return type
     */
    public function getRepository() {
        if (null === $this->em)
            $this->em = $this->getEntityManager()->getRepository('Application\Entity\MinhaEntity');
        return $this->em;
    }
}