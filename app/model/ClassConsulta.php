<?php


namespace App\Model;
namespace App\Model;

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

    protected function verificarHorario($consulta_id,$funcionario_id,$dtConsulta, $hr_inicio, $hr_final){
        $ultimoHor = '17'; #17=14:00:00
        if($hr_inicio>=$ultimoHor){
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Horário maior/igual ao último horário disponível";
            return true;
        }elseif($hr_final <= $hr_inicio){
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Horário final é menor/igual ao horário de início, <br>por favor escolha outro!";
            return true;
        }
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE dtConsulta=:dtConsulta and funcionario_id=:funcionario_id;");
        $BFetch->bindParam(":dtConsulta", $dtConsulta);
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;

        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)) {
            $array[$i] = [
                'consulta_id' => $fetch['consulta_id'],
                'hr_inicio' => $fetch['hr_inicio'],
                'hr_final' => $fetch['hr_final'],
                'funcionario_id' => $fetch['funcionario_id']
            ];
            $i++;
        }
        $dtConsultaID = $this->recDtConsulta($consulta_id);
        $hr_inicioID = $this->recHrInicio($consulta_id);
        $hr_finalID = $this->recHrFinal($consulta_id);
        $funcio = $this->buscarFuncionario($consulta_id);
        if(!($hr_inicio == $hr_inicioID && $hr_final == $hr_finalID && $dtConsulta==$dtConsultaID && $funcio == $funcionario_id)) { #se o horario nao for alterado
            foreach ($array as $horarios) {
                if ($consulta_id == $horarios['consulta_id']):
                    continue;
                endif;
                $hr_inicialid = $horarios['hr_inicio'];
                $hr_finalid = $horarios['hr_final'];
                if ($hr_final >= $hr_inicialid && ($hr_final < $hr_finalid || $hr_final >= $hr_finalid)) {
                    if (($hr_inicio >= $hr_inicialid && $hr_inicio < $hr_finalid)) {
                        $_SESSION['erro'] = true;
                        $_SESSION['msg'] = "Este funcionário já tem consulta agendada neste horário/data";
                        return true;
                    } else {
                        return false;
                    }
                } elseif (($hr_inicio >= $hr_inicialid && $hr_inicio < $hr_finalid)) {
                    $_SESSION['erro'] = true;
                    $_SESSION['msg'] = "Este funcionário já tem consulta agendada neste horário/data";
                    return true;
                } else {
                    return false;
                }
            }
        }else{
            return false;
        }
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
        $BFetch->execute();
        $i=0;
        $array = null;
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
    protected function listarConsultasByFunc($funcionario_id){
        $i=0;
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE funcionario_id=:funcionario_id");
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->execute();

        $array = null;
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
    # Método para editar a consulta
    protected function editarConsulta($consulta_id, $dtConsulta, $hr_inicio,$hr_final,$custo,$desconto,$problema,$situacao, $funcionario_id){
        if($desconto>100){
            $desconto = 100;
        }elseif($desconto<0){
            $desconto = 0;
        }
        $BFetch=$this->conexaoDB()->prepare("UPDATE consultas SET dtConsulta=:dtConsulta, hr_inicio=:hr_inicio, hr_final=:hr_final, custo=:custo,desconto=:desconto, problema=:problema, situacao=:situacao, funcionario_id=:funcionario_id WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtConsulta", $dtConsulta);
        $BFetch->bindParam(":hr_inicio", $hr_inicio, \PDO::PARAM_INT);
        $BFetch->bindParam(":hr_final", $hr_final, \PDO::PARAM_INT);
        $BFetch->bindParam(":custo", $custo, \PDO::PARAM_INT);
        $BFetch->bindParam(":desconto", $desconto, \PDO::PARAM_INT);
        $BFetch->bindParam(":problema", $problema, \PDO::PARAM_STR);
        $BFetch->bindParam(":situacao", $situacao, \PDO::PARAM_INT);
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);

        if($BFetch->execute()):
            return true;
        else:
            return false;
            /*echo "<pre>";
            print_r($BFetch->errorInfo()); //printa a mensagem de erro
            print_r($BFetch->queryString); //printa a query*/
        endif;
    }
    # Método que irá apenas encerrar a consulta
    protected function encerrarConsulta($consulta_id, $solucao){
        if(empty($solucao)){
            return false;
        }
        $BFetch=$this->conexaoDB()->prepare("UPDATE consultas SET solucao=:solucao, dtEncerr=now() WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":solucao", $solucao);
        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }

    # Método que irá excluir a consulta
    protected function excluirConsulta($consulta_id){
        $BFetch=$this->conexaoDB()->prepare("DELETE FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }
    # Método que irá procurar o funcionário responsável por determinada consulta
    protected function buscarFuncionario($consulta_id){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            $funcId=$BFetch->fetch( \PDO::FETCH_ASSOC );
            $funcionario_id = $funcId['funcionario_id'];
        endif;
        return $funcionario_id;
    }
    protected function buscarConsulta($consulta_id){
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
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
                'problema'=>$fetch['problema'],
                'situacao'=>$fetch['situacao'],
                'funcionario_id'=>$fetch['funcionario_id']
            ];
            $i++;
        }
        return $array;
    }
    protected function recHrInicio($consulta_id){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            $hr_inicioID=$BFetch->fetch( \PDO::FETCH_ASSOC );
            $hr_inicio = $hr_inicioID['hr_inicio'];
        endif;
        return $hr_inicio;
    }
    protected function recHrFinal($consulta_id){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            $hr_finalID=$BFetch->fetch( \PDO::FETCH_ASSOC );
            $hr_final = $hr_finalID['hr_final'];
        endif;
        return $hr_final;
    }
    protected function recDtConsulta($consulta_id){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            $dtConsultaDT=$BFetch->fetch( \PDO::FETCH_ASSOC );
            $dtConsulta = $dtConsultaDT['dtConsulta'];
        endif;
        return $dtConsulta;
    }
    protected function verificarPagamento($consulta_id){
        $BFetch = $this->conexaoDB()->prepare("SELECT * FROM consultas WHERE consulta_id=:consulta_id");
        $BFetch->bindParam(":consulta_id", $consulta_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            $situacao=$BFetch->fetch( \PDO::FETCH_ASSOC );
            $situacaoPagamento = $situacao['situacao'];
        endif;
        return $situacaoPagamento;
    }
}