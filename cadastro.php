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
  <link rel="stylesheet" href="Estilos/formsCadastro.css">

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

            <?php

            if (!isset($_SESSION['id'])) {
              echo '<li class="nav-item"><a class="nav-link" aria-current="cadastro.php" href="index.php" title="Volte ao menu principal">Home</a> </li>';
            }
            ?>

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
    <h1 style="margin-top: 10px; font-size: 30px;">Cadastro de Usuário</h1>
    <?php
    if (isset($_POST['email'])) {
      include('conexao.php');

      $email = $mysqli->real_escape_string($_POST['email']);
      $nome = $mysqli->real_escape_string($_POST['nome']);
      $celular = $mysqli->real_escape_string($_POST['celular']);
      $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

      // Verifique se o e-mail já existe na tabela
      $check_query = "SELECT COUNT(*) FROM municipes WHERE email = '$email'";
      $result = $mysqli->query($check_query);

      if ($result) {
        $count = $result->fetch_row()[0];

        if ($count > 0) {
          // E-mail já cadastrado, informe o usuário
          echo "<h4 style='color: red'>Este e-mail já está cadastrado. Por favor, use outro.</h4>";
        } else {
          if ($_POST['rua'] === "..." || $_POST['bairro'] === "..." || $_POST['cidade'] === "..." || $_POST['uf'] === "...") {
            echo "<h4 style='color: red'>Campos de endereço incompletos. Preencha o CEP corretamente.</h4>";
          } else {
            $cep = $mysqli->real_escape_string($_POST['cep']);
            $estado = $mysqli->real_escape_string($_POST['uf']);
            $cidade = $mysqli->real_escape_string($_POST['cidade']);
            $bairro = $mysqli->real_escape_string($_POST['bairro']);
            $rua = $mysqli->real_escape_string($_POST['rua']);
            $numero = $mysqli->real_escape_string($_POST['numero']);
            $complemento = $mysqli->real_escape_string($_POST['complemento']);
            $sql_endereco = "INSERT INTO enderecos (cep, estado, cidade, bairro, rua, numero, complemento) VALUES ('$cep', '$estado', '$cidade', '$bairro', '$rua', '$numero', '$complemento')";
            if ($mysqli->query($sql_endereco) === TRUE) {
              // Recupere o idEndereco gerado
              $idEndereco = $mysqli->insert_id;
              // Insira o usuário associando-o ao idEndereco
              $sql_usuario = "INSERT INTO municipes (nome, celular, email, senha, idEndereco, dataInscricao) VALUES ('$nome', '$celular', '$email', '$senha', '$idEndereco', DATE_ADD(NOW(), INTERVAL 2 HOUR))";
              if ($mysqli->query($sql_usuario) === TRUE) {
                echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login.php';</script>";
              } else {
                echo "<script>alert('Erro ao cadastrar usuário:" . $mysqli->error . "'); window.location.href='cadastro.php';</script>";
              }
            } else {
              echo "<script>alert('Erro ao cadastrar endereço:" . $mysqli->error . "'); window.location.href='cadastro.php';</script>";
            }
          }
        }
      }
    } else if (isset($_POST['email'])) {
      echo "<script>alert('Erro ao verificar a existência do e-mail:" . $mysqli->error . "'); window.location.href='cadastro.php';</script>";
    }
    ?>

    <form action="" method="post">

      <div>
        <label for="nome" class="form-label">Nome<span style="color:red " class="required-symbol">*</span>
          <input type="text" class="formsCadastro" required required title="Digite aqui o seu nome" minlength="3" id="nome" name="nome" size="40" value="<?php if (isset($_POST['nome'])) echo $_POST['nome']; ?>">
        </label>


        <label for="celular" class="form-label">Celular<span style="color:red " class="required-symbol">*</span>
          <input type="text" class="formsCadastro" required required title="Digite aqui o seu celular" name="celular" placeholder="(XX) XXXXX-XXXX" minlength="9" maxlength="15" name="celular" id="celular" size="40" value="<?php if (isset($_POST['celular'])) echo $_POST['celular']; ?>">
        </label>


        <label for="cep" class="form-label">Cep<span style="color:red " class="required-symbol">*</span>
          <input class="formsCadastro" required minlength="9" name="cep" type="text" id="cep" value="<?php if (isset($_POST['cep'])) echo $_POST['cep']; ?>" size="10" maxlength="9">
        </label>

        <label for="uf" class="form-label">Estado
          <input class="formsCadastro" name="uf" type="text" maxlength="2" id="uf" size="2" value="<?php if (isset($_POST['uf'])) echo $_POST['uf']; ?>">
        </label>
      </div>
      <div style="margin-top: 10px;">
        <label for="cidade" class="form-label">Cidade
          <input class="formsCadastro" name="cidade" type="text" minlength="4" id="cidade" size="40" value="<?php if (isset($_POST['cidade'])) echo $_POST['cidade']; ?>">
        </label>

        <label for="bairro" class="form-label">Bairro
          <input class="formsCadastro" name="bairro" type="text" minlength="4" id="bairro" size="40" value="<?php if (isset($_POST['bairro'])) echo $_POST['bairro']; ?>">
        </label>

        <label for="rua" class="form-label">Rua
          <input class="formsCadastro" name="rua" type="text" minlength="4" id="rua" size="60" value="<?php if (isset($_POST['rua'])) echo $_POST['rua']; ?>">
        </label>

        <label for="numero" class="form-label">Número<span style="color:red " class="required-symbol">*</span>
          <input class="formsCadastro" required maxlength="5" name="numero" type="number" id="numero" size="5" min="1" value="<?php if (isset($_POST['numero'])) echo $_POST['numero']; ?>">
        </label>
      </div>

      <div style="margin-top: 10px;">
        <label for="complemento" class="form-label">Complemento
          <input class="formsCadastro" name="complemento" type="text" id="complemento" size="60" value="<?php if (isset($_POST['complemento'])) echo $_POST['complemento']; ?>">
        </label>

        <label for="email" class="form-label">Email<span style="color:red " class="required-symbol">*</span>


          <input type="email" class="formsCadastro" required title="Digite aqui o seu email" minlength="11" name="email" id="email" size="20" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>">
        </label>


        <label for="senha" class="form-label">Senha<span style="color:red " class="required-symbol">*</span>
          <input type="password" class="formsCadastro" required minlength="6" title="Digite aqui a sua senha" name="senha" id="senha" size="20" value="<?php if (isset($_POST['senha'])) echo $_POST['senha']; ?>">
        </label>
      </div>

      <div style="margin-top: 30px;">
        <button type="submit" style="margin-inline-end: 10px " class="form">Cadastrar</button>
        <button type="button" class="btn btn-outline-dark" title="Clique para voltar ao inicio do Site" onclick='window.location.href ="index.php"'>Voltar</button>
      </div>
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