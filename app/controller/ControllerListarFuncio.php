<?php
namespace App\Controller;

use Src\Classes\ClassRender;
use App\Model\ClassFuncionario;

class ControllerListarFuncio extends ClassFuncionario{
    use \Src\Traits\TraitUrlParser;
    protected $usuario;
    protected $login;
    protected $nivelacesso_id;
    protected $funcionario_id;
    protected $nome;
    protected $cpf;
    protected $rg;
    protected $celular;
    protected $email;
    protected $endereco;
    protected $funcao_id;
    protected $ativo;
    protected $dtEntrada;
    protected $dtSaida;

    public function __construct(){
        if(count($this->parseUrl())==1){
            $render = new ClassRender();
            if(isset($_SESSION['logado'])){
                $render->setTitle("Lista de Funcionários");
                $render->setDir("listar_funcio");
                $render->renderLayout();
            }elseif(isset($_SESSION['nao_logado'])){
                header('Location: ' . DIRPAGE . 'login');
                exit();
            }
        }
    }
    # Irá receber todas as variaveis que vierem via $_POST e irá filtrá-las
    public function recebeVariaveis(){
        if(isset($_POST['login'])){$this->login=filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['nivelacesso_id'])){$this->nivelacesso_id=filter_input(INPUT_POST, 'nivelacesso_id', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['funcionario_id'])){$this->funcionario_id=$_POST['funcionario_id'];}
        if(isset($_POST['nome'])){$this->nome=filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['cpf'])){$this->cpf=filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['rg'])){$this->rg=filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['celular'])){$this->celular=filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['email'])){$this->email=filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['endereco'])){$this->endereco=filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['funcao_id'])){$this->funcao_id=filter_input(INPUT_POST, 'funcao_id', FILTER_SANITIZE_SPECIAL_CHARS);}
        #if(isset($_POST['ativo'])){$this->ativo=filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_SPECIAL_CHARS);}
    }

    # Método que irá listar todos os funcionários
    public function listar()
    {
        $this->recebeVariaveis();
        $Array = $this->listarFuncionario();

        echo "
        <body class='fundoLogado'>
        <div class='tabelaFunc table-responsive'>
            <table class='table table-hover table-dark table-striped table-bordered'>
                <thead class='thead-dark '>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Nome</th>
                    <th scope='col'>Usuario</th>
                    <th scope='col'>Data Entrada</th>
                    <th scope='col'>Celular</th>
                    <th scope='col'>Endereço</th>
                    <th scope='col'>Ativo</th>
                </tr>
                </thead>
                <tbody>";

        foreach ($Array as $dados) {
            $active = "$dados[ativo]";
            $this->ativo = $active == 1 ? "Sim" : "Não";
            $this->dtEntrada = date('d/m/Y', strtotime("$dados[dtEntrada]"));
            $accessNvl = "$dados[nivelacesso_id]";
            $this->nivelacesso_id = $accessNvl == 3 ? "text-danger" : "";
            $render = new ClassRender();

            echo "
                <link href='" . DIRCSS . 'bootstrap.min.css' . "' rel='stylesheet'/>
                <link href='" . DIRCSS . 'style.css' . "' rel='stylesheet'/>
                <link href='" . DIRCSS . 'bootstrap.css' . "' rel='stylesheet'/>
            <tr>
                <th scope='row'>$dados[funcionario_id]</th>
                <td class='{$this->nivelacesso_id}'>$dados[nome]</td>
                <td>$dados[login]</td>
                <td>{$this->dtEntrada}</td>
                <td>$dados[celular]</td>
                <td>$dados[endereco]</td>
                <td>{$this->ativo}</td>
                <td>
                    <a href='" . DIRPAGE . 'listar_funcio/visualizar' . "?id=$dados[funcionario_id]'><button type='button' class='btn btn-primary'>Visualizar</button></a>
                    <a href='#'><button type='button' class='btn btn-success'>Editar</button></a>
                    <a href='#'><button type='button' class='btn btn-danger'>Excluir</button></a>
                </td>
            </tr>";
        }
        echo "

                </tbody >
            </table >
            <div class='col text-center'>
                <a href='" . DIRPAGE . 'listar_funcio' . "'><button type='button' class='btn btn-warning btn-lg text-uppercase'>Voltar</button></a><br><br><br>
            </div>
        </div>
        <script src='" .DIRJS . 'jquery.min.js' . "'></script>
        <script src='" .DIRJS . 'bootstrap.min.js' . "'></script>
        <script src='" .DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>
        ";
    }
}