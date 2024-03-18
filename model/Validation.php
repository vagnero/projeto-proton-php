<?php
class Validation{
    public function check_empty($data, $fields){ //Parâmetro data com o (array com os dados do formulário) e fields if (is_array($fields))) garante que se está fornecendo um array válido de campos a serem verificados.
        $msg = null; // Supondo que os dados do formulário estejam disponíveis no array POST
        if (is_array($fields)){
            foreach ($fields as $field){
                if ($_SERVER["REQUEST_METHOD"] == "POST"){ //verifica se a solicitação http é um método post
                    if (empty($data[$field])){ //se a data com o nome do campo estiver vazio, será printado um erro
                        $msg .= "$field está vazio<br />";
                    }
                }
            }
        }
        return $msg; //retorna a mensagem
    }
}
?>