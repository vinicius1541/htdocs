<?php

namespace App\Model;

use Exception;

abstract class ClassConexao
{
    # Realiza a conexao com o banco de dados
    public function conexaoDB()
    {
        try {
            try{
                $con = new \PDO("mysql:host=" . HOST . ";dbname=" . DB . "", "" . USER . "", "" . PASS . "");
                return $con;
            } catch (Exception $ex){
                $con = new \PDO("mysql:host=" . HOST . ";dbname=" . DB . "", "" . USER . "", "");
                return $con;
            }
           
            
            
        } catch (\PDOException $error) {
            return $error->getMessage();
        }
    }
}
