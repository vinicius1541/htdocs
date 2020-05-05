<?php
namespace App\Model;
use App\Model\ClassConexao;

class ClassLogin extends ClassConexao{
    private $db;

    protected function searchLogin($login, $senha){
        $senha=md5($senha);
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT usuario_id, login, nivelacesso_id,funcionario_id FROM usuarios WHERE (login=:login AND senha=:senha) AND (nivelacesso_id BETWEEN 1 AND 2)");
        $BFetch->bindParam(":login", $login, \PDO::PARAM_STR);
        $BFetch->bindParam(":senha", $senha, \PDO::PARAM_STR);
        $BFetch->execute();

        if($row = $BFetch->rowCount()>0){
            $_SESSION['login'] = $login;

            $C=$BFetch->fetch( \PDO::FETCH_ASSOC );
            $_SESSION['funcionario_id'] = $C['funcionario_id'];
            $_SESSION['nivelacesso'] = $C['nivelacesso_id'];
            $_SESSION['logado'] = true;
            return true;
        }else{
            $_SESSION['nao_autenticado'] = true;
            return false;
        }


        /*$i=0;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=['usuario_id'=>$fetch['usuario_id'],'usuario'=>$fetch['usuario']];
            $i++;
        }
        return $array;*/
    }

}