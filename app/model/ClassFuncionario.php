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
    # Listar Funcionários
    protected function listarFuncionario(){
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT * FROM usuarios u INNER JOIN funcionarios f ON u.funcionario_id=f.funcionario_id");
        #$BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_STR);
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=['funcionario_id'=>$fetch['funcionario_id'],'nome'=>$fetch['nome'],'login'=>$fetch['login'], 'dtEntrada'=>$fetch['dtEntrada'], 'celular'=>$fetch['celular'], 'endereco'=>$fetch['endereco'],'ativo'=>$fetch['ativo'], 'nivelacesso_id'=>$fetch['nivelacesso_id']];
            $i++;
        }
        return $array;
    }
}