<?php


namespace App\Model;
namespace App\Model;

use App\Model\ClassFuncionario;
use App\Model\ClassCliente;
use App\Model\ClassConexao;

class ClassConsulta extends ClassConexao{
    private $db;
    use \Src\Traits\TraitUrlParser;
    
    protected function verificarHorario($funcionario_id,$dtConsulta, $hr_inicio, $hr_final){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas c WHERE (c.hr_inicio=:hr_inicio and c.hr_final=:hr_final) and dtConsulta=:dtConsulta and funcionario_id=:funcionario_id;");
        $BFetch->bindParam(":hr_inicio", $hr_inicio, \PDO::PARAM_INT);
        $BFetch->bindParam(":hr_final", $hr_final, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtConsulta", $dtConsulta, \PDO::PARAM_STR);
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->execute();
        if($row = $BFetch->rowCount()>0):
            return true;
        else:
            return false;
        endif;
    }
    # Métodos para abrir, cancelar, visualizar, editar e encerrar consultas
    protected function abrirConsultas($dtConsulta, $hr_inicio,$hr_final, $custo, $desconto, $problema, $situacao, $cliente_id, $funcionario_id){
        $consulta_id=0; $dtAbertura=date('Y-m-d'); $dtEncerr=null; $solucao=null;
        $BFetch=$this->conexaoDB()->prepare("INSERT INTO consultas VALUES (:consulta_id,:dtConsulta, :hr_inicio, :hr_final, :custo, :desconto, :dtAbertura, :dtEncerr, :problema, :solucao, :situacao, :cliente_id, :funcionario_id)");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtConsulta", $dtConsulta);
        $BFetch->bindParam(":hr_inicio", $hr_inicio);
        $BFetch->bindParam(":hr_final", $hr_final);
        $BFetch->bindParam(":custo", $custo, \PDO::PARAM_INT);
        $BFetch->bindParam(":desconto", $desconto, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtAbertura", $dtAbertura);
        $BFetch->bindParam(":dtEncerr", $dtEncerr);
        $BFetch->bindParam(":problema", $problema, \PDO::PARAM_STR);
        $BFetch->bindParam(":solucao", $solucao, \PDO::PARAM_STR);
        $BFetch->bindParam(":situacao", $situacao, \PDO::PARAM_INT);
        $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->execute();
        /*if($BFetch->execute()){
            echo "true";
        }else{
            echo "<pre>";
            print_r($BFetch->errorInfo()); //printa a mensagem de erro
            print_r($BFetch->queryString); //printa a query
        }*/
    }

    protected function cancelarConsulta($consulta_id){

    }

    protected function verConsultas($consulta_id){

    }

    protected function editarConsulta($consulta_id){

    }

    protected function encerrarConsulta($consulta_id){

    }

}