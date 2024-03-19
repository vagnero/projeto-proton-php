<!-- 
session_start();
-->

<?php

ob_start(); // inicia o buffer de saída
include('header.php');
include('../model/DbConfig.php');
?>

    <div class="body-form">
        <h1 style="margin-top: 10px; font-size: 30px;">Login</h1>
        <?php

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

                        echo "<script> window.onload = function() {alert('TESTE OK');};</script>";
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