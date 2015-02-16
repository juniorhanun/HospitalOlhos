<?php
/**
 * namespace para nosso modulo Admin\Form
 */
namespace Admin\Form;


use Admin\Form\Filter\AdminFilter;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * class AdminForm
 * Controller Responsavel por manipular o Formulario Admin
 * @author Winston Hanun Junior <ceo@sisdeve.com.br> skype ceo_sisdeve
 * @copyright (c) 2015, Winston Hanun Junior
 * @link http://www.sisdeve.com.br
 * @version V0.1
 * @package Admin\Controller
 */
class AdminForm extends Form
{
    public function __construct()
    {
        parent::__construct('AdminForm');
        $this->setAttributes(array(
            'method' => 'POST',
            'role' => 'form'
        ));

        $this->setInputFilter(new AdminFilter());

        //Input nome
        $nome = new Text('nome');
        $nome->setLabel('nome.: ')
            ->setAttributes(array(
                'maxlength' => 40,
                'class' => 'form-control',
                'id' => 'nome',
                'placeholder' => 'Entre com Nome  .:',
            ));
        $this->add($nome);

        //Input login
        $login = new Text('login');
        $login->setLabel('login.: ')
            ->setAttributes(array(
                'maxlength' => 40,
                'class' => 'form-control',
                'id' => 'login',
                'placeholder' => 'Entre com Login  .:',
            ));
        $this->add($login);

        //Input senha
        $senha = new Password('senha');
        $senha->setLabel('senha.: ')
            ->setAttributes(array(
                'maxlength' => 40,
                'class' => 'form-control',
                'id' => 'senha',
                'placeholder' => 'Entre com Senha  .:',
            ));
        $this->add($senha);

        //Input email
        $email = new Email('email');
        $email->setLabel('email.: ')
            ->setAttributes(array(
                'maxlength' => 40,
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'Entre com Email  .:',
            ));
        $this->add($email);

        // Select status
        $status = new Select('status');
        $status->setLabel('Condição.:')
            ->setAttributes(array(
                'class' => 'form-control',
                'id' => 'status',
            ));
        $status->setValueOptions(array(
            '1' => 'ATIVO',
            '0' => 'DESTATIVADO'
        ));
        $this->add($status);
    }
}