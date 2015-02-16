<?php

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class GeraFormController extends AbstractActionController
{

    public function indexAction()
    {
        die("Escolher a tabela");
        $dbname = 'modelo';

        if (!mysql_connect('localhost', 'root', 'Linux1009')) {
            echo 'Could not connect to mysql';
            exit;
        }
        mysql_select_db($dbname) or die("Can not connect.");

        $table = "admin";
        $modulo = "Admin";
        $tabela = $table;
        $table = ucfirst($table);
        $module = lcfirst($modulo);


        $sql = "SHOW COLUMNS FROM $tabela";
        //echo $sql."<br>";
        $result = mysql_query($sql);

        if (!$result) {
            echo "DB Error, could not list tables\n";
            echo 'MySQL Error: ' . mysql_error();
            exit;
        }
        // Criação do Controller
        if(!file_exists('./module/'.$modulo.'/src/'.$modulo.'/Controller/')){
            mkdir('./module/'.$modulo.'/src/'.$modulo.'/Controller/');
        }
        $arquivo = fopen('./module/'.$modulo.'/src/'.$modulo.'/Controller/'.ucfirst($table).'Controller.php','w+');
        if ($arquivo) {
            // move o ponteiro para o inicio do arquivo
            rewind($arquivo);


            $contuedo = "<?php
/**
 * namespace para nosso modulo Admin\Controller
 */

namespace ".$modulo."\Controller;

use Core\Controller\AbstractController;
use Zend\Mvc\Controller\AbstractActionController;
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

class ".$table."Controller extends AbstractController
{

    // Método Contrutor
    function __construct()
    {
        #this->form = '".$modulo."\Form\|{$table}|Form';
        #this->controller = '{$table}';
        #this->route = '{$module}-{$tabela}/default';
        #this->service = '{$modulo}\Service\|{$table}|Service';
        #this->entity = '{$modulo}\Entity\|{$table}|';
        #this->itemPorPaigina = 20;
        #this->campoOrder = 'nome';
        #this->order = 'ASC';
        #this->campoPesquisa = 'status';
        #this->dadoPesquisa = 'ATIVO';
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

}"
            ;

            $contuedo = str_replace("#","$",$contuedo);
            $contuedo = str_replace("|","",$contuedo);

            if (!fwrite($arquivo, $contuedo)) die('Não foi possível atualizar o arquivo.');
            echo 'Controller Criado com Sucessos<br>';
            fclose($arquivo);
        }

        // Criação do Formulario

        if(!file_exists('./module/'.$modulo.'/src/'.$modulo.'/Form/')){
            mkdir('./module/'.$modulo.'/src/'.$modulo.'/Form/');
        }
        $arquivo = fopen('./module/'.$modulo.'/src/'.$modulo.'/Form/'.ucfirst($table).'Form.php','w+');
        if ($arquivo) {
            // move o ponteiro para o inicio do arquivo
            rewind($arquivo);
            $contuedo = "<?php
/**
 * namespace para nosso modulo Admin\Form
 */
namespace Admin\Form;


use Admin\Form\Filter\|{$table}|Filter;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Select;
use Zend\Form\Element\Text;
use Zend\Form\Form;

/**
 * class ".$table."Form
 * Controller Responsavel por manipular o Formulario ".$table."
 * @author Winston Hanun Junior <ceo@sisdeve.com.br> skype ceo_sisdeve
 * @copyright (c) 2015, Winston Hanun Junior
 * @link http://www.sisdeve.com.br
 * @version V0.1
 * @package ".$table."\Controller
 */
class ".$table."Form extends Form
{
    public function __construct()
    {
        parent::__construct('|{$table}|Form');
        #this->setAttributes(array(
            'method' => 'POST',
            'role' => 'form'
        ));

        #this->setInputFilter(new ".$table."Filter());";
            $sqlCampos = "SHOW COLUMNS FROM $tabela";
            $resultCampos = mysql_query($sqlCampos);
            while ($linha = mysql_fetch_row($resultCampos)) {
                $campos = explode('_', $linha[0]);
                $campo = $campos[0].ucfirst($campos[1]);
                $campoToUpper = ucfirst($campos[0]) . " " . ucfirst($campos[1]);
                //die();
                $contuedo .= "

        //Input {$campo}
        #{$campo} = new Text('{$campo}');
        #{$campo}->setLabel('{$campo}.: ')
            ->setAttributes(array(
                'maxlength' => 40,
                'class' => 'form-control',
                'id' => '{$campo}',
                'placeholder' => 'Entre com " . $campoToUpper . " .:',
            ));
        #this->add(#{$campo});";
            }

            $contuedo .="
    }
}";

            $contuedo = str_replace("#","$",$contuedo);
            $contuedo = str_replace("|","",$contuedo);

            if (!fwrite($arquivo, $contuedo)) die('Não foi possível atualizar o arquivo.');
            echo 'Formulario Criado com Sucesso<br>';
            fclose($arquivo);
        }

        // Criação do Filter
        if(!file_exists('./module/'.$modulo.'/src/'.$modulo.'/Form/Filter/')){
            mkdir('./module/'.$modulo.'/src/'.$modulo.'/Form/Filter/');
        }
        $arquivo = fopen('./module/'.$modulo.'/src/'.$modulo.'/Form/Filter/'.ucfirst($table).'Filter.php','w+');
        if ($arquivo) {
            // move o ponteiro para o inicio do arquivo
            rewind($arquivo);
            $contuedo = "<?php
/**
 * namespace para nosso modulo ".$modulo."\Form\Filter
 */
namespace ".$modulo."\Form\Filter;

use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator\NotEmpty;

/**
 * class ".$table."Filter
 * Filtro da classe ".$table."Form
 * Responsavel por filtrar todos os campos do forumularios
 * @author Winston Hanun Junior <ceo@sisdeve.com.br> skype ceo_sisdeve
 * @copyright (c) 2015, Winston Hanun Junior
 * @link http://www.sisdeve.com.br
 * @version V0.1
 * @package ".$modulo."\Form\Filter
 */
class ".$table."Filter extends InputFilter
{
    public function __construct()
    {";
            $sqlCampos = "SHOW COLUMNS FROM $tabela";
            $resultCampos = mysql_query($sqlCampos);
            while ($linha = mysql_fetch_row($resultCampos)) {

                $campos = explode('_', $linha[0]);
                $campo = $campos[0].ucfirst($campos[1]);
                //die();
                $contuedo .= "

            //Input {$campo}
            #{$campo} = new Input('{$campo}');
            #{$campo}->setRequired(true)
                ->getFilterChain()
                ->attach(new StringTrim())
                ->attach(new StripTags());
            #{$campo}->getValidatorChain()->attach(new NotEmpty());
            #this->add(#{$campo});";
            }
            $contuedo .= "
    }
}";

            $contuedo = str_replace("#","$",$contuedo);
            $contuedo = str_replace("|","",$contuedo);

            if (!fwrite($arquivo, $contuedo)) die('Não foi possível atualizar o arquivo.');
            echo 'Filter Criado com Sucesso<br>';
            fclose($arquivo);
        }

        // Criação do do Index.phtml
        if(!file_exists('./module/'.$modulo.'/view/'.$module.'/'.$tabela.'/')){
            mkdir('./module/'.$modulo.'/view/'.$module.'/'.$tabela.'/',0744);
        }
        $arquivo = fopen('./module/'.$modulo.'/view/'.$module.'/'.$tabela.'/index.phtml','w+');
        if ($arquivo) {
            // move o ponteiro para o inicio do arquivo
            rewind($arquivo);
            $contuedo = "<div class=%topo-table%>
    <a href=%<?php echo #this->url('$module-$tabela/default', array('action' => 'inserir'))?>% class=%btn btn-success% title=%Novo%><span class=%glyphicon glyphicon-plus%></span></a>
    <form class=%form-inline pull-right% role=%form%>
        <div class=%form-group%>
            <label class=%sr-only% for=%localizar%>Buscar...</label>
            <input type=%search% class=%form-control% id=%localizar% placeholder=%Bucar...%>
        </div>
        <button type=%submit% class=%btn btn-default%><span class=%glyphicon glyphicon-search%></span></button>
    </form>
</div>
<br>
<div class=%panel panel-primary%>
    <div class=%panel-heading%>
        <div class=%panel-title%>
            Novo(a) $table(a)
        </div>
    </div>
</div>

<div class=%corpo-table%>
    <table class=%table table-striped table-bordered table-hover%>
        <thead>
            <tr>
            ";
            $sqlCampos = "SHOW COLUMNS FROM $tabela";
            $resultCampos = mysql_query($sqlCampos);
            while ($linha = mysql_fetch_row($resultCampos)) {
                $campos = explode('_', $linha[0]);
                $campo = $campos[0].ucfirst($campos[1]);
                $campoToUpper = ucfirst($campos[0]) . " " . ucfirst($campos[1]);
                //die();
                $contuedo .= "
                <th>$campoToUpper</th>";
            }
            $contuedo .= "<th>Opções</th>

            </tr>
        </thead>

        <tbody>
        <?php
        /**
         * @var #entity \|{$modulo}|\Entity\|{$table}|
         */
    if (#this->data):
	    foreach (#this->data as #entity): ?>
                <tr>
                    ";
            $sqlCampos = "SHOW COLUMNS FROM $tabela";
            $resultCampos = mysql_query($sqlCampos);
            while ($linha = mysql_fetch_row($resultCampos)) {
                $campos = explode('_', $linha[0]);
                $campo = ucfirst($campos[0]).ucfirst($campos[1]);
                //die();
                $contuedo .= "
                    <td><?php echo #entity->get$campo(); ?></td>";

            }
            $contuedo .= "
<td><?php //echo (#entity->getDataCadastro()) ? #this->dateFormat(#entity->getDataCadastro(), IntlDateFormatter::FULL) : ''; ?></td>
                    <td>
                        <a class=%btn btn-xs btn-warning% title=%Editar% href=%<?php echo #this->url('$module-$tabela/default', array('action' => 'editar', 'id' => #entity->getId(),))?>%><span class=%glyphicon glyphicon-edit%></span></a>
                        <a class=%btn btn-xs btn-danger% title=%Deletar% href=%<?php echo #this->url('$module-$tabela/default', array(%action% => %excluir%, %id% => #entity->getId(),)); ?>%><span class=%glyphicon glyphicon-floppy-remove%></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nem um Registro foi Encontrado</p>
        <?php endif; ?>
        </tbody>
    </table>

<?php echo #this->paginationControl(#this->data,'Sliding','partials/paginator', array('router' => '$module-$tabela/paginator')); ?>


<?php #this->headScript()->captureStart(); ?>
#(function(){
// variável para conter a url deletar
var url_deletar     = '<?php echo #this->url('$module-$tabela/default', array(%action% => %excluir%)); ?>' + '/';

// qualquer link que tiver a url deletar vai sofrer um evento quando for clicada
#(%a[href*='% + url_deletar + %']%).click(function (event) {
// variável contendo o id referente ao botão clicado
var admin_id  = #(this).attr('href').split(url_deletar).pop();
// variável contendo mensagem da janela
var mensagem = %Deseja realmente apagar o $table com ID % + admin_id + %?%;
// variável com resposta da mensagem colocada na janela
var confirmacao = confirm(mensagem);

// se a confirmação for false o fluxo é interrompido
if (!confirmacao)
// elimar o evendo do botão clicado
event.preventDefault();
});
});
<?php #this->headScript()->captureEnd(); ?>
";
            $contuedo = str_replace("#","$",$contuedo);
            $contuedo = str_replace("%","\""  ,$contuedo);
            $contuedo = str_replace("|",""  ,$contuedo);
            if (!fwrite($arquivo, $contuedo)) die('Não foi possível atualizar o arquivo.');
            echo 'Arquivo Index.phtml Criado com Sucesso<br>';
            fclose($arquivo);
        }

        // Criação do do Insert.phtml
        $arquivo = fopen('./module/'.$modulo.'/view/'.$module.'/'.$tabela.'/inserir.phtml','w+');
        if ($arquivo) {
            // move o ponteiro para o inicio do arquivo
            rewind($arquivo);
            $contuedo = "<div class=%panel panel-primary%>
    <div class=%panel-heading%>
        <div class=%panel-title%>
            Novo(a) $table(a)
        </div>
    </div>
    <?php
    // objeto form contato
    #form = #this->form;
    // preparar elementos do formulário
    #form->prepare();
    // configurar url formulário
    #form->setAttribute('action', #this->url('$module-$tabela/default', array('controller' => '$tabela', 'action' => 'inserir')));

    // renderiza html <form> com atributos configurados no objeto
    echo #this->form()->openTag(#form) ?>
    <div class=%panel-body %>
        <div class=%container%>

            ";
            $sql = "SHOW COLUMNS FROM $tabela";
            $result = mysql_query($sql);
            while ($linha = mysql_fetch_row($result)) {
                $campos = explode('_', $linha[0]);
                $campo = $campos[0].ucfirst($campos[1]);
                $campoToUpper = ucfirst($campos[0]) . " " . ucfirst($campos[1]);
                $contuedo .="
            <div class='row'>
                <div class='form-group'>
                    <label for='inputTelefonePrincipal' class='col-md-1 control-label label_right'>$campoToUpper.:</label>
                    <div class='col-lg-4  col-md-4'>
                        <?php
                        // renderiza html input
                        echo #this->formInput(#form->get('$campo'));

                        // renderiza elemento de erro
                        echo #this->formElementErrors()
                            ->setMessageOpenFormat(%<small class='text-danger'>%)
                            ->setMessageSeparatorString(%</small><br/><small class='text-danger'>%)
                            ->setMessageCloseString(%</small>%)
                            ->render(#form->get('$campo'));
                        ?>
                    </div>
                </div>
            </div>
                  ";
            }
            $contuedo .= "
        </div>
    </div>

    <div class=%panel-footer%>
        <button type=%submit% class=%btn btn-primary%>Salvar $table(a)</button>
        <a href=%<?php echo #this->url('$module-$tabela'); ?>% class=%btn btn-default%>Voltar</a>
    </div>

    <?php
    // renderiza html
    echo #this->form()->closeTag() ?>
</div>";

            $contuedo = str_replace("#","$",$contuedo);
            $contuedo = str_replace("%","\""  ,$contuedo);
            $contuedo = str_replace("|",""  ,$contuedo);
            if (!fwrite($arquivo, $contuedo)) die('Não foi possível atualizar o arquivo.');
            echo 'Arquivo Inserir Criado com sucesso<br>';
            fclose($arquivo);
        }

        // Criação do do Editar.phtml
        $arquivo = fopen('./module/'.$modulo.'/view/'.$module.'/'.$tabela.'/editar.phtml','w+');
        if ($arquivo) {
            // move o ponteiro para o inicio do arquivo
            rewind($arquivo);
            $contuedo = "<div class=%panel panel-primary%>
    <div class=%panel-heading%>
        <div class=%panel-title%>
            Novo(a) $table(a)
        </div>
    </div>
    <?php
    // objeto form contato
    #form = #this->form;
    // preparar elementos do formulário
    #form->prepare();
    // configurar url formulário
    #form->setAttribute('action', #this->url('$module-$tabela/default', array('controller' => 'admin', 'action' => 'editar', 'id' => #this->id)));

    // renderiza html <form> com atributos configurados no objeto
    echo #this->form()->openTag(#form) ?>
    <div class=%panel-body %>
        <div class=%container%>

            ";
            $sql = "SHOW COLUMNS FROM $tabela";
            $result = mysql_query($sql);
            while ($linha = mysql_fetch_row($result)) {
                $campos = explode('_', $linha[0]);
                $campo = $campos[0].ucfirst($campos[1]);
                $campoToUpper = ucfirst($campos[0]) . " " . ucfirst($campos[1]);
                $contuedo .="
            <div class='row'>
                <div class='form-group'>
                    <label for='inputTelefonePrincipal' class='col-md-1 control-label label_right'>$campoToUpper.:</label>
                    <div class='col-lg-4  col-md-4'>
                        <?php
                        // renderiza html input
                        echo #this->formInput(#form->get('$campo'));

                        // renderiza elemento de erro
                        echo #this->formElementErrors()
                            ->setMessageOpenFormat(%<small class='text-danger'>%)
                            ->setMessageSeparatorString(%</small><br/><small class='text-danger'>%)
                            ->setMessageCloseString(%</small>%)
                            ->render(#form->get('$campo'));
                        ?>
                    </div>
                </div>
            </div>
                  ";
            }
            $contuedo .= "
        </div>
    </div>

    <div class=%panel-footer%>
        <button type=%submit% class=%btn btn-primary%>Salvar $table(a)</button>
        <a href=%<?php echo #this->url('$module-$tabela'); ?>% class=%btn btn-default%>Voltar</a>
    </div>

    <?php
    // renderiza html
    echo #this->form()->closeTag() ?>
</div>";


            $contuedo = str_replace("#","$",$contuedo);
            $contuedo = str_replace("%","\""  ,$contuedo);
            $contuedo = str_replace("|",""  ,$contuedo);

            if (!fwrite($arquivo, $contuedo)) die('Não foi possível atualizar o arquivo.');
            echo 'Arquivo Editar.phtml Criado com sucesso<br>';
            fclose($arquivo);
        }

        // Criação do Service
        if(!file_exists('./module/'.$modulo.'/src/'.$modulo.'/Service/')){
            mkdir('./module/'.$modulo.'/src/'.$modulo.'/Service/',0744);
        }
        $arquivo = fopen('./module/'.$modulo.'/src/'.$modulo.'/Service/'.ucfirst($table).'Service.php','w+');
        if ($arquivo) {
            // move o ponteiro para o inicio do arquivo
            rewind($arquivo);


            $contuedo = "<?php
/**
 * namespace para nosso modulo Admin\Service
 */

namespace ".$modulo."\Service;
use Core\Service\AbstractService;
use Doctrine\ORM\EntityManager;

/**
 * class ".$table."Service
 * Responsavel por gerenciar as movimentações na entidade ".$table."
 * @author Winston Hanun Junior <ceo@sisdeve.com.br> skype ceo_sisdeve
 * @copyright (c) 2015, Winston Hanun Junior
 * @link http://www.sisdeve.com.br
 * @version V0.1
 * @package ".$modulo."\Service
 */

class ".$table."Service extends AbstractService
{
    public function __construct(EntityManager #em)
    {
        #this->entity = '$modulo\Entity\|{$table}|';
        parent::__construct(#em);
    }

} ";

            $contuedo = str_replace("#","$",$contuedo);
            $contuedo = str_replace("%","\""  ,$contuedo);
            $contuedo = str_replace("|",""  ,$contuedo);

            if (!fwrite($arquivo, $contuedo)) die('Não foi possível atualizar o arquivo.');
            echo 'Serviço Criado com sucesso<br>';
            fclose($arquivo);
        }


    }



}
