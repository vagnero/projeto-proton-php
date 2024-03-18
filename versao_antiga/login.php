<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-GfEIkVad6C12uJCfNf/GML2gGgkeR5wF6gj1RlzdE2vtA1Ctjz1oKG61U1xW1p9p" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script src="Scripts/script.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="Estilos/style.css">
    <link rel="stylesheet" href="Estilos/header.css">
    <link rel="stylesheet" href="Estilos/button.css">
    <link rel="stylesheet" href="Estilos/footer.css">
    <link rel="stylesheet" href="Estilos/forms.css">

    <title>Proto-On</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #016974;">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php" title="Clique no Logo para ir ao inicio do Site"><img src="Imagens/LogoProto-On.png" alt="Proto-On" style="width: 200px; height: 50px"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">


                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="index.php" title="Voltar a Página inicial do Site">Home</a>
                        </li>

                        <?php

                        if (!isset($_SESSION['id'])) {
                            echo '<li class="nav-item"><a class="nav-link" aria-current="cadastro.php" href="cadastro.php" title="Faça seu cadastro no Site">Cadastrar-se</a> </li>';
                        }
                        ?>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" title="Clique para acessar os serviços" role="button" data-bs-toggle="dropdown" aria-expanded="false">Serviços</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="reclamar.php" title="Abra uma reclamação">Abrir reclamação</a></li>
                                <li><a class="dropdown-item" href="consultar.php" title="Consulte seus protocolos">Consultar protocolos</a></li>
                            </ul>
                        </li>


                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" title="Clique Mais Opções" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mais</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="contato.php" title="Saiba como nos contatar">Contato</a>
                                </li>
                                <li><a class="dropdown-item" href="sobrenos.php" title="Saiba mais sobre nós">Sobre Nós</a>
                                </li>
                            </ul>
                        </li>


                        <li class="nav-item">
                            <button id="leitorBtn" onclick="iniciarLeitor()">
                                <img src="Imagens/altoFalante.png" alt="Leitor de Voz">
                            </button>
                        </li>
                    </ul>


                    <div style="margin-top: 5px;">
                        <form class="d-flex" role="search" style="margin-top: 10px;">
                            <input class="form-control me-2" style="max-width: 200px; max-height: 30px;" type="search" placeholder="Pesquisar" title="Digite uma palavra de busca aqui" aria-label="Search">
                            <button class="btn btn-outline-primary" type="submit" title="Clique para buscar" style="margin-left: 5px; background-color: whitesmoke; max-height: 30px;">
                                <img src="Imagens/Lupa.png" alt="Lupa" class="img-pesquisa" style="max-width: 20px; max-height: 20px; margin-top: -14px;">
                            </button>
                        </form>
                    </div>

                    
                    <div>
                        <?php
                        if (isset($_SESSION['id'])) {
                            echo '<h4 class="logout">' . ($_SESSION['nome'] ?? 'Nome não disponível') . '</h4>';
                            echo '<a href="logout.php" class="logout">Logout<img src="Imagens/logout.png" alt="Logout"
            class="img-logout"></a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>


    <div class="body-form">
        <h1 style="margin-top: 10px; font-size: 30px;">Login</h1>
        <?php
        include('conexao.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['email']) || empty($_POST['email'])) {
                echo "Preencha o seu email";
            } else if (empty($_POST['senha'])) {
                echo "Preencha sua senha";
            } else {
                $email = $mysqli->real_escape_string($_POST['email']);
                $senha = $mysqli->real_escape_string($_POST['senha']);

                $sql_code = "SELECT * FROM municipes WHERE email = '$email' Limit 1";
                $sql_exec = $mysqli->query($sql_code) or die($mysqli->error);

                $quantidade = $sql_exec->num_rows;

                if ($quantidade == 1) {
                    $usuario = $sql_exec->fetch_assoc();

                    if (password_verify($senha, $usuario['senha'])) {
                        if (!isset($_SESSION)) {
                            session_start();
                        }

                        $_SESSION['id'] = $usuario['idMunicipe'];
                        $_SESSION['nome'] = $usuario['nome'];
                        $_SESSION['senha'] = $usuario['senha'];

                        echo "<script>window.location.href='reclamar.php';</script>";
                        exit(); // Garante que o código para de ser executado após o redirecionamento
                    } else {
                        echo "<script> window.onload = function() {alert('Senha incorreta!');};</script>";
                    }
                } else {
                    echo "<script> window.onload = function() {alert('E-mail e senha incorretos!');};</script>";
                }
            }
        }
        ?>

        <form action="" method="post">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control rua" title="Digite aqui o seu email" name="email" size="20">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control rua" title="Digite aqui a sua senha" name="senha" size="20">
            <table>
                <tr>
                    <td>
                        <p style="margin-right: 4vw; margin-top: 1vh"><a href="cadastro.php">Cadastrar-se</a></p>
                    </td>
                    <td>
                        <p style="margin-left: 4vw; margin-top: 1vh"><a href="esqueceu_senha.php">Esqueceu a Senha?</a>
                        </p>
                    </td>
                </tr>
            </table>
            <button type="submit" class="form">Entrar</button>
            <button type="button" class="btn btn-outline-dark voltar" onclick='window.location.href ="index.php"'>Voltar</button>
        </form>
    </div>
    <div class="footer">
        <footer>
            <h6 style="color: white; font-family: 'Arial', sans-serif; font-size: 14px; font-weight: bold;">Powered by Proto-on company inc ©</h6>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="leitor.js"></script>
</body>

</html>