<?php
namespace App\Model;

use App\Model\ClassConexao;
class ClassCadastro extends ClassConexao{
    private $db;
    # Irá cadastrar os clientes no sistema
    protected function cadastroUsuarios($usuario, $senha){ # só as classes que extenderem ClassCadastro poderá acessar
        $senha = md5($senha);
        $usuario_id=0;
        $this->db=$this->conexaoDB()->prepare("insert into usuario values (:usuario_id, :usuario, :senha)");
        $this->db->bindParam(":usuario_id", $usuario_id, \PDO::PARAM_INT);
        $this->db->bindParam(":usuario", $usuario, \PDO::PARAM_STR);
        $this->db->bindParam(":senha", $senha, \PDO::PARAM_STR);

        $this->db->execute();
    }
    # Listar Dados
    protected function listarDados($usuario){
        $usuario='%' . $usuario . '%';
        $BFetch=$this->db=$this->conexaoDB()->prepare("select * from usuario where usuario like :usuario");
        $BFetch->bindParam(":usuario", $usuario, \PDO::PARAM_STR);
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=['usuario_id'=>$fetch['usuario_id'],'usuario'=>$fetch['usuario']];
            $i++;
        }
        return $array;
    }
    # Deleta diretamente no banco
    protected function deletarClientes($usuario_id){
        $BFetch=$this->db=$this->conexaoDB()->prepare("delete from usuario where usuario_id=:usuario_id");
        $BFetch->bindParam(":usuario_id", $usuario_id, \PDO::PARAM_INT);
        $BFetch->execute();
    }

    # Atualiza direto no banco
    protected  function editarClientes($usuario_id, $usuario, $senha){
        echo "<script>alert('$this->senha');</script>";
        if(empty($senha)){
            $BFetch=$this->db=$this->conexaoDB()->prepare("update usuario set usuario=:usuario where usuario_id=:usuario_id");
            $this->db->bindParam(":usuario_id", $usuario_id, \PDO::PARAM_INT);
            $this->db->bindParam(":usuario", $usuario, \PDO::PARAM_STR);
        }else{
            $senha = md5($senha);
            $BFetch=$this->db=$this->conexaoDB()->prepare("update usuario set usuario=:usuario, senha=:senha where usuario_id=:usuario_id");
            $this->db->bindParam(":usuario_id", $usuario_id, \PDO::PARAM_INT);
            $this->db->bindParam(":usuario", $usuario, \PDO::PARAM_STR);
            $this->db->bindParam(":senha", $senha, \PDO::PARAM_STR);
        }
        $BFetch->execute();

    }

}