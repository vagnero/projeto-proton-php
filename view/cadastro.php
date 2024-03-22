<?php

    ob_start(); // inicia o buffer de saída
    include('header.php');
?>

<?php
    include_once '../controller/ControllerMunicipe.php';
    $controllerMunicipe = new ControllerMunicipe();
?>
<div class="body-form">
    <h1 style="margin-top: 10px; font-size: 30px;">Cadastro de Usuário</h1>

    <form action=""  method="post">

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

  <label for="estado" class="form-label">Estado
    <input class="formsCadastro" name="estado" type="text" maxlength="2" id="uf" size="2" value="<?php if (isset($_POST['estado'])) echo $_POST['estado']; ?>">
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
  <button type="submit" style="margin-inline-end: 10px " class="form" name="Submit">Cadastrar</button>
  <button type="button" class="btn btn-outline-dark" title="Clique para voltar ao inicio do Site" onclick='window.location.href ="index.php"'>Voltar</button>
</div>
</form>
<?php  
if(isset($_POST['Submit'])){
  echo"Chegou aqui";
    $controllerMunicipe->registerMunicipe();
}


?>
</div>

<?php
  include('footer.php');
?>