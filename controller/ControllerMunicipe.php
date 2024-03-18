<!-- ControllerMunicipe -->
<?php
include_once(__DIR__ . '/../model/Crud.php');
include_once(__DIR__ . '/../model/Validation.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ControllerMunicipe{
    private $crud; //objeto crud criado no model
    private $validation; //objeto validation criado no model

    public function __construct(){
        $this->crud = new Crud(); //instâcia o objeto crud
        $this->validation = new Validation(); //instância o objeto validation
    }

    
    public function registerEndereco(){
        if (isset($_POST['Submit'])){ 
            $cep = $this->crud->escape_string($_POST['cep']);
            $uf = $this->crud->escape_string($_POST['uf']);
            $cidade = $this->crud->escape_string($_POST['cidade']);
            $bairro = $this->crud->escape_string($_POST['bairro']);
            $rua = $this->crud->escape_string($_POST['rua']);
            $numero = $this->crud->escape_string($_POST['numero']);
            $complemento = $this->crud->escape_string($_POST['complemento']);
            $sql_endereco = "INSERT INTO enderecos (cep, uf, cidade, bairro, rua, numero, complemento) VALUES ('$cep', '$uf', '$cidade', '$bairro', '$rua', '$numero', '$complemento')";
            
            $msgEndereco = $this->validation->check_empty($_POST, array('cep', 'uf', 'cidade', 'bairro', 'rua', 'numero', 'complemento'));
            
            if ($msgEndereco == null){
                $query = $this->crud->excecute("INSERT INTO Endereco(rua, bairro, cidade, uf, cep, nrEndereco, complemento)
                VALUES('$cep', '$uf', '$cidade', '$bairro', '$rua', '$numero', '$complemento')");
                if($query){
                    return $this->crud->getLastInsertId();
                }else{
                    echo "<h4 style='color: red'>Campos de endereço incompletos. Preencha o CEP corretamente.</h4>";
                    return 0;
                }
            }
        }
    }

    public function registerMunicipe(){ //Função para adicionar municipes no banco de dados
        if (isset($_POST['email'])) { //se entrar o submit, a função excecuta
            $email = $this->crud->escape_string($_POST['email']);
            $nome = $this->crud->escape_string($_POST['nome']);
            $celular = $this->crud->escape_string($_POST['celular']);
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
      
            // Verifique se o e-mail já existe na tabela
            $check_query = "SELECT COUNT(*) FROM municipes WHERE email = '$email'";
            $result = $this->crud->query($check_query);

            if ($result) {
                $count = $result->fetch_row()[0];
        
                if ($count > 0) {
                  // E-mail já cadastrado, informe o usuário
                  echo "<h4 style='color: red'>Este e-mail já está cadastrado. Por favor, use outro.</h4>";
                } else {
                    $idEndereco= $this->registerEndereco();
                    if($idEndereco>0){
                        $sql_municipe = "INSERT INTO municipes (nome, celular, email, senha, idEndereco, dataInscricao) VALUES ('$nome', '$celular', '$email', '$senha', '$idEndereco', DATE_ADD(NOW(), INTERVAL 2 HOUR))";
                        if($this->crud->excecute($sql_municipe)){
                            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login.php';</script>";
                        }else{
                            echo "<script>alert('Erro ao cadastrar usuário:" . $this->crud->error . "'); window.location.href='cadastro.php';</script>";
                        }
                    }else{
                        echo "<script>alert('Erro ao cadastrar endereço:" . $this->crud->error . "'); window.location.href='cadastro.php';</script>";
                    }
                }
            }
        }
    }
    public function UpdateMunicipe(){ // TODO: Função para atualizar municipes no banco de dados
        if (isset($_POST['Submit'])) {

    }
}
?>