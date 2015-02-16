<?php
/**
 * namespace para nosso modulo Admin\Form\Filter
 */
namespace Admin\Form\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

/**
 * class AdminFilter
 * Filtro da classe AdminForm
 * Responsavel por filtrar todos os campos do forumularios
 * @author Winston Hanun Junior <ceo@sisdeve.com.br> skype ceo_sisdeve
 * @copyright (c) 2015, Winston Hanun Junior
 * @link http://www.sisdeve.com.br
 * @version V0.1
 * @package Admin\Form\Filter
 */
class AdminFilter extends InputFilter
{
    public function __construct()
    {

            //Input nome
            $nome = new Input('nome');
            $nome->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
            $nome->getValidatorChain()->attach(new NotEmpty());
            $this->add($nome);

            //Input login
            $login = new Input('login');
            $login->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
            $login->getValidatorChain()->attach(new NotEmpty());
            $this->add($login);

            //Input email
            $email = new Input('email');
            $email->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
            $email->getValidatorChain()->attach(new NotEmpty());
            $this->add($email);


    }
}