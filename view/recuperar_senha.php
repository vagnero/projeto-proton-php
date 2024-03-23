<!-- http://protoon.free.nf/ProtoonFinal/index.php -->
<?php
// Inclua o arquivo de configuração do banco de dados e outras dependências
ob_start();
include('header.php');
include('../model/DbConfig.php');
include_once '../controller/municipe/LoginMunicipe.php';

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../lib/vendor/autoload.php';
$mail = new PHPMailer(true);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-GfEIkVad6C12uJCfNf/GML2gGgkeR5wF6gj1RlzdE2vtA1Ctjz1oKG61U1xW1p9p" crossorigin="anonymous"></script>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">

  <link rel="stylesheet" href="Estilos/style.css">
  <link rel="stylesheet" href="Estilos/header.css">
  <link rel="stylesheet" href="Estilos/button.css">
  <link rel="stylesheet" href="Estilos/footer.css">

  <title>Proto-On</title>
</head>

<body>  
  <div class="body">
    <h1 style="margin-top: -10px">Recuperação de Senha</h1>

    <?php
      // Instanciar a classe DbConfig
      $dbConfig = new DbConfig();

      // Obter a conexão
      $conn = $dbConfig->connection;

      $query_create_table = "CREATE TABLE IF NOT EXISTS recuperar (
          id INT(11) AUTO_INCREMENT PRIMARY KEY,
          idMunicipe INT(11) NOT NULL,
          chave VARCHAR(255) NOT NULL
      )";

      $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
      if (!empty($dados['SendRecupSenha'])) {

        $result_usuario = $conn->prepare("SELECT id, nome, email
                                  FROM municipes
                                  WHERE email = ?
                                  LIMIT 1");
        $result_usuario->bind_param('s', $dados['email']);
        $result_usuario->execute();

        if ($result_usuario->error) {
          echo "Link Inválido";
          header("Location: recuperar_senha.php");
        } else {
          $result = $result_usuario->get_result();
          
          $stmt_insert_recuperar = null;
          $stmt_update_recuperar = null;
          // Verificar se a consulta retornou algum resultado
          if ($result->num_rows > 0) {
            $row_usuario = $result->fetch_assoc();
            $chave = password_hash($row_usuario['id'], PASSWORD_DEFAULT);
        
            // Verificar se já existe um registro na tabela recuperar para este usuário
            $query_check_recuperar = "SELECT idMunicipe FROM recuperar WHERE idMunicipe = ?";
            $stmt_check_recuperar = $conn->prepare($query_check_recuperar);
            $stmt_check_recuperar->bind_param('i', $row_usuario['id']);
            $stmt_check_recuperar->execute();
            $result_check_recuperar = $stmt_check_recuperar->get_result();
          
            if ($result_check_recuperar->num_rows > 0) {
                // Se já existe um registro, atualize a chave existente
                $query_update_recuperar = "UPDATE recuperar SET chave = ? WHERE idMunicipe = ?";
                $stmt_update_recuperar = $conn->prepare($query_update_recuperar);
                $stmt_update_recuperar->bind_param('si', $chave, $row_usuario['id']);
                $update_success = $stmt_update_recuperar->execute();

                if ($update_success && $stmt_update_recuperar->affected_rows > 0) {
                  $link = "http://localhost/projeto-proton-php/view/atualizar_senha.php?chave=$chave";
                }
          
            } else {
                // Se não existe um registro, insira um novo
                $query_insert_recuperar = "INSERT INTO recuperar (idMunicipe, chave) VALUES (?, ?)";
                $stmt_insert_recuperar = $conn->prepare($query_insert_recuperar);
                $stmt_insert_recuperar->bind_param('is', $row_usuario['id'], $chave);
                $stmt_insert_recuperar->execute();

                if ($insert_success && $stmt_insert_recuperar->affected_rows > 0) {
                  $link = "http://localhost/projeto-proton-php/view/atualizar_senha.php?chave=$chave";
                }
              }
          
              // Verificar se a atualização ou inserção foi bem-sucedida
              if ($stmt_update_recuperar->affected_rows > 0 || $stmt_insert_recuperar->affected_rows > 0) {
                  // $link = "http://localhost/projeto-proton-php/view/atualizar_senha.php?chave=$chave";

                  // link para acessar o email: https://mailtrap.io/ user: Proto-On Senha: Proto_On123
                  try {
                      //Server settings
                      $mail->CharSet = 'UTF-8';
                      // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                      $mail->isSMTP();                                            //Send using SMTP
                      // $mail->Host       = 'smtp.gmail.com';                       //Set the SMTP server to send through
                      // $mail->Username   = 'email@gmail.com';               //SMTP username
                      // $mail->Password   = 'senha';                            //SMTP password
                      // $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                      $mail->Host       = 'sandbox.smtp.mailtrap.io';                       //Set the SMTP server to send through
                      $mail->Username   = '3d93ca5b1975a2';           //SMTP username
                      $mail->Password   = '57116c1d0e4275';                            //SMTP password
                      $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                      $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable implicit TLS encryption

                      //Recipients
                      $mail->setFrom('wesley@email.com', 'atendimento');  
                      $mail->addAddress($row_usuario['email'], $row_usuario['nome']);

                      //Content
                      $mail->isHTML(true);                                  //Set email format to HTML
                      $mail->Subject = 'Recuperar Senha';
                      $mail->Body = "Prezado(a) {$row_usuario['nome']}.<br>" .
                      "Você solicitou recuperação de sua senha.<br>" .
                      "Clique no link abaixo para criar uma nova senha.<br><br>" .
                      "<a href='{$link}'>Link</a>.<br><br>" .
                      "Se você não solicitou esta recuperação de senha, " .
                      "ignore este email e sua senha permanecerá a mesma.";

                      $mail->AltBody = "Prezado(a) {$row_usuario['nome']}.\n" .
                      "Você solicitou recuperação de sua senha.\n" .
                      "Copie e use este link para criar uma nova senha.\n\n" .
                      "{$link}.\n\n" .
                      "Se você não solicitou esta recuperação de senha, " .
                      "ignore este email e sua senha permanecerá a mesma.";

                      $mail->send();
                      echo "<p style='color: green'>Verifique seu email para recuperar sua senha!";
                  } catch (Exception $e) {
                      echo "Email não enviado. Mailer Error: {$mail->ErrorInfo}";
                  }

              } else {
                  echo "<p style='color: #ff0000'>Erro ao atualizar</p>";
              }
          } else {
              echo "<p style='color: #ff0000'>Email não cadastrado</p>";
          }
          
        }
      }
    ?>


    <div class="body-form">
        <form action="" method="post">
            <h2 style="margin-top: -10px">Esqueceu sua senha?</h2>
            <p>Informe seu endereço de e-mail para receber as instruções de recuperação de senha.</p>
            <label for="email" class="form-label" style="font-size: 30px">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required><br>
            <button type="submit" name="SendRecupSenha" value="Recuperar" style="margin-inline-end: 10px; margin-top: 10px" class="form">Enviar Email de Recuperação</button><br>
            
            <!-- INSERIR COMANDO PARA ENVIAR EMAIL PARA O USUÁRIO AO CLICAR NO BOTÃO: Enviar Email de Recuperação-->

            <button type="button" class="btn btn-outline-dark" style="margin-top: 10px" title="Clique para voltar ao inicio do Site" onclick='window.location.href ="login.php"'>Voltar</button><br>
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