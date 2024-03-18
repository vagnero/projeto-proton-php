<?php
session_start();

// Destruir todas as variáveis de sessão
session_destroy();

// Redirecionar para a página de login ou outra página de sua escolha
header("location: login.php");
exit();
?>
