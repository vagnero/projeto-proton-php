<!-- http://protoon.free.nf/ProtoonFinal/index.php -->
<?php
// Inclua o arquivo de configuração do banco de dados e outras dependências
ob_start();
include('../view/header.php');
include('../model/DbConfig.php');
include_once '../controller/LoginMunicipe.php';

// Função para enviar e-mail de recuperação de senha
function enviarEmailRecuperacaoSenha($email, $token) {
    // Mensagem de e-mail
    $assunto = "Recuperação de senha";
    $mensagem = "Olá,\n\nVocê solicitou a recuperação de senha. Clique no link a seguir para redefinir sua senha:\n\n";
    $mensagem .= "http://protoon.com/redefinir_senha.php?token=" . $token . "\n\n";
    $mensagem .= "Se você não solicitou a recuperação de senha, por favor, ignore este e-mail.\n\nAtenciosamente,\nSua empresa";

    // Envio de e-mail
    $headers = "From: suporte@protoon.com";
    mail($email, $assunto, $mensagem, $headers);
}

// Se o formulário for submetido
if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    // Gerar um token único para o e-mail
    $token = md5(uniqid(rand(), true));
    // Salvar o token no banco de dados para este e-mail
    // (Você precisa implementar essa parte)
    // Por enquanto, apenas mostraremos o token
    echo "Token gerado: " . $token;
    // Enviar e-mail de recuperação de senha
    enviarEmailRecuperacaoSenha($email, $token);

    // Redirecionar para uma página de login
    header("Location: login.php");
    exit();
}
?>

  <div class="body">
    <h1 style="margin-top: -10px">Recuperação de Senha</h1>
    <div class="body-form">
        <form action="login.php" method="post">
            <h2 style="margin-top: -10px">Esqueceu sua senha?</h2>
            <p>Informe seu endereço de e-mail para receber as instruções de recuperação de senha.</p>
            <label for="email" class="form-label" style="font-size: 30px">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required><br>
            <button type="submit" style="margin-inline-end: 10px; margin-top: 10px" class="form" onclick="alert('Enviaremos instruções através de seu email')">Enviar Email de Recuperação</button><br>
            
            <!-- INSERIR COMANDO PARA ENVIAR EMAIL PARA O USUÁRIO AO CLICAR NO BOTÃO: Enviar Email de Recuperação-->

            <button type="button" class="btn btn-outline-dark" style="margin-top: 10px" title="Clique para voltar ao inicio do Site" onclick='window.location.href ="index.php"'>Voltar</button><br>
        </form>
    </div>
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