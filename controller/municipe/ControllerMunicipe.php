<!-- ControllerMunicipe -->
<?php
include_once(__DIR__ . '/../../model/Crud.php');
include_once(__DIR__ . '/../../model/Validation.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
class ControllerMunicipe
{
    private $crud; //objeto crud criado no model
    private $validation; //objeto validation criado no model

    public function __construct()
    {
        $this->crud = new Crud(); //instâcia o objeto crud
        $this->validation = new Validation(); //instância o objeto validation
    }


    public function registerEndereco()
    {
        if (isset($_POST['Submit'])) {
            $cep = $this->crud->connection->escape_string($_POST['cep']);
            $estado = $this->crud->escape_string($_POST['estado']);
            $cidade = $this->crud->connection->escape_string($_POST['cidade']);
            $bairro = $this->crud->connection->escape_string($_POST['bairro']);
            $rua = $this->crud->connection->escape_string($_POST['rua']);
            $numero = $this->crud->connection->escape_string($_POST['numero']);
            $complemento = $this->crud->connection->escape_string($_POST['complemento']);
            $sql_endereco = "INSERT INTO enderecos (cep, estado, cidade, bairro, rua, numero, complemento) VALUES ('$cep', '$estado', '$cidade', '$bairro', '$rua', '$numero', '$complemento')";

            $msgEndereco = $this->validation->check_empty($_POST, array('cep', 'estado', 'cidade', 'bairro', 'rua', 'numero', 'complemento'));

            if ($msgEndereco == null) {
                $query = $this->crud->execute("INSERT INTO enderecos(cep, estado, cidade, bairro, rua, numero, complemento)
                VALUES('$cep', '$estado', '$cidade', '$bairro', '$rua', '$numero', '$complemento')");
                if ($query) {
                    return $this->crud->getLastInsertId();
                } else {
                    echo "<h4 style='color: red'>Campos de endereço incompletos. Preencha o CEP corretamente.</h4>";
                    return 0;
                }
            }
        }
    }

    public function registerMunicipe()
    { //Função para adicionar municipes no banco de dados
        if (isset($_POST['email'])) { //se entrar o submit, a função excecuta
            $email = $this->crud->escape_string($_POST['email']);
            $nome = $this->crud->escape_string($_POST['nome']);
            $celular = $this->crud->escape_string($_POST['celular']);
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $dataNasc = $this->crud->escape_string($_POST['dataNascimento']);
            $cpf = $this->crud->escape_string($_POST['cpf']);
            // Verifique se o e-mail já existe na tabela
            $check_query = "SELECT COUNT(*) FROM municipes WHERE email = '$email'";
            $result = $this->crud->connection->query($check_query);

            if ($result) {
                $count = $result->fetch_row()[0];

                if ($count > 0) {
                    // E-mail já cadastrado, informe o usuário
                    echo "<h4 style='color: red'>Este e-mail já está cadastrado. Por favor, use outro.</h4>";
                } else {
                    $idEndereco = $this->registerEndereco();
                    if ($idEndereco > 0) {
                        $sql_municipe = "INSERT INTO municipes (nome, cpf, celular, dataNascimento, dataInscricao, idEndereco, email, senha) VALUES ('$nome', '$cpf', '$celular', '$dataNasc', DATE_ADD(NOW(), INTERVAL 2 HOUR), '$idEndereco', '$email', '$senha')";
                        if ($this->crud->execute($sql_municipe)) {
                            echo "<script>alert('Usuário cadastrado com sucesso!'); window.location.href='login.php';</script>";
                        } else {
                            echo "<script>alert('Erro ao cadastrar usuário:" . $this->crud->connection->error . "'); window.location.href='cadastro.php';</script>";
                        }
                    } else {
                        echo "<script>alert('Erro ao cadastrar endereço:" . $this->crud->connection->error . "'); window.location.href='cadastro.php';</script>";
                    }
                }
            }
        }
    }

    public function getMunicipeById($id)
    {
        $id = $this->crud->escape_string($id);

        $query = "SELECT * FROM `municipes` WHERE idMunicipe = '$id'";
        $result = $this->crud->getData($query);

        if (!empty($result)) {
            return $result[0];
        } else {
            return null;
        }
    }

    public function UpdateMunicipe($id, $nome, $celular)
    {
        $nome = $this->crud->escape_string($nome);
        $celular = $this->crud->escape_string($celular);
        $msg = $this->validation->check_empty($_POST, array('nome', 'celular'));

        if ($msg == null) {
        $query = "UPDATE municipes SET nome='$nome', celular='$celular' WHERE idMunicipe=$id";
        $result = $this->crud->execute($query);
        }
    }

    public function UpdateMunicipeFormData($controllerMunicipe)
    {
        $municipe = null; //Precisou colocar null pra resolver o erro, pois se não tivesse logado, não havia retorno gerando erro
        if (isset($_SESSION['idMunicipe'])) {
            $id = $_SESSION['idMunicipe'];
            $municipe = $controllerMunicipe->getMunicipeById($id);
        }
        return $municipe;
    }
    
    
    
    
}
