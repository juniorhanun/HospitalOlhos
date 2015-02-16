/**
 * plugin typeahead Busca Nome Admin
 */
$(function (){
    $('input.typeahead').typeahead({
        ajax: {
            url: '/app-admin/admin/pesquisa',    // url do serviço AJAX
            triggerLength: 2,                   // mínimo de caracteres
            displayField: 'nome'                // campo do JSON utilizado de retorno
        }
    });
});
// Busca Cep
$(document).ready(function() {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#endereco").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
        $("#ibge").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável com valor do campo "cep".
        var cep = $(this).val();

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{5}-?[0-9]{3}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#endereco").val("...")
                $("#bairro").val("...")
                $("#cidade").val("...")
                $("#estado").val("...")
                $("#ibge").val("...")

                //Consulta o webservice viacep.com.br/
                $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#endereco").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#estado").val(dados.uf);
                        $("#ibge").val(dados.ibge);
                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
});

// Exibe as Mensagens
/**
 * efeito alert
 */
$(function () {
    // pegar elemente com corpo da mensagem
    var corpo_alert = $("#alert-message");

    // verificar se o elemente esta presente na pagina
    if (corpo_alert.length)
    // gerar efeito para o elemento encontrado na pagina
        corpo_alert.fadeOut().fadeIn().fadeOut().fadeIn();
});
