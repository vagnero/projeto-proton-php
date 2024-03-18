<?php 

if (!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['senha']) && basename($_SERVER['PHP_SELF']) != 'index.php' && basename($_SERVER['PHP_SELF']) != 'contato.php' && basename($_SERVER['PHP_SELF']) != 'sobrenos.php') {
        die("<h1 style='font-size: 2em; margin-top: 5vw'>Você não pode acessar esta página porque não está logado</h1>
        </p><button type='button' class='btn btn-outline-success' title='Clique aqui para voltar ao Inicio do Site'
        onclick=\"window.location.href ='login.php'\">Logar</button>");
    }

?>