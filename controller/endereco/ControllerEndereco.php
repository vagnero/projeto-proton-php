<!-- ControllerEndereco -->
<?php
include_once(__DIR__ . '/../../model/Crud.php');
include_once(__DIR__ . '/../../model/Validation.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
class ControllerEndereco
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

    public function getEnderecoById($id)
    {
        $id = $this->crud->escape_string($id);

        $query = "SELECT * FROM `enderecos` WHERE idEndereco = '$id'";
        $result = $this->crud->getData($query);

        if (!empty($result)) {
            return $result[0];
        } else {
            return null;
        }
    }

    public function UpdateEndereco($id, $cep, $estado, $cidade, $bairro, $rua, $numero,    $complemento)
    {
        $cep = $this->crud->escape_string($cep);
        $estado = $this->crud->escape_string($estado);
        $cidade = $this->crud->escape_string($cidade);
        $bairro = $this->crud->escape_string($bairro);
        $rua = $this->crud->escape_string($rua);
        $numero = $this->crud->escape_string($numero);
        $complemento = $this->crud->escape_string($complemento);


        $msg = $this->validation->check_empty($_POST, array('id', 'cep', 'estado', 'cidade', 'bairro', 'rua', 'numero', 'complemento'));

        //if ($msg == null) {TO-DO ver verificação
        $query = "UPDATE enderecos SET cep = '$cep', estado = '$estado', cidade = '$cidade', bairro = '$bairro', rua = '$rua', numero = '$numero', complemento = '$complemento' WHERE idEndereco=$id";
        $result = $this->crud->execute($query);
        //}
    }

    public function UpdateEnderecoFormData($controllerEndereco) //Data = Dados ok!
    {
        if (isset($_SESSION['idMunicipe'])) {
            $id = $_SESSION['idMunicipe'];
            $endereco = $controllerEndereco->getEnderecoById($id);
        }
        return $endereco;
    }
}
