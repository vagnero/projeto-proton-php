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

  <title>Proto-On</title>
</head>

<?php
include('protect.php');
?>

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
              echo '<li class="nav-item"><a class="nav-link" aria-current="index.php" href="cadastro.php" title=""Voltar a Página inicial do Site">Home</a> </li>';
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
  <div class="body consultar">
    <div class="container">
      <?php
      include('conexao.php');

      // ID do usuário logado
      $idMunicipe = $_SESSION['id'];
      // Consulta SQL para buscar as reclamações associadas a esse usuário
      $sql = "SELECT r.*, e.*, m.*
        FROM reclamacoes r
        LEFT JOIN enderecos e ON r.idEndereco = e.idEndereco
        LEFT JOIN municipes m ON r.idMunicipe = m.idMunicipe
        WHERE r.idMunicipe = $idMunicipe";
      $result = $mysqli->query($sql);

      // Verifica se houve resultados
      if ($result->num_rows > 0) {

        // Exibe as reclamações
        while ($row = $result->fetch_assoc()) {
          $dataReclamacao = $row['dataReclamacao'];
          $dataFormatada = date('d/m/Y', strtotime($dataReclamacao));
          echo "Data da Reclamação: " . $dataFormatada . "<br>";
          echo "Protocolo nº: " . $row['idReclamacao'] . "/" . date('Y', strtotime($dataReclamacao)) . "<br>";
          echo "Problema: " . $row['problema'] . "<br>";
          echo "Descrição: " . $row['descricao'] . "<br>";
          echo "Requerente: " . $row['nome'] . "<br>";
          echo "Bairro: " . $row['bairro'] . "<br>";
          echo "Status Atual: " . $row['statusAtual'] . "<br>";
          echo '<hr>';
        }
      } else {
        echo "<h1>Você não fez nenhuma reclamação ainda!</h1>";
      }
      ?>
    </div>
    <button type="button" style="margin-top: 30px;" class="btn btn-outline-dark voltar" onclick='window.location.href ="reclamar.php"'>Voltar</button>
  </div>
  <br>
  <br>
  <div class="footer">
    <footer>
      <h6 style="color: white; font-family: 'Arial', sans-serif; font-size: 14px; font-weight: bold;">Powered by Proto-on company inc ©</h6>
    </footer>
  </div>
  <script src="leitor.js"></script>
</body>

</html>