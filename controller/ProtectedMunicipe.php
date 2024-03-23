<!-- // TODO: Fazer ProtectedMunicipe José --> 
<?php
class ProtectedMunicipe {
    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
    public function retornarParaIndex() {
        if (isset($_SESSION['idMunicipe'])) {
            header("Location: ../index.php");
        }

    }

    public function estaLogado(){
        if (!isset($_SESSION['idMunicipe'])) {
            return false;
        }
        return true;
    }

}

?>