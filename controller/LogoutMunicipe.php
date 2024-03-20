<!-- // TODO: Verificar se está correto e saindo da página  -->
<?php
    
    logout();


    public function logout(){
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../view/login.php');
        // echo window.location.href='../view/login.php';</script>";
        exit();
    }

    
    

?>