<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha384-GfEIkVad6C12uJCfNf/GML2gGgkeR5wF6gj1RlzdE2vtA1Ctjz1oKG61U1xW1p9p" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <script src="../scripts/script.js"></script>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">


  <link rel="stylesheet" href="../estilos/style.css">
  <link rel="stylesheet" href="../estilos/button.css">
  <link rel="stylesheet" href="../estilos/footer.css">
  <link rel="stylesheet" href="../estilos/formsCadastro.css">
  <link rel="stylesheet" href="../estilos/perfil-user.css">
  <link rel="stylesheet" href="../estilos/menuLogin.css">
  <link rel="stylesheet" href="estilos/perfil-user.css">  

  <title>Proto-On</title>
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #016974;">
        <div class="container-fluid">
          <a class="navbar-brand" href="../index.php" title="Clique no Logo para ir ao inicio do Site"><img src="../imagens/LogoProto-On.png" alt="Proto-On" style="width: 200px; height: 50px"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

              <?php
              include_once "../controller/municipe/ProtectedMunicipe.php";
              $protected = new ProtectedMunicipe();
              $logado = $protected->estaLogado();
              
              echo '<li class="nav-item"><a class="nav-link" aria-current="cadastro.php" href="../index.php" title="Volte ao menu principal">Home</a> </li>';
              
              if (!$logado) {
                echo '<li class="nav-item"><a class="nav-link" aria-current="cadastro.php" href="cadastro.php" title="Faça seu cadastro no Site">Cadastrar-se</a> </li>';
              }
              ?>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" title="Clique para acessar os serviços" role="button" data-bs-toggle="dropdown" aria-expanded="false">Serviços</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="abrir_reclamacao.php" title="Abra uma reclamação">Abrir reclamação</a></li>
                  <li><a class="dropdown-item" href="consultar.php" title="Consulte seus protocolos">Consultar protocolos</a></li>
                </ul>
              </li>

              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" title="Clique Mais Opções" role="button" data-bs-toggle="dropdown" aria-expanded="false">Mais</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="contato.php" title="Saiba como nos contatar">Contato</a>
                  </li>
                  <li><a class="dropdown-item" href="sobre_nos.php" title="Saiba mais sobre nós">Sobre Nós</a>
                  </li>
                </ul>
              </li>

              <li class="nav-item">
                <button id="leitorBtn" onclick="iniciarLeitor()">
                  <img src="../imagens/altoFalante.png" alt="Leitor de Voz">
                </button>
              </li>
            </ul>

            <div style="margin-top: 5px;">
              <form class="d-flex" role="search" style="margin-top: 10px;">
                <input class="form-control me-2" style="max-width: 200px; max-height: 30px;" type="search" placeholder="Pesquisar" title="Digite uma palavra de busca aqui" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit" title="Clique para buscar" style="margin-left: 5px; background-color: whitesmoke; max-height: 30px;">
                  <img src="../imagens/Lupa.png" alt="Lupa" class="img-pesquisa" style="max-width: 20px; max-height: 20px; margin-top: -14px;">
                </button>
              </form>
            </div>

            <div>

            </div>
            
            <div>
              <?php
              if ($logado) {
               
                echo "
                <div class='avatar-container'>
                    <div class='avatar' id='avatar'>
                    
                        <img class='cidadao' id='cidadao' src='../imagens/cidadao.jpg' alt='Foto do Usuário'>
                    </div>
                    <div class='menu' id='menu'>
                        <ul>
                            <div class ='perfilMenu'>
                            <li><a href='updateMunicipe.php' style='font-weight: bold;'>Perfil</a></li>
                            <li><a href='../view/suporte-cliente.php' style='font-weight: bold;'>Suporte</a></li>
                            <li><a href='../controller/municipe/LogoutMunicipe.php' style='font-weight: bold;'>Sair</a></li>
                            </div>
                        </ul>
                    </div>
                </div>";
              }
              ?>
            </div>

          </div>
        </div>
      </nav>
    </header>
    <script src="../scripts/menuLogin.js"></script>
    <script src="../scripts/leitor.js"></script> 