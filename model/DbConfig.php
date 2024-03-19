<?php
class DbConfig {
    // Atributos, configuração para conectar ao banco de dados
    private $_host = 'localhost';
    private $_username ='root';
    private $_password ='';
    private $_database ='protoon_php';
    public $connection;

    // Métodos
    public function __construct(){ //Contstrutor do DbConfig
        if (!isset($this->connection)){ //se não está conectado isset(e a var connection for null)
            $this->connection = new mysqli($this->_host, $this->_username,
            $this->_password, $this->_database); //Diz que a var connection é igual ao mysqli(), ou seja, instância o mysqli.
        }
        if (!$this->connection){ //Se não conectar acima, então retorna o seguinte print:
            echo 'Não é possível conectar ao servidor de banco de dados';
            exit;
        }
    }
}
?>