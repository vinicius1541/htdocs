<?php
namespace App\Controller;

use Src\Classes\ClassRender;
use App\Model\ClassFuncionario;
use App\Model\ClassUsuario;

class ControllerCadastroFuncio extends ClassFuncionario {
    use \Src\Traits\TraitUrlParser;

    protected $usuario;
    protected $login;
    protected $senha;
    protected $ativo;
    protected $nivelacesso_id;
    protected $funcionario_id;
    protected $nome;
    protected $cpf;
    protected $rg;
    protected $celular;
    protected $email;
    protected $endereco;
    protected $funcao_id;
    protected $dtEntrada;
    protected $dtSaida;

    public function __construct(){
        if(count($this->parseUrl())==1){
            $render = new ClassRender();
            if(isset($_SESSION['logado'])){
                $render->setTitle("Cadastro de Funcionario");
                $render->setDir("cadastro_funcio");
                $render->renderLayout();
            }elseif(isset($_SESSION['nao_logado'])){
                header('Location: ' . DIRPAGE . 'login');
                exit();
            }
        }
    }
    public function recebeVariaveis(){
        if(isset($_POST['login'])){$this->login=filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['senha'])){$this->senha=filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['nivelacesso_id'])){$this->nivelacesso_id=filter_input(INPUT_POST, 'nivelacesso_id', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['funcionario_id'])){$this->funcionario_id=$_POST['funcionario_id'];}
        if(isset($_POST['nome'])){$this->nome=filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['cpf'])){$this->cpf=filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['rg'])){$this->rg=filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['celular'])){$this->celular=filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['email'])){$this->email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['endereco'])){$this->endereco=filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['funcao_id'])){$this->funcao_id=filter_input(INPUT_POST, 'funcao_id', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['ativo'])){$this->ativo=filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_SPECIAL_CHARS);}
    }

    # Método para adicionar funcionarios
    public function addFuncionario(){
        $this->recebeVariaveis();

        #$validar=$this->verificarCadastro($this->usuario);
        #if($validar == true){ # Quer dizer que o cadastro já existe
            #$_SESSION['usuario_existe']=true;
        #}else{
            $this->salvarFuncionario($this->nome,$this->cpf,$this->rg,$this->celular,$this->email,$this->endereco, $this->funcao_id);
            $this->usuario = new ClassUsuario();
            $this->usuario->addUsuario($this->login,$this->senha,$this->ativo,$this->nivelacesso_id,$_SESSION['funcionario']);
            unset($_SESSION['funcionario']);
            $_SESSION['status_cadastro']=true;

        #}
        #header('Location: ' . DIRPAGE . 'cadastro_funcio');
        #exit();
    }
    # Método para listar funcionarios
    public function listar_funcionarios(){

    }
    # Método para editar funcionários
    public function editarFuncionario($id_funcio){

    }
    public function excluirFuncionario($id_funcio){

    }
}