document.addEventListener('DOMContentLoaded', function () {
    var ativarLeitor = localStorage.getItem('ativarLeitor') === 'true';
    var leitorBtn = document.getElementById('leitorBtn');
    var mensagemAcessibilidade = "Acessibilidade de voz ligada";
    var mensagemDesativarAcessibilidade = "Acessibilidade de voz desligada";

    if (ativarLeitor) {
        document.addEventListener('mouseover', mouseOverHandler);
    }

    leitorBtn.addEventListener('click', function () {
        ativarLeitor = !ativarLeitor;
        localStorage.setItem('ativarLeitor', ativarLeitor);
        if (ativarLeitor) {
            document.addEventListener('mouseover', mouseOverHandler);
            lerMensagemAcessibilidade();
        } else {
            document.removeEventListener('mouseover', mouseOverHandler);
            // Pode adicionar uma mensagem ao desativar, se desejar
            desativarAcessibilidade();
        }
    });

    // Adiciona um evento de tecla para detectar a tecla Tab
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Tab') {
            // Aguarda um pequeno período antes de ler o elemento focado
            setTimeout(function () {
                lerElementoFocado();
            }, 100);
        }
    });

    function mouseOverHandler(event) {
        var elemento = event.target;
        var textoParaLer = obterTextoDoElemento(elemento);
        if (textoParaLer) {
            var utterance = new SpeechSynthesisUtterance(textoParaLer);
            window.speechSynthesis.speak(utterance);
        }
    }

    function obterTextoDoElemento(elemento) {
        // Lógica para obter o texto do elemento
        // Pode variar dependendo do tipo de elemento
        // Este é apenas um exemplo
        if (elemento.tagName === 'P') {
            return elemento.innerText;
        } else if (elemento.tagName === 'A') {
            return elemento.innerText;
        } else if (elemento.tagName === 'BUTTON') {
            return elemento.innerText;
        } else if (elemento.tagName === 'IMG' && elemento.alt) {
            return elemento.alt;
        }else if (elemento.tagName === 'LABEL'){
            return elemento.innerText;
        }
        // Adicione mais casos conforme necessário

        // Se não houver um caso correspondente, retorne null
        return null;
    }

    function lerMensagemAcessibilidade() {
        var utterance = new SpeechSynthesisUtterance(mensagemAcessibilidade);
        window.speechSynthesis.speak(utterance);
    }

     function desativarAcessibilidade() {
        var utterance = new SpeechSynthesisUtterance(mensagemDesativarAcessibilidade);
        window.speechSynthesis.speak(utterance);
    }

    function lerElementoFocado() {
        var elementoFocado = document.activeElement;
        var textoParaLer = obterTextoDoElemento(elementoFocado);

        if (textoParaLer) {
            var utterance = new SpeechSynthesisUtterance(textoParaLer);
            window.speechSynthesis.speak(utterance);
            mensagemLida = true;
        }
    }

});
