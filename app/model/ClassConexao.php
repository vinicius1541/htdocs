<?php
namespace App\Model;

abstract class ClassConexao{
    # Realiza a conexao com o banco de dados
    public function conexaoDB(){
        try {
            $con = new \PDO("mysql:host=". HOST.";dbname=" . DB . "","".USER."","".PASS."");
            return $con;
        }catch (\PDOException $error){
            return $error->getMessage();
        }
    }

}