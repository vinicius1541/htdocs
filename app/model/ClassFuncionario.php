<?php
namespace App\Model;
class ClassFuncionario extends ClassConexao{
    private $db;
    use \Src\Traits\TraitUrlParser;

    # Método que irá verificar se o cadastro já existe
    protected function verificarCadastro($login, $funcionario_id, $funcao_id, $cpf){
        if($this->verificarCPF($funcionario_id, $cpf)){
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Já existe um CPF igual ao digitado, por favor, digite outro!";
            return true;
        }

        if($this->verificarFuncionario($funcionario_id)){ # se retornar true(dizendo que o funcionario tem consultas marcadas
            if(!empty($funcao_id)){ # se o atributo funcao_id existir
                $BFetch = $this->conexaoDB()->prepare("SELECT * FROM funcionarios WHERE funcionario_id=:funcionario_id");
                $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
                $BFetch->execute();
                $funcao=$BFetch->fetch(\PDO::FETCH_ASSOC);
                if($funcao['funcao_id'] == $funcao_id){ #se a funcao do funcionario for a mesmo que existe no banco, entao pular
                    goto verificandoUsuario;
                }
                if($this->verificarFuncionario($funcionario_id)){
                    $_SESSION['erro'] = true;
                    $_SESSION['msg'] = "Este funcionário nao pode ser editado, <br>pois o mesmo tem consultas abertas!";
                    return true;
                }
            }
            goto verificandoUsuario;
        }
        verificandoUsuario:
        # Verificando se o usuario digitado existe
        if(empty($funcionario_id)):
            $BFetch1=$this->conexaoDB()->prepare("SELECT * FROM usuarios WHERE login=:login");
        else:
            $BFetch1=$this->conexaoDB()->prepare("SELECT * FROM usuarios WHERE login=:login AND funcionario_id!=:funcionario_id");
            $BFetch1->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        endif;
        $BFetch1->bindParam(":login", $login, \PDO::PARAM_STR);
        $BFetch1->execute();

        $i = 0;
        while ($fetch=$BFetch1->fetch(\PDO::FETCH_ASSOC)) {
            $array[$i] = [
                'funcionario_id' => $fetch['funcionario_id']
            ];
            $i++;
        }

        foreach ($array as $funcio){
            if($funcio['funcionario_id'] == $funcionario_id){
                continue;
            }
            if($row = $BFetch1->rowCount()>0){ # Se usuário existir, retorna TRUE
                $_SESSION['erro'] = true;
                $_SESSION['msg'] = "Sinto muito, usuario inserido já existe :(";
                return true;
            }else{
                return false;
            }
        }
        return false;
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
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT * FROM funcionarios f INNER JOIN usuarios u on f.funcionario_id=u.funcionario_id AND u.login!='admin'");
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        $array=null;
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
    public function listarDentistas(){
        $BFetch=$this->db=$this->conexaoDB()->prepare("SELECT * FROM funcionarios f INNER JOIN usuarios u ON f.funcionario_id=u.funcionario_id AND funcao_id=2 AND u.login!='admin'");
        #$BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_STR);
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        $array=null;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=[
                'funcionario_id'=>$fetch['funcionario_id'],
                'nome'=>$fetch['nome'],
                'funcao_id'=>$fetch['funcao_id']
            ];
            $i++;
        }
        return $array;
    }
    # Método que irá buscar o funcionário que será editado
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
    protected function verificarFuncionario($funcionario_id){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE funcionario_id=:funcionario_id");
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->execute();
        if($row = $BFetch->rowCount()>0){ # Se existir consulta desse funcionario, retorna TRUE
            return true;
        }else{
            return false;
        }
    }
    protected function verificarCPF($funcionario_id, $cpf){
        $BFetch=$this->conexaoDB()->prepare("SELECT *  FROM funcionarios WHERE funcionario_id=:funcionario_id or cpf=:cpf");
        $BFetch->bindParam(":funcionario_id", $funcionario_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":cpf", $cpf, \PDO::PARAM_STR);

        $BFetch->execute();
        if($row = $BFetch->rowCount()>0){ # Se existir consulta desse funcionario, retorna TRUE
            return true;
        }else{
            return false;
        }
    }
}