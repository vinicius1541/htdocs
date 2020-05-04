<?php
namespace App\Model;
use \App\Model\ClassUsuario;
use App\Model\ClassConexao;
class ClassFuncionario extends ClassConexao{
    private $db;
    use \Src\Traits\TraitUrlParser;

    # Método que irá verificar se o cadastro já existe
    protected function verificarCadastro($usuario){
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT COUNT(*) total FROM usuarios WHERE usuario=:usuario");
        $BFetch->bindParam(":usuario", $usuario, \PDO::PARAM_STR);
        $BFetch->execute();
        if($row = $BFetch->rowCount()>0){ # Se usuário existir, retorna TRUE
            return true;
        }else{
            return false;
        }
    }
    # Método para salvar cadastro do funcionário com acesso ao bd
    protected function salvarFuncionario($nome,$cpf,$rg,$celular,$email,$endereco,$funcao_id){

        $funcionario_id=0;
        $ativo=1;
        $BFetch=$this->conexaoDB()->prepare("insert into funcionarios values (:funcionario_id, :nome, :cpf,:rg,:celular,:email,:endereco,:funcao_id,:ativo, now(), null )");
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":nome", $nome, \PDO::PARAM_STR);
        $BFetch->bindParam(":cpf", $cpf, \PDO::PARAM_STR);
        $BFetch->bindParam(":rg", $rg, \PDO::PARAM_STR);
        $BFetch->bindParam(":celular", $celular, \PDO::PARAM_STR);
        $BFetch->bindParam(":email", $email, \PDO::PARAM_STR);
        $BFetch->bindParam(":endereco", $endereco, \PDO::PARAM_STR);
        $BFetch->bindParam(":funcao_id", $funcao_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":ativo", $ativo, \PDO::PARAM_INT);
        echo $ativo. "<br>";
        $BFetch->execute();
    }

}