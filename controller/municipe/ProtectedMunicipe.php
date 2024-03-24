<!-- // TODO: Fazer ProtectedMunicipe -->
<?php
class ProtectedMunicipe {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
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

}

?>