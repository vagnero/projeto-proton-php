<?php 
    $usuario = 'if0_35203111';
    $senha = 'ZegWBMJ6ueyK';
    $database = 'if0_35203111_protoon';
    $host = 'sql112.infinityfree.com';

    $mysqli = new mysqli($host, $usuario, $senha, $database);

    if ($mysqli->error) {
        die("Falha ao conectar ao banco de dados". $mysqli->error);
    }
?>