<?php
ob_start(); // inicia o buffer de saída
include('header.php');
?>
<?php

include('../controller/municipe/ControllerMunicipe.php');
include('../controller/endereco/ControllerEndereco.php');
include_once '../controller/municipe/ProtectedMunicipe.php';
$protected = new ProtectedMunicipe();
//TODO: Está bugando essa parte, dando erro no banco de dados, dps temos que arrumar. 
$logado = $protected->estaLogado();

if ($logado != true){
  $protected->retornarParaIndex();
}
$controllerMunicipe = new ControllerMunicipe();
$controllerEndereco = new ControllerEndereco();
$user = $controllerMunicipe->UpdateMunicipeFormData($controllerMunicipe);
$address = $controllerEndereco->UpdateEnderecoFormData($controllerEndereco); //Tentei deixar um padrão em ingles addrees = endereço, mas temos que conversar sobre isso

$dataNasc = $protected->getDataNasc();
$cpf = $protected->getCpf();
$email = $protected->getEmail();
?>

<div class="body-form" style="padding-bottom: 20px">
  <h1 style="margin-top: 10px; font-size: 30px;">Editar Conta</h1>

  <form action="" method="post">
    <div>
      <label for="nome" class="form-label">Nome<span style="color:red " class="required-symbol">*</span>
        <input type="text" class="formsCadastro" required required title="Digite aqui o seu nome" minlength="3" id="nome" name="nome" size="40" value="<?php echo isset($user['nome']) ? $user['nome'] : ''; ?>">
      </label>

      <label for="celular" class="form-label">Celular<span style="color:red " class="required-symbol">*</span>
        <input type="text" class="formsCadastro" required required title="Digite aqui o seu celular" name="celular" placeholder="(XX) XXXXX-XXXX" minlength="9" maxlength="15" name="celular" id="celular" size="40" value="<?php echo isset($user['celular']) ? $user['celular'] : ''; ?>">
      </label>

      <label for="cep" class="form-label">Cep<span style="color:red " class="required-symbol">*</span>
        <input class="formsCadastro" required minlength="9" name="cep" type="text" id="cep" value="<?php echo isset($address['cep']) ? $address['cep'] : ''; ?>" size="10" maxlength="9">
      </label>

      <label for="estado" class="form-label">Estado
        <input class="formsCadastro" name="estado" type="text" maxlength="2" id="estado" size="2" value="<?php echo isset($address['estado']) ? $address['estado'] : ''; ?>">
      </label>
    </div>

    <div style="margin-top: 10px;">
      <label for="cidade" class="form-label">Cidade
        <input class="formsCadastro" name="cidade" type="text" minlength="4" id="cidade" size="40" value="<?php echo isset($address['cidade']) ? $address['cidade'] : ''; ?>">
      </label>

      <label for="bairro" class="form-label">Bairro
        <input class="formsCadastro" name="bairro" type="text" minlength="4" id="bairro" size="40" value="<?php echo isset($address['bairro']) ? $address['bairro'] : ''; ?>">
      </label>

      <label for="rua" class="form-label">Rua
        <input class="formsCadastro" name="rua" type="text" minlength="4" id="rua" size="60" value="<?php echo isset($address['rua']) ? $address['rua'] : ''; ?>">
      </label>

      <label for="numero" class="form-label">Número<span style="color:red " class="required-symbol">*</span>
        <input class="formsCadastro" required maxlength="5" name="numero" type="number" id="numero" size="5" min="1" value="<?php echo isset($address['numero']) ? $address['numero'] : ''; ?>">
      </label>
    </div>

    <div style="margin-top: 10px;">
      <label for="complemento" class="form-label">Complemento
        <input class="formsCadastro" name="complemento" type="text" id="complemento" size="60" value="<?php echo isset($address['complemento']) ? $address['complemento'] : ''; ?>">
      </label>

     
  <label for="cpf" class="form-label">CPF<span style="color:red " class="required-symbol">*</span>
    <input type="text" class="formsCadastro" style="background-color: hwb(0 52% 48% / 0.427);"  required required title="Digite aqui o seu CPF" name="cpf" minlength="11" maxlength="15" name="cpf" id="cpf" size="40" value='<?php echo $cpf ?>' readonly>
  </label>


      <label for="email" class="form-label">Email<span style="color:red " class="required-symbol">*</span>
        <input type="email" class="formsCadastro" style="background-color: hwb(0 52% 48% / 0.427);" required title="Digite aqui o seu email" minlength="11" name="email" id="email" size="20"  value='<?php echo $email ?>' readonly>
      </label>

      <label for="dataNascimento" class="form-label">Data de Nascimento<span style="color:red " class="required-symbol">*</span>
    <input type="date" class="formsCadastro" style="background-color: hwb(0 52% 48% / 0.427);" required required title="Escolha a data em que nasceu" name="dataNascimento" id="dataNascimento" size="40" value='<?php echo $dataNasc ?>' readonly>
  </label>


      <label for="senha" class="form-label">Senha<span style="color:red " class="required-symbol">*</span>
        <input type="password" class="formsCadastro" style="background-color: hwb(0 52% 48% / 0.427);" required minlength="6" title="Digite aqui a sua senha" name="senha" id="senha" size="20" value="" readonly>
      </label>
    </div>

    <div style="margin-top: 30px;">
      <button type="submit" style="margin-inline-end: 10px " class="form" name="Submit">Editar</button>
      <button type="button" class="btn btn-outline-dark" title="Clique para voltar ao inicio do Site" onclick='window.location.href ="../index.php"'>Voltar</button>
    </div>
  </form>
  <?php
  if (isset($_POST['Submit'])) {
    echo "<script>alert('Cadastro Atualizado');</script>";
    echo "<script>window.location.href = '../view/updateMunicipe.php';</script>";
    $controllerMunicipe->UpdateMunicipe($_SESSION['idMunicipe'], $_POST['nome'], $_POST['celular']);
    $controllerEndereco->UpdateEndereco($_SESSION['idMunicipe'], $_POST['cep'], $_POST['estado'], $_POST['cidade'], $_POST['bairro'], $_POST['rua'], $_POST['numero'], $_POST['complemento']);

  }
  ?>
</div>

<?php
include('footer.php');
?>