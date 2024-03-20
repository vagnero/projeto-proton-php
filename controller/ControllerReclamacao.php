<!-- // TODO: VERIFICAR SE ESTÁ FUNCIONANDO -->

<?php
include_once(__DIR__ . '/../model/Crud.php');
include_once(__DIR__ . '/../model/Validation.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class ControllerReclamacao{
    private $crud; //objeto crud criado no model
    private $validation; //objeto validation criado no model

    public function __construct(){
        $this->crud = new Crud(); //instâcia o objeto crud
        $this->validation = new Validation(); //instância o objeto validation
    }

    public function registerReclamacao(){
        if (isset($_POST['Submit'])){ 
            // Acho q não precisa inserir o idReclamação, pois é auto-incremento
            $problema = $this->crud->escape_string($_POST['problema']);
            $descricao = $this->crud->escape_string($_POST['descricao']);
            $idEndereco = $this->crud->escape_string($_POST['idEndereco']);
            $idMunicipe = $this->crud->escape_string($_POST['idMunicipe']);
            $statusAtual = $this->crud->escape_string($_POST['statusAtual']);
            $dataReclamacao = date('Y-m-d H:i:s'); // data e hora atual

            $msgReclamacao = $this->validation->check_empty($_POST, array('problema', 'idEndereco', 'idMunicipe', 'statusAtual'));
            
            if ($msgReclamacao == null){
                $sql_reclamacao = "INSERT INTO reclamacoes (problema, descricao, idEndereco, idMunicipe, dataReclamacao, statusAtual) 
                VALUES ('$problema', '$descricao', '$idEndereco', '$idMunicipe', '$dataReclamacao', '$statusAtual')";
                
                if($this->crud->excecute($sql_reclamacao)){
                    // FALTA ALTERAR OS ENDEREÇOS DE REDIRECIONAMENTO ***

                   // echo "<script>alert('Reclamação cadastrada com sucesso!'); window.location.href='pagina_de_sucesso.php';</script>"; 
                }else{
                   // echo "<script>alert('Erro ao cadastrar reclamação:" . $this->crud->error . "'); window.location.href='pagina_de_erro.php';</script>"; 
                }
            }
        }
    }

    // Função para atualizar o status da reclamação
    public function updateStatus(){
        if (isset($_POST['Submit'])){
            $idReclamacao = $this->crud->escape_string($_POST['idReclamacao']);
            $novoStatus = $this->crud->escape_string($_POST['novoStatus']);

            $sql_update = "UPDATE reclamacoes SET statusAtual = '$novoStatus' WHERE idReclamacao = '$idReclamacao'";
            if($this->crud->excecute($sql_update)){
                echo "<script>alert('Status da reclamação atualizado com sucesso!'); window.location.href='pagina_de_sucesso.php';</script>";
            }else{
                echo "<script>alert('Erro ao atualizar status da reclamação:" . $this->crud->error . "'); window.location.href='pagina_de_erro.php';</script>";
            }
        }
    }
}
?>
