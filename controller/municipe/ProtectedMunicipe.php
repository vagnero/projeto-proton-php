<!-- // TODO: Fazer ProtectedMunicipe -->
<?php
class ProtectedMunicipe {
    private $idMunicipe;
    private $email;
    private $cpf;
    private $dataNasc;
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if($this->estaLogado()){
            $this->idMunicipe = $_SESSION['idMunicipe'];
            $this->email = $_SESSION['email'];
            $this->cpf = $_SESSION['cpf'];
            $this->dataNasc = $_SESSION['dataNascimento'];
        }
    }
    public function retornarParaIndex() {
       
        header("Location: ../index.php");
        

    }

    public function estaLogado(){
        $logado = false;
        if (isset($_SESSION['idMunicipe'])) {
            $logado = true;
        }
        return $logado;
    }

    public function getIdMunicipe(){
        return $this->idMunicipe;
        
    }
    public function getEmail(){
        return $this->email;
    }

    public function getCpf(){
        return $this->cpf;
    }
    public function getDataNasc(){
        return $this->dataNasc;
    }

}

?>