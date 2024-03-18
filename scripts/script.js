
function setEndereco(cep) {
    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#rua").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#uf").val("");
    }

    // Quando o campo cep perde o foco.
    $(cep).blur(function () {
        // Nova variável "cep" somente com dígitos.
        var cepValue = this.value.replace(/\D/g, '');

        // Verifica se campo cep possui valor informado.
        if (cepValue !== "") {
            // Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            // Valida o formato do CEP.
            if (validacep.test(cepValue)) {
                // Preenche os campos com "..." enquanto consulta webservice.
                $("#rua").val("...");
                $("#bairro").val("...");
                $("#cidade").val("...");
                $("#uf").val("...");

                // Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/" + cepValue + "/json/?callback=?", function (dados) {
                    if (!("erro" in dados)) {
                        // Atualiza os campos com os valores da consulta.
                        $("#rua").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#cidade").val(dados.localidade);
                        $("#uf").val(dados.uf);
                    } else {
                        // CEP pesquisado não foi encontrado.
                        limpa_formulário_cep();
                        alert("CEP não encontrado.");
                    }
                });
            } else {
                // CEP é inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } else {
            // CEP sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
}



function setCelular(celular) { // Função que auxulia no preenchimento do campo do Celular
    const telefoneInput = document.getElementById(celular);
    telefoneInput.addEventListener('input', function () {
        let value = this.value;
        value = value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        if (value.length > 0) {
            value = '(' + value;
        }
        if (value.length > 3) {
            value = value.substring(0, 3) + ') ' + value.substring(3);
        }
        if (value.length > 10) {
            value = value.substring(0, 10) + '-' + value.substring(10);
        }
        this.value = value;
    });
}

function setCep(cep) { // Função que auxulia no preenchimento do campo do CEP
    const cepInput = document.getElementById(cep);
    cepInput.addEventListener('input', function () {
        let value = this.value;
        value = value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
        if (value.length > 5) {
            value = value.substring(0, 5) + '-' + value.substring(5);
        }
        this.value = value;
    });
}

function setProblema(problema) {
    var selectElement = document.getElementById(problema);
    var selectedText = selectElement.options[selectElement.selectedIndex].textContent;
    var problemaTextElement = document.getElementById('problema_text');

    // Verifica se a opção selecionada não é a padrão "Problemas"
    if (selectedText !== "Problemas") {
        problemaTextElement.value = selectedText;
        document.getElementById('problema-error').textContent = ''; // Limpa a mensagem de erro
    } else {
        problemaTextElement.value = ''; // Limpa o valor se "Problemas" for selecionado
        document.getElementById('problema-error').textContent = 'Por favor, selecione um problema'; // Exibe mensagem de erro
    }
}

document.addEventListener('DOMContentLoaded', function () {
    if (window.location.pathname.includes("/cadastro.php")) {
        setCelular('celular');
        setEndereco('#cep');
        setCep('cep');
    }

    if (window.location.pathname.includes("/reclamar.php")) {
        setProblema('problema');
        setEndereco('#cep');
        setCep('cep');
    }
});
