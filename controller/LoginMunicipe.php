<?php

require_once '../model/Crud.php';
require_once '../model/Validation.php';

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

        //var_dump($result); TESTE
        //var_dump($senha); TESTE

        if ($result) {
            $senhaArm = $result[0]['senha'];
            if ($senha === $senhaArm) { // senha do banco = igual senha armazenada
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

            $loginMunicipe = new LoginMunicipe();

            if ($loginMunicipe->login($email, $senha)) {                
                //session_start();
                //$_SESSION['email'] = $email; USAR NO FUTURO
                echo "<script>alert('Logado')</script>";
                header('Location: ../view/redirecionamentoTeste.php'); 
            } else {
                echo "<script>alert('Senha ou/e Email errado(s)')</script>";
            }
        }
    }
}
