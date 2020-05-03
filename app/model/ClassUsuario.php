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
    public function addUsuario($login,$senha,$nivelacesso_id,$cpf){
        # Recuperando id do funcionario
        $BFetch1=$this->conexaoDB()->prepare("select * from funcionarios where cpf=:cpf");
        $BFetch1->bindParam(":cpf", $cpf, \PDO::PARAM_STR);
        $BFetch1->execute();
        $this->funcionario_id=$BFetch1->fetch( \PDO::FETCH_ASSOC );
        $funcId = $this->funcionario_id['funcionario_id'];



        # -------------------------- #
        $usuario_id=0;
        $senha=md5($senha);
        $ativo=1;

        $BFetch=$this->conexaoDB()->prepare("insert into usuarios values (:usuario_id,:login,:senha,:ativo,:nivelacesso_id,:funcionario_id)");
        $BFetch->bindParam(":usuario_id", $usuario_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":login", $login, \PDO::PARAM_STR);
        $BFetch->bindParam(":senha", $senha, \PDO::PARAM_STR);
        $BFetch->bindParam(":ativo", $ativo, \PDO::PARAM_INT);
        $BFetch->bindParam(":nivelacesso_id", $nivelacesso_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":funcionario_id", $funcId, \PDO::PARAM_INT);

        echo "<br>idFuncionario:". $funcId;
        echo "<br>Login:" . $login;
        echo "<br>Senha:" . $senha;
        echo "<br>NivelAcesso:" . $nivelacesso_id;
        echo "<br>CPF:" . $cpf;
        echo "<br>Ativo:" . $ativo;
        $BFetch->execute();
    }
}

?>