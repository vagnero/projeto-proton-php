<link rel="stylesheet" href="../estilos/forms.css">
<?php

include_once(__DIR__ . '/../../model/DbConfig.php');
include_once(__DIR__ . '/../../model/Crud.php');
include_once(__DIR__ . '/../../model/Validation.php');
include_once(__DIR__ . '/../../controller/municipe/ControllerMunicipe.php');

class LoginMunicipe
{
    private $crud;
    private $validation;

    public function __construct()
    {
        $this->crud = new Crud();
        $this->validation = new Validation();
    }

    public function login($email, $senha)
    {
        $email = $this->crud->escape_string($email);
        $senha = $this->crud->escape_string($senha);

        $result = $this->crud->select("SELECT senha FROM municipes WHERE email = '$email'");

        if ($result) {
            $senhaArm = $result[0]['senha'];
            if (password_verify($senha, $senhaArm)) {
                return true;
            }
        }
        return false;
    }

    public function logar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $userMunicipe = new ControllerMunicipe();

            if ($this->login($email, $senha)) {
                $queryId = "SELECT idMunicipe FROM municipes WHERE email = '$email'";
                $resultQuery = $this->crud->getData($queryId);

                if (!empty($resultQuery)) {
                    $idMunicipe = $resultQuery[0]['idMunicipe'];
                    $result = $userMunicipe->getMunicipeById($idMunicipe);
                    if (!empty($result)) {
                        // session_start();
                        $_SESSION['nome'] = $result['nome'];
                        $_SESSION['email'] = $result['email'];
                        $_SESSION['cpf'] = $result['cpf'];
                        $_SESSION['dataNascimento'] = $result['dataNascimento'];
                        $_SESSION['idMunicipe'] = $idMunicipe;
                        $_SESSION['idEndereco'] = $result['idEndereco'];

                        header('Location: ../view/redirecionamentoTeste.php');
                    }
                }
                header('Location: ../index.php');
            } else {
                echo "<script>alert('Email e/ou Senha incorretos'); window.location.href='../../view/login.php';</script>";
                // var_dump($result); //PARA TESTES 
            }
        }
    }
}

?>