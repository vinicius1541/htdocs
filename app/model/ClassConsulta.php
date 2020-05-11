<?php


namespace App\Model;
namespace App\Model;

use App\Model\ClassFuncionario;
use App\Model\ClassCliente;
use App\Model\ClassConexao;

class ClassConsulta extends ClassConexao{
    private $db;
    use \Src\Traits\TraitUrlParser;

    # Método que irá buscar a lista de horários
    protected function listarHorarios(){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM horarios");
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=[
                'horario_id'=>$fetch['horario_id'],
                'horario'=>$fetch['horario']
            ];
            $i++;
        }
        return $array;
    }

    protected function verificarHorario($funcionario_id,$dtConsulta, $hr_inicio, $hr_final){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE dtConsulta=:dtConsulta and funcionario_id=:funcionario_id and (hr_inicio=:hr_inicio or hr_final=:hr_final);");
        $BFetch->bindParam(":hr_inicio", $hr_inicio, \PDO::PARAM_INT);
        $BFetch->bindParam(":hr_final", $hr_final, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtConsulta", $dtConsulta);
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
        $ultimoHor = '17'; #17=14:00:00
        if($hr_inicio>=$ultimoHor){
            return false;
        }elseif($hr_final <= $hr_inicio){
            return false;
        }
        $consulta_id=0; $dtAbertura=date('Y-m-d H:i:s'); $dtEncerr=null; $solucao=null;
        $BFetch=$this->conexaoDB()->prepare("INSERT INTO consultas VALUES (:consulta_id,:dtConsulta, :hr_inicio, :hr_final, :custo, :desconto, :dtAbertura, :dtEncerr, :problema, :solucao, :situacao, :cliente_id, :funcionario_id)");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtConsulta", $dtConsulta);
        $BFetch->bindParam(":hr_inicio", $hr_inicio, \PDO::PARAM_INT);
        $BFetch->bindParam(":hr_final", $hr_final, \PDO::PARAM_INT);
        $BFetch->bindParam(":custo", $custo, \PDO::PARAM_INT);
        $BFetch->bindParam(":desconto", $desconto, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtAbertura", $dtAbertura);
        $BFetch->bindParam(":dtEncerr", $dtEncerr);
        $BFetch->bindParam(":problema", $problema, \PDO::PARAM_STR);
        $BFetch->bindParam(":solucao", $solucao, \PDO::PARAM_STR);
        $BFetch->bindParam(":situacao", $situacao, \PDO::PARAM_INT);
        $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        if($BFetch->execute()){ # Para obter o erro, caso houver
            return true;
        }else{
            return false;
            /*echo "<pre>";
            print_r($BFetch->errorInfo()); //printa a mensagem de erro
            print_r($BFetch->queryString); //printa a query*/
        }
    }

    protected function listarConsultas(){
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT * FROM consultas");
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=[
                'consulta_id'=>$fetch['consulta_id'],
                'dtConsulta'=>$fetch['dtConsulta'],
                'hr_inicio'=>$fetch['hr_inicio'],
                'hr_final'=>$fetch['hr_final'],
                'custo'=>$fetch['custo'],
                'desconto'=>$fetch['desconto'],
                'dtAbertura'=>$fetch['dtAbertura'],
                'dtEncerr'=>$fetch['dtEncerr'],
                'problema'=>$fetch['problema'],
                'solucao'=>$fetch['solucao'],
                'situacao'=>$fetch['situacao'],
                'cliente_id'=>$fetch['cliente_id'],
                'funcionario_id'=>$fetch['funcionario_id']
            ];
            $i++;
        }
        return $array;
    }

    protected function editarConsulta($consulta_id){

    }

    protected function encerrarConsulta($consulta_id){

    }
    protected function excluirConsulta($consulta_id){
        $BFetch=$this->conexaoDB()->prepare("DELETE FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }

}