<!-- http://protoon.free.nf/ProtoonFinal/index.php -->
<?php
// Inclua o arquivo de configuração do banco de dados e outras dependências
ob_start();
include('header.php');
include('../model/DbConfig.php');
include_once '../controller/LoginMunicipe.php';
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
    <h1 style="margin-top: -10px">Atualizar Senha</h1>

    <?php
      $dbConfig = new DbConfig();
      $conn = $dbConfig->connection;
      $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);

      $query_usuario = "SELECT idMunicipe
                        FROM recuperar
                        WHERE chave = ?
                        LIMIT 1";
        $result_usuario = $conn->prepare($query_usuario);
        $result_usuario->bind_param('s', $chave);
        $result_usuario->execute();

        if ($result_usuario->error) {
          echo "Erro ao executar a consulta: " . $result_usuario->error;
        } else {
          $result = $result_usuario->get_result();
          if ($result->num_rows === 0) {
            echo "<p style='color: #ff0000'>Link inválido, solicite novamente um link!</p>";
            echo "<button onclick='window.location.href=\"recuperar_senha.php\"'>Voltar para recuperação de senha</button>";
            // Matar o restante do body para impedir que o formulário seja exibido
            die();
          } else {
            $row = $result->fetch_assoc(); // Obter os dados como um array associativo

            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if (!empty($dados['SendNovaSenha'])) {
              $nova_senha = password_hash($dados['senha'], PASSWORD_DEFAULT);
              $nova_chave = password_hash($chave, PASSWORD_DEFAULT);;

              $query_atualizar = "UPDATE municipes SET senha = ? WHERE id = ?";
              $atualizar = $conn->prepare($query_atualizar);
              $atualizar->bind_param('si', $nova_senha, $row['idMunicipe']);
              
              $query_apagar_chave = "UPDATE recuperar SET chave = ? WHERE idMunicipe = ?";
              $apagar_chave = $conn->prepare($query_apagar_chave);
              $apagar_chave->bind_param('si', $nova_chave, $row['idMunicipe']);// Altera para uma chave desconhecida impedindo o reuso

              if ($atualizar->execute() && $apagar_chave->execute()) {
                if ($atualizar->execute()) {
                    echo '<script>alert("Senha atualizada com Sucesso!"); window.location.href = "login.php";</script>';
                } else {
                    echo "Tente novamente";
                }                       
              }
          }
        }
      }
    ?>

    <div class="body-form">
        <form action="" method="post">
            <label for="senha" class="form-label" style="font-size: 30px">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite a nova senha" required><br>
            <button type="submit" name="SendNovaSenha" value="Atualizar" style="margin-inline-end: 10px; margin-top: 10px" class="form">Salvar nova senha</button><br>
        </form>
        <p style="margin: auto; text-align: center"><a href="recuperar_senha.php" style="text-decoration: none">Voltar</a>
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