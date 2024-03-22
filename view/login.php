<?php

ob_start();
include('header.php');
include('../model/DbConfig.php');
include_once '../controller/municipe/LoginMunicipe.php';
$loginMunicipe = new LoginMunicipe();
?>
    <div class="body-form">
        <h1 style="margin-top: 10px; font-size: 30px;">Login</h1>

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
            <button type="submit" class="form" name="submit">Entrar</button>
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


<?php
if(isset($_POST['submit'])){
    $loginMunicipe->logar();
}
  include('footer.php');
?>
