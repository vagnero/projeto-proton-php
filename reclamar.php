<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

<?php
include('protect.php');
include('conexao.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #016974;">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php" title="Clique na Logo para ir ao inicio do Site"><img src="Imagens/LogoProto-On.png" alt="Proto-On" style="width: 200px; height: 50px"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

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
    <h1 style="margin-top: 10px; font-size: 30px;">Registre aqui sua reclamação</h1>
    <?php
    if (isset($_POST['problema'])) {

      include('conexao.php');
      $problema = $mysqli->real_escape_string($_POST['problema_text']);
      if ($problema !== '') {
        $descricao = $mysqli->real_escape_string($_POST['descricao']);
        $idMunicipe = $mysqli->real_escape_string($_SESSION['id']);

        if (
          $_POST['rua'] === "..." || $_POST['bairro'] === "..." || $_POST['cidade'] === "..." || $_POST['uf'] === "..." ||
          $_POST['rua'] === "" || $_POST['bairro'] === "" || $_POST['cidade'] === "" || $_POST['uf'] === ""
        ) {

          echo "<h4 style='color: red'>Campos de endereço incompletos. Preencha o CEP corretamente.</h4>";
        } else {
          $cep = $mysqli->real_escape_string($_POST['cep']);
          $estado = $mysqli->real_escape_string($_POST['uf']);
          $cidade = $mysqli->real_escape_string($_POST['cidade']);
          $bairro = $mysqli->real_escape_string($_POST['bairro']);
          $rua = $mysqli->real_escape_string($_POST['rua']);
          $numero = $mysqli->real_escape_string($_POST['numero']);
          $complemento = $mysqli->real_escape_string($_POST['complemento']);

          $sql_enderecos = "INSERT INTO enderecos (cep, estado, cidade, bairro, rua, numero, complemento) VALUES ('$cep', '$estado', '$cidade', '$bairro', '$rua', '$numero', '$complemento')";

          if ($mysqli->query($sql_enderecos) === TRUE) {
            // Recupere o idEndereco gerado
            $idEndereco = $mysqli->insert_id;
            // Insira o usuário associando-o ao idEndereco
            $sql_reclamacoes = "INSERT INTO reclamacoes (problema, descricao, idEndereco, idMunicipe, dataReclamacao, statusAtual) VALUES ('$problema', '$descricao', '$idEndereco', '$idMunicipe', DATE_ADD(NOW(), INTERVAL 2 HOUR), 'Em Análise')";
            if ($mysqli->query($sql_reclamacoes) === TRUE) {
              echo "<script>alert('Problema enviado com sucesso! Notificaremos sobre o andamento do processo, obrigado por nos comunicar essa situação!'); window.location.href='consultar.php';</script>";
            } else {
              echo "<script>alert('Erro ao cadastrar Reclamação:" . $mysqli->error . "'); window.location.href='reclamar.php';</script>";
            }
          } else {
            echo "<script>alert('Erro ao cadastrar endereço:" . $mysqli->error . "'); window.location.href='reclamar.php';</script>";
          }
        }
      } else {
        echo "<script> window.onload = function() {alert('Selecione o tipo de Problema!');};</script>";
      }
    }
    ?>
    <div class="mb-3">
      <form action="" method="post">
        <div class="form-floating" style="height: 80px; width: 150px ; margin-left: 15px; margin-top: 50px;">
          <span id="problema-error" style="color: red;"></span>
          <select class="form-select" id="problema" name="problema" title="Clique para ver todas opções de Problemas disponiveis" aria-label="Floating label select example" onchange="setProblema('problema')">
            <option selected>Problemas</option>
            <option value="1">Buraco</option>
            <option value="2">Iluminação</option>
            <option value="3">Outros</option>
          </select>
        </div>
        <div>
          <input type="hidden" name="problema_text" id="problema_text">

          <label for="cep" class="form-label">Cep<span style="color:red " class="required-symbol">*</span>
            <input class="formsCadastro" style="width: 160px;" required minlength="9" name="cep" type="text" id="cep" value="<?php if (isset($_POST['cep'])) echo $_POST['cep']; ?>" size="10" maxlength="9">
          </label>

          <label for="uf" class="form-label">Estado<span style="color:red" class="required-symbol">*</span>
            <input class="formsCadastro" style="width: 80px;" name="uf" type="text" maxlength="2" id="uf" size="2" value="<?php if (isset($_POST['uf'])) echo $_POST['uf']; ?>">
          </label>

          <label for="cidade" class="form-label">Cidade<span style="color:red " class="required-symbol">*</span>
            <input class="formsCadastro" style="width: 380px;" name="cidade" type="text" minlength="3" id="cidade" size="40" value="<?php if (isset($_POST['cidade'])) echo $_POST['cidade']; ?>">
          </label>


          <label for="bairro" class="form-label">Bairro<span style="color:red " class="required-symbol">*</span>
            <input class="formsCadastro" style="width: 380px;" name="bairro" type="text" minlength="4" id="bairro" size="40" value="<?php if (isset($_POST['bairro']))
                                                                                                                                      echo $_POST['bairro']; ?>">
          </label>
          <div>
            <label for="rua" class="form-label">Rua<span style="color:red;" class="required-symbol">*</span>
              <input class="formsCadastro" style="width: 400px;" name="rua" type="text" minlength="4" id="rua" size="40" value="<?php if (isset($_POST['rua'])) echo $_POST['rua']; ?>">
            </label>

            <label for="numero" class="form-label">Número<span style="color:red " class="required-symbol">*</span>
              <input class="formsCadastro" style="width: 200px;" required maxlength="5" name="numero" type="number" id="numero" min="1" size="5" value="<?php if (isset($_POST['numero'])) echo $_POST['numero']; ?>">
            </label>

            <label for="complemento" class="form-label">Complemento
              <input class="formsCadastro" style="width: 400px;" name="complemento" type="text" id="complemento" size="40" value="<?php if (isset($_POST['complemento'])) echo $_POST['complemento']; ?>">
            </label>
          </div>

          <label class="form-label">
            Descrição do Problema<span style="color:red" class="required-symbol">*</span>
            <div class="form-floating">
              <textarea for="descricao" class="form-control" title="Descreva aqui os detalhes do Problema" style="height: 100px; width: 1010px; box-shadow: 0 4px 8px rgba(10, 134, 103, 0.141);" id="descricao" name="descricao"><?php if (isset($_POST['descricao'])) echo $_POST['descricao']; ?></textarea>
            </div>
          </label>

        </div>
        <div style="margin-top: 20px;">
          <button type="submit" class="form" style="margin-inline-end: 10px">Cadastrar</button>
        </div>
      </form>
    </div>
  </div>

  <div class="footer">
    <footer>
      <h6 style="color: white; font-family: 'Arial', sans-serif; font-size: 14px; font-weight: bold;">Powered by Proto-on company inc ©</h6>
    </footer>
  </div>

  <script src="leitor.js"></script>



</body>

</html>