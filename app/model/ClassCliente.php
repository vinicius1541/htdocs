<?php
namespace App\Model;
use App\Model\ClassConexao;

class ClassCliente extends ClassConexao{

    private $db;
    /*protected $cliente_id;
    protected $cli_nome;
    protected $cli_cpf;
    protected $cli_rg;
    protected $cli_cep;
    protected $celular;
    protected $cli_email;
    protected $endereco;*/

    # Método que irá verificar se o cadastro do cliente já existe
    protected function verificarCadastro($cli_cpf, $cli_rg, $cli_email, $cliente_id){
        if(empty($cliente_id)):
            $BFetch=$this->conexaoDB()->prepare("SELECT * FROM clientes WHERE (cli_cpf=:cli_cpf OR cli_rg=:cli_rg or cli_email=:cli_email)");
        else:
            $BFetch=$this->conexaoDB()->prepare("SELECT * FROM clientes WHERE (cli_cpf=:cli_cpf OR cli_rg=:cli_rg or cli_email=:cli_email) AND cliente_id!=:cliente_id");
            $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        endif;

        $BFetch->bindParam(":cli_cpf", $cli_cpf, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_rg", $cli_rg, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_email", $cli_email, \PDO::PARAM_STR);


        $BFetch->execute();
        if($row = $BFetch->rowCount()>0): # Se usuário existir, retorna TRUE
            return true;
        else:
            return false;
        endif;
    }
    protected function salvarCliente($cli_nome,$cli_cpf,$cli_rg,$cli_cep,$celular,$cli_email,$endereco){
        $cliente_id=0;

        $BFetch=$this->conexaoDB()->prepare("INSERT INTO clientes VALUES (:cliente_id, :cli_nome, :cli_cpf,:cli_rg,:cli_cep,:celular,:cli_email,:endereco)");
        $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":cli_nome", $cli_nome, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_cpf", $cli_cpf, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_rg", $cli_rg, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_cep", $cli_cep, \PDO::PARAM_STR);
        $BFetch->bindParam(":celular", $celular, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_email", $cli_email, \PDO::PARAM_STR);
        $BFetch->bindParam(":endereco", $endereco, \PDO::PARAM_STR);

        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }
    public function listarClientes(){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM clientes");
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        $array=null;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=[
                'cliente_id'=>$fetch['cliente_id'],
                'cli_nome'=>$fetch['cli_nome'],
                'cli_cpf'=>$fetch['cli_cpf'],
                'cli_rg'=>$fetch['cli_rg'],
                'celular'=>$fetch['celular'],
                'cli_email'=>$fetch['cli_email'],
                'endereco'=>$fetch['endereco']
            ];
            $i++;
        }
        return $array;
    }
    protected function procurarCliente($cliente_id){

        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM clientes WHERE cliente_id=:cliente_id");
        $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        $BFetch->rowCount();
        $BFetch->execute();
        $i=0;
        while ($fetch=$BFetch->fetch(\PDO::FETCH_ASSOC)){
            $array[$i]=[
                'cliente_id'=>$fetch['cliente_id'],
                'cli_nome'=>$fetch['cli_nome'],
                'cli_cpf'=>$fetch['cli_cpf'],
                'cli_rg'=>$fetch['cli_rg'],
                'cli_cep'=>$fetch['cli_cep'],
                'celular'=>$fetch['celular'],
                'cli_email'=>$fetch['cli_email'],
                'endereco'=>$fetch['endereco']
            ];
            $i++;
        }
        return $array;
    }
    protected function editarCliente($cliente_id,$cli_nome,$cli_cpf,$cli_rg,$cli_cep,$celular,$cli_email,$endereco){

        $BFetch=$this->conexaoDB()->prepare("UPDATE clientes SET cli_nome=:cli_nome, cli_cpf=:cli_cpf, cli_rg=:cli_rg,cli_cep=:cli_cep,celular=:celular,cli_email=:cli_email, endereco=:endereco WHERE cliente_id=:cliente_id");
        $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        $BFetch->bindParam(":cli_nome", $cli_nome, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_cpf", $cli_cpf, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_rg", $cli_rg, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_cep", $cli_cep, \PDO::PARAM_STR);
        $BFetch->bindParam(":celular", $celular, \PDO::PARAM_STR);
        $BFetch->bindParam(":cli_email", $cli_email, \PDO::PARAM_STR);
        $BFetch->bindParam(":endereco", $endereco, \PDO::PARAM_STR);

        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }
    protected function excluirCliente($cliente_id){
        $BFetch=$this->conexaoDB()->prepare("DELETE FROM clientes WHERE cliente_id=:cliente_id");
        $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        if($BFetch->execute()):
            return true;
        else:
            return false;
        endif;
    }
    protected function verificarCliente($cliente_id){
        $BFetch=$this->conexaoDB()->prepare("SELECT * FROM consultas WHERE cliente_id=:cliente_id");
        $BFetch->bindParam(":cliente_id", $cliente_id, \PDO::PARAM_INT);
        $BFetch->execute();
        if($row = $BFetch->rowCount()>0){ # Se existir consulta desse cliente, retorna TRUE
            return true;
        }else{
            return false;
        }
    }
}
    
