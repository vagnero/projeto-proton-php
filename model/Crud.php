<?php
include_once(__DIR__ . '/DbConfig.php'); //importação do dbconfig
class Crud extends DbConfig{ //a class crud herda os métodos/atributos de dbconfig
    public function __construct(){
        parent::__construct();
    }
    public function escape_string($value){
        return $this->connection->real_escape_string($value); //Método para evitar injeções de SQL
    }
    public function execute($query){ //Este método executa uma query no banco de dados. Se a query falhar, ele lança uma exceção.
        $result = $this->connection->query($query); //Este método executa uma query no banco de dados usando  $this->connection->query($query).

        if($result === false){
            throw new Exception('Error: ' . $this->connection->error); 
        }
        
        return true;
    }

 
    public function getLastInsertId() {
        return $this->connection->insert_id;
    }
    


    public function getData($query){//Similar ao excecute, mas esse lança os dados da query também.
        $result = $this->connection->query($query); //Este método executa uma query no banco de dados usando  $this->connection->query($query).

        if($result === false){
            throw new Exception('Error: ' . $this->connection->error);
        }

        $rows = array(); //Array vazio para armazenar os resultados da query

        while($row = $result->fetch_assoc()){ //Usa o loop e diz que row = result
            $rows[] = $row; //Loop while para percorrer resultados da query ($result->fetch_assoc()) e adiciona cada linha ao rows
        }

        return $rows; //Retorna o row contendo os resultados da query
    }

    

    public function delete($query){
        $result = $this->connection->query($query); //Este método executa uma query no banco de dados usando  $this->connection->query($query).

        if($result === false){
            throw new Exception('Error: ' . $this->connection->error);
        }
        return true; //retorna true, para poder deletar o elemento
    }

    public function update($query){
        $result = $this->connection->query($query); //Este método executa uma query no banco de dados usando  $this->connection->query($query).

        if($result === false){
            throw new Exception('Error: ' . $this->connection->error);
        }
        return true; //retorna true para poder atualizar o elemento
    }
}
?>