<?php
namespace App\Model;
use App\Model\ClassConexao;
class ClassUsuario extends ClassConexao{
    private $db; # Atributo que será usado para receber a conexao com o banco
    private $usuario_id;
    private $login;
    private $senha;
    private $ativo;
    private $nivelacesso_id;
    private $funcionario_id;

    # Método para adicionar usuario no banco de dados
    public function addUsuario($login,$senha,$ativo,$nivelacesso_id,$funcionario_id){
        $this->usuario_id=0;
        $this->senha=md5($senha);

        $this->db=$this->conexaoDB()->prepare("INSERT INTO usuarios VALUES (:usuario_id, :login, :senha, :ativo, :nivelacesso_id, :funcionario_id)");
        $this->db->bindParam(":usuario_id", $usuario_id, \PDO::PARAM_INT);
        $this->db->bindParam(":login", $login, \PDO::PARAM_STR);
        $this->db->bindParam(":senha", $senha, \PDO::PARAM_STR);
        $this->db->bindParam(":ativo", $ativo, \PDO::PARAM_BOOL);
        $this->db->bindParam(":nivelacesso_id", $nivelacesso_id, \PDO::PARAM_INT);
        $this->db->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);

        $this->db->execute();
    }
}

?>