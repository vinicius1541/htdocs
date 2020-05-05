<?php
namespace App\Model;
use \App\Model\ClassUsuario;
use App\Model\ClassConexao;
class ClassFuncionario extends ClassConexao{
    private $db;
    use \Src\Traits\TraitUrlParser;

    # Método que irá verificar se o cadastro já existe
    protected function verificarCadastro($login, $funcionario_id){
        if(empty($funcionario_id)):
            $BFetch=$this->conexaoDB()->prepare("SELECT login FROM usuarios WHERE login=:login");
        else:
            $BFetch=$this->conexaoDB()->prepare("SELECT login FROM usuarios WHERE login=:login AND funcionario_id!=:funcionario_id");
            $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        endif;
        $BFetch->bindParam(":login", $login, \PDO::PARAM_STR);
        $BFetch->execute();
        if($row = $BFetch->rowCount()>0){ # Se usuário existir, retorna TRUE
            return true;
        }else{
            return false;
        }

    }
    # Método para salvar cadastro do funcionário com acesso ao bd
    protected function salvarFuncionario($nome,$cpf,$rg,$celular,$email,$endereco,$funcao_id, $nivelacesso_id){
        $funcionario_id=0;
        if($nivelacesso_id == 3):
            $ativo = 0;
        else:
            $ativo = 1;
        endif;
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
            $array[$i]=[
                'funcionario_id'=>$fetch['funcionario_id'],
                'nome'=>$fetch['nome'],
                'login'=>$fetch['login'],
                'senha'=>$fetch['senha'],
                'cpf'=>$fetch['cpf'],
                'rg'=>$fetch['rg'],
                'celular'=>$fetch['celular'],
                'email'=>$fetch['email'],
                'endereco'=>$fetch['endereco'],
                'funcao_id'=>$fetch['funcao_id'],
                'ativo'=>$fetch['ativo'],
                'nivelacesso_id'=>$fetch['nivelacesso_id'],
                'dtEntrada'=>$fetch['dtEntrada']
            ];
            $i++;
        }
        return $array;
    }
    # Editar Funcionário
    protected function procurarFuncionario($funcionario_id){
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT * FROM funcionarios f INNER JOIN usuarios u ON u.funcionario_id = f.funcionario_id AND f.funcionario_id=:funcionario_id");
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=[
                'funcionario_id'=>$fetch['funcionario_id'],
                'nome'=>$fetch['nome'],
                'login'=>$fetch['login'],
                'cpf'=>$fetch['cpf'],
                'rg'=>$fetch['rg'],
                'celular'=>$fetch['celular'],
                'email'=>$fetch['email'],
                'endereco'=>$fetch['endereco'],
                'funcao_id'=>$fetch['funcao_id'],
                'ativo'=>$fetch['ativo'],
                'nivelacesso_id'=>$fetch['nivelacesso_id']
            ];
            $i++;
        }
        return $array;
    }
    protected function editarFuncionario($funcionario_id,$nome,$cpf,$rg,$celular,$email,$endereco,$funcao_id, $nivelacesso_id){
        if($nivelacesso_id == 3):
            $ativo = 0;
            $dtSaida=date('Y-m-d');
        else:
            $dtSaida=null;
            $ativo = 1;
        endif;
        $BFetch=$this->conexaoDB()->prepare("UPDATE funcionarios SET nome=:nome, cpf=:cpf, rg=:rg, celular=:celular,email=:email, endereco=:endereco, funcao_id=:funcao_id, ativo=:ativo, dtSaida=:dtSaida WHERE funcionario_id=:funcionario_id");
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":nome", $nome, \PDO::PARAM_STR);
        $BFetch->bindParam(":cpf", $cpf, \PDO::PARAM_STR);
        $BFetch->bindParam(":rg", $rg, \PDO::PARAM_STR);
        $BFetch->bindParam(":celular", $celular, \PDO::PARAM_STR);
        $BFetch->bindParam(":email", $email, \PDO::PARAM_STR);
        $BFetch->bindParam(":endereco", $endereco, \PDO::PARAM_STR);
        $BFetch->bindParam(":funcao_id", $funcao_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":ativo", $ativo, \PDO::PARAM_INT);
        $BFetch->bindParam(":dtSaida", $dtSaida);

        /*echo "id: ". $funcionario_id . "<br>";
        echo "nome: ". $nome . "<br>";
        echo "cpf: ". $cpf . "<br>";
        echo "rg: ". $rg . "<br>";
        echo "celular: ". $celular . "<br>";
        echo "email: ". $email . "<br>";
        echo "endereco: ". $endereco . "<br>";
        echo "funcaoid: ". $funcao_id . "<br>";
        echo "nivelacessoid: ". $nivelacesso_id . "<br>";
        echo "ativo: ". $ativo . "<br>";*/

        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }
    protected function excluirFuncionario($funcionario_id){
        $BFetch=$this->conexaoDB()->prepare("DELETE FROM funcionarios WHERE funcionario_id=:funcionario_id");
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }
}