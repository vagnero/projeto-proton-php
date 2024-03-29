
<?php

ob_start();
include('header.php');
include('../model/DbConfig.php');
include_once '../controller/municipe/LoginMunicipe.php';
include_once "../controller/municipe/ProtectedMunicipe.php";
$loginMunicipe = new LoginMunicipe();
$protected = new ProtectedMunicipe();
if ($protected->estaLogado()){
    $protected->retornarParaIndex();
}

$dbConfig = new DbConfig();

// Obter a conexão
$conn = $dbConfig->connection;

$query_create_table_municipes = "CREATE TABLE IF NOT EXISTS municipes (
    idMunicipe int(11) NOT NULL AUTO_INCREMENT,
    nome varchar(255) CHARACTER SET utf8 NOT NULL,
    cpf varchar(15) NOT NULL UNIQUE,
    celular varchar(15) NOT NULL UNIQUE,
    dataNascimento DATE,
    dataInscricao datetime NOT NULL,
    idEndereco int(11) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    senha varchar(255) NOT NULL,
    PRIMARY KEY (idMunicipe)
) ENGINE=MyISAM DEFAULT CHARSET=latin1";

$query_create_table_enderecos = "CREATE TABLE IF NOT EXISTS enderecos (
    idEndereco int(11) NOT NULL AUTO_INCREMENT,
    cep varchar(10) DEFAULT NULL,
    estado varchar(2) CHARACTER SET utf8 DEFAULT NULL,
    cidade varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    bairro varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    rua varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    numero varchar(10) DEFAULT NULL,
    complemento varchar(255) CHARACTER SET utf8 DEFAULT NULL,
    PRIMARY KEY (idEndereco)
) ENGINE=MyISAM DEFAULT CHARSET=latin1";

$conn->query($query_create_table_municipes);
$conn->query($query_create_table_enderecos);


?>
    <div class="body-form">
        <h1 style="margin-top: 10px; font-size: 30px;">Login</h1>

        <form action="" method="post">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control rua" title="Digite aqui o seu email" name="email" size="20" 
            value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control rua" title="Digite aqui a sua senha" name="senha" size="20"
            value="<?php if (isset($_POST['senha'])) echo $_POST['senha']; ?>">
            <table>
                <tr>
                    <td>
                        <p style="margin-right: 4vw; margin-top: 1vh"><a href="cadastro.php">Cadastrar-se</a></p>
                    </td>
                    <td>
                        <p style="margin-left: 4vw; margin-top: 1vh"><a href="recuperar_senha.php">Esqueceu a Senha?</a>
                        </p>
                    </td>
                </tr>
            </table>
            <button type="submit" class="form" name="submit">Entrar</button>
            <button type="button" class="btn btn-outline-dark voltar" onclick='window.location.href ="../index.php"'>Voltar</button>
        </form>
    </div>
    <div class="footer">
        <footer>
            <h6 style="color: white; font-family: 'Arial', sans-serif; font-size: 14px; font-weight: bold;">Powered by Proto-on company inc ©</h6>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="leitor.js"></script>


<?php
if(isset($_POST['submit'])){
    $loginMunicipe->logar();
}
  include('footer.php');
?>
