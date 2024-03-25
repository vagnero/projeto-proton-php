<?php
// Inclua o arquivo de configuração do banco de dados e outras dependências
ob_start();
include('header.php');
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

  <link rel="stylesheet" href="estilos/style.css">
  <link rel="stylesheet" href="estilos/header.css">
  <link rel="stylesheet" href="estilos/button.css">
  <link rel="stylesheet" href="estilos/footer.css">
  <link rel="stylesheet" href="estilos/formsCadastro.css">
  <link rel="stylesheet" href="estilos/menuLogin.css">
  <link rel="stylesheet" href="estilos/perfil-user.css">

  <title>Proto-On</title>
</head>

<body>
  <style>
    /* Animação para cada letra */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Aplica a animação em cada letra */
    h1 span {
      display: inline-block;
      opacity: 0;
      animation: fadeIn 0.5s ease-out forwards;
    }
  </style>

  </head>

  <div style="padding: 20px; text-align: center">
    <h1 style="margin-top: 200px">
      <span>B</span><span>e</span><span>m</span><span> </span>
      <span>V</span><span>i</span><span>n</span><span>d</span><span>o</span>
      <span> </span><span>a</span><span>o</span><span> </span>
      <span>P</span><span>r</span><span>o</span><span>t</span><span>o</span><span>-</span><span>O</span><span>n</span>
    </h1>
      <button type="button" class="btn btn-outline-primary" title="Clique aqui para fazer Login no Site" onclick='window.location.href ="login.php"'>Voltar</button>
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
<script src="scripts/menuLogin.js"></script>