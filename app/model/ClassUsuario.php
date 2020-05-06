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

    # ---------------- Recuperando id do funcionario ---------------- #
    private function recFuncioId($cpf){
        $BFetch1=$this->conexaoDB()->prepare("select * from funcionarios where cpf=:cpf");
        $BFetch1->bindParam(":cpf", $cpf, \PDO::PARAM_STR);
        $BFetch1->execute();
        $this->funcionario_id=$BFetch1->fetch( \PDO::FETCH_ASSOC );
        $funcId = $this->funcionario_id['funcionario_id'];
        return $funcId;
    }
    # Método para adicionar usuario no banco de dados
    public function addUsuario($login,$senha,$nivelacesso_id,$cpf){
        $funcioId=$this->recFuncioId($cpf);
        # -------------- ADICIONANDO USUARIO ------------ #
        $usuario_id=0;
        $senha=md5($senha);
        $ativo=1;

        $BFetch=$this->conexaoDB()->prepare("insert into usuarios values (:usuario_id,:login,:senha,:ativo,:nivelacesso_id,:funcionario_id)");
        $BFetch->bindParam(":usuario_id", $usuario_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":login", $login, \PDO::PARAM_STR);
        $BFetch->bindParam(":senha", $senha, \PDO::PARAM_STR);
        $BFetch->bindParam(":ativo", $ativo, \PDO::PARAM_INT);
        $BFetch->bindParam(":nivelacesso_id", $nivelacesso_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":funcionario_id", $funcioId, \PDO::PARAM_INT);

        /*echo "<br>idFuncionario:". $funcId;
        echo "<br>Login:" . $login;
        echo "<br>Senha:" . $senha;
        echo "<br>NivelAcesso:" . $nivelacesso_id;
        echo "<br>CPF:" . $cpf;
        echo "<br>Ativo:" . $ativo;*/
        $BFetch->execute();
    }
    public function editarUsuario($login,$senha,$nivelacesso_id,$cpf){
        $funcionario_id = $this->recFuncioId($cpf);
        if($nivelacesso_id >=2){
            $_SESSION['nivelacesso'] = $nivelacesso_id;
        }
        if($nivelacesso_id == 3):
            $ativo = 0;
        else:
            $ativo = 1;
        endif;
        if(empty($senha)):
            $BFetch = $this->conexaoDB()->prepare("UPDATE usuarios SET login=:login, ativo=:ativo, nivelacesso_id=:nivelacesso_id WHERE funcionario_id=:funcionario_id");
        else:
            $senha = md5($senha);
            $BFetch = $this->conexaoDB()->prepare("UPDATE usuarios SET login=:login, senha=:senha, ativo=:ativo, nivelacesso_id=:nivelacesso_id WHERE funcionario_id=:funcionario_id");
            $BFetch->bindParam(":senha", $senha, \PDO::PARAM_STR);
        endif;
        $BFetch->bindParam(":login", $login, \PDO::PARAM_STR);
        $BFetch->bindParam(":nivelacesso_id", $nivelacesso_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":ativo", $ativo, \PDO::PARAM_INT);
        $BFetch->execute();
        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }
    public function excluirUsuario($funcionario_id){
        try{
            $BFetch=$this->conexaoDB()->prepare("DELETE FROM usuarios WHERE funcionario_id=:funcionario_id");
            $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
            if($BFetch->execute()):
                return true;
            else:
                return false;
            endif;
        }catch (\Exception $ex){
            return false;
        }
    }
}