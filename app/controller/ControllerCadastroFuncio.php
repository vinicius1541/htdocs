<?php
namespace App\Controller;

use Src\Classes\ClassRender;
use App\Model\ClassFuncionario;
use App\Model\ClassUsuario;

class ControllerCadastroFuncio extends ClassFuncionario{
    use \Src\Traits\TraitUrlParser;

    protected $usuario;
    protected $login;
    protected $senha;
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
        if (count($this->parseUrl()) == 1) {
            $render = new ClassRender();
            if (isset($_SESSION['logado'])) {
                if ($_SESSION['nivelacesso'] == 2):
                    header('Location: ' . DIRPAGE . 'home');
                    exit();
                elseif($_SESSION['nivelacesso'] == 3):
                    unset($_SESSION['msg']); unset($_SESSION['erro']); unset($_SESSION['sucesso']);
                    header('Location: ' . DIRPAGE . 'login');
                    exit();
                else:
                    $render->setTitle("Cadastro de Funcionario");
                    $render->setDir("cadastro_funcio");
                    $render->renderLayout();
                endif;
            } elseif (isset($_SESSION['nao_logado'])) {
                header('Location: ' . DIRPAGE . 'login');
                exit();
            }
        }
    }

    public function recebeVariaveis(){
        if ($_SESSION['nivelacesso'] == 2):
            header('Location: ' . DIRPAGE . 'home');
            exit();
        elseif($_SESSION['nivelacesso'] == 3):
            unset($_SESSION['msg']); unset($_SESSION['erro']); unset($_SESSION['sucesso']);
            header('Location: ' . DIRPAGE . 'login');
            exit();
        else:
            if (isset($_POST['login'])){$this->login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['senha'])){$this->senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['nivelacesso_id'])){ $this->nivelacesso_id = filter_input(INPUT_POST, 'nivelacesso_id', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['funcionario_id'])){$this->funcionario_id = $_POST['funcionario_id'];}
            if (isset($_POST['nome'])){$this->nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['cpf'])){$this->cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['rg'])){$this->rg = filter_input(INPUT_POST, 'rg', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['celular'])){$this->celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['email'])){$this->email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['endereco'])){$this->endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['funcao_id'])){$this->funcao_id = filter_input(INPUT_POST, 'funcao_id', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['ativo'])){$this->ativo = filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_SPECIAL_CHARS);}
        endif;
    }

    # Método para adicionar funcionarios
    public function addFuncionario(){
        $this->recebeVariaveis();

        $validar = $this->verificarCadastro($this->login,$this->funcionario_id);
        if ($validar == true) { # Quer dizer que o cadastro já existe
            $_SESSION['usuario_existe'] = true;
        } else {
            $this->salvarFuncionario($this->nome, $this->cpf, $this->rg, $this->celular, $this->email, $this->endereco, $this->funcao_id, $this->nivelacesso_id);
            $this->usuario = new ClassUsuario();
            $this->usuario->addUsuario($this->login, $this->senha, $this->nivelacesso_id, $this->cpf);
            #$this->CPF serve para recuperar o id do funcionario na hora de inserir um usuario
            $_SESSION['status_cadastro'] = true;
        }
        header('Location: ' . DIRPAGE . 'cadastro_funcio');
        exit();
    }

    # Método que irá listar todos os funcionários
    public function listar(){
        $this->recebeVariaveis();
        $Array = $this->listarFuncionario();

        echo "
        <link href='" . DIRCSS . 'bootstrap.min.css' . "' rel='stylesheet'/>
        <link href='" . DIRCSS . 'style.css' . "' rel='stylesheet'/>
        <link href='" . DIRCSS . 'bootstrap.css' . "' rel='stylesheet'/>
        <body class='fundoLogado'>";
            if (isset($_SESSION['sucesso'])):
                echo "
            <div class='alert alert-success'>
                <p>" . $_SESSION['msg'] . "</p>
            </div>";
            elseif (isset($_SESSION['erro'])) :
                echo "
            <div class='alert alert-danger'>
                <p>" . $_SESSION['msg'] . "</p>
            </div>";
            endif;
            unset($_SESSION['erro']);
            unset($_SESSION['sucesso']);
            unset($_SESSION['msg']);

            echo "
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
            $blocked = $accessNvl == 3 ? "<strong>(acesso negado)</strong>" : "";

            echo "
                <tr>
                    <th scope='row'>$dados[funcionario_id]</th>
                    <td class='{$this->nivelacesso_id}'>$dados[nome]{$blocked}</td>
                    <td>$dados[login]</td>
                    <td>{$this->dtEntrada}</td>
                    <td>$dados[celular]</td>
                    <td>$dados[endereco]</td>
                    <td>{$this->ativo}</td>                
                    <td>
                        <div class=' text-center'>
                            <a href='" . DIRPAGE . 'cadastro_funcio/editando/' . "$dados[funcionario_id]'><button type='button' class='btn btn-success'>Editar</button></a>
                            <a href='" . DIRPAGE . 'cadastro_funcio/confirmar_exclusao/' . "$dados[funcionario_id]'><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modalExemplo'>Excluir</button></a>

                        </div>
                            
                    </td>
                </tr>";
        }
        echo "
                </tbody >
            </table>
            <div class='col text-center'>
                <a href='" . DIRPAGE . 'home' . "'><button type='button' class='btn btn-warning btn-lg text-uppercase'>Voltar</button></a>
                <a href='" . DIRPAGE . 'cadastro_funcio' . "'><button type='button' class='btn btn-primary btn-lg text-uppercase'>Cadastrar</button></a><br>                
            </div>
        </div>
        <script src='" . DIRJS . 'jquery.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>
        ";
    }

    # Método que irá abrir a tela de ediçao do funcionário solicitado
    public function editando($funcionario_id){ # Formulario de ediçao do Funcionário
        $this->recebeVariaveis();
        $Array = $this->procurarFuncionario($funcionario_id);
        foreach ($Array as $dados) {
            # NIVEL DE ACESSO
            $nvlAcessoNeg = "";
            $nvlAcessoFunc = "";
            $nvlAcessoAdm = "";
            if ($dados['nivelacesso_id'] == 3) :
                $nvlAcessoNeg = "selected";
            elseif ($dados['nivelacesso_id'] == 1) :
                $nvlAcessoAdm = "selected";
            elseif ($dados['nivelacesso_id'] == 2) :
                $nvlAcessoFunc = "selected";
            endif;
            # FUNCAO DO FUNCIONARIO
            $funcaoFunc = "";
            $funcaoDent = "";
            if ($dados['funcao_id'] == 1) :
                $funcaoFunc = "selected";
            elseif ($dados['funcao_id'] == 2) :
                $funcaoDent = "selected";
            endif;

            echo "
            <link href='" . DIRCSS . 'bootstrap.min.css' . "' rel='stylesheet'/>
            <link href='" . DIRCSS . 'style.css' . "' rel='stylesheet'/>
            <link href='" . DIRCSS . 'bootstrap.css' . "' rel='stylesheet'/>
            
            <body class='fundo'>
            <div class='container'>
                <div class='row'>
                    <div class='col-sm-auto col-md-auto col-lg-auto mx-auto'>
                        <div class='fundoLogado card card-signin my-5'>
                            <div class='card-body'>";
                                if (isset($_SESSION['sucesso'])) :
                                    echo "
                                                    <div class='alert alert-success'>
                                                        <p>" . $_SESSION['msg'] . "</p>
                                                    </div>";
                                elseif (isset($_SESSION['erro'])) :
                                    echo "
                                                    <div class='alert alert-danger'>
                                                        <p>" . $_SESSION['msg'] . "</p>
                                                    </div>";
                                endif;
                                unset($_SESSION['erro']);
                                unset($_SESSION['sucesso']);
                                unset($_SESSION['msg']);
                                echo "
                                <h5 class='card-title text-center'>Editando:  $dados[nome] </h5>
                                <form class='form-signin' action='" . DIRPAGE . 'cadastro_funcio/editar' . "' method='POST'>
                                    <input name='funcionario_id' type='hidden' value='$dados[funcionario_id]' id='inputID'>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <input name='nome' type='text' class='form-control' id='inputNome' value='$dados[nome]' placeholder='Nome' autocomplete='off'>
                                            <label for='inputNome'>nome</label>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group'>
                                                <input name='login' type='text' class='form-control' id='inputUsuario' value='$dados[login]' placeholder='Usuário' autocomplete='off'>
                                                <label for='inputUsuario'>Usuário</label>
                                            </div>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group '>
                                                <input name='senha' type='password' class='form-control' id='inputPassword' placeholder='Se nao for alterar, deixe em branco' autocomplete='off'>
                                                <label for='inputPassword'>Senha</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <input name='email' type='email' class='form-control' id='inputEmail' value='$dados[email]' placeholder='Email' autocomplete='off'>
                                            <label for='inputEmail'>E-mail</label>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <input name='endereco' type='text' class='form-control' id='inputAddress' value='$dados[endereco]' placeholder='Endereço' autocomplete='off'>
                                            <label for='inputAddress'>Endereço</label>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <input name='celular' type='number' class='form-control' id='inputPhone' value='$dados[celular]' placeholder='Celular' autocomplete='off'>
                                            <label for='inputPhone'>Celular</label>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group'>
                                                <input name='cpf' type='number' class='form-control' id='inputCpf' value='$dados[cpf]' placeholder='CPF' autocomplete='off'>
                                                <label for='inputCpf'>CPF</label>
                                            </div>
                                        </div>

                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group'>
                                                <input name='rg' type='number' class='form-control' id='inputRg' value='$dados[rg]' placeholder='RG' autocomplete='off'>
                                                <label for='inputRg'>RG</label>
                                            </div>
                                        </div>
                                        <input name='ativo' type='hidden' id='inputAtivo' value='$dados[ativo]'>
                                    </div>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <select name='nivelacesso_id' id='inputNvlAcesso' class='form-control'>
                                                <option value='3' {$nvlAcessoNeg}>Acesso negado</option>
                                                <option value='2' {$nvlAcessoFunc}>Funcionario</option>
                                                <option value='1' {$nvlAcessoAdm}>Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='form-group '>
                                        <div class='form-label-group'>
                                            <select name='funcao_id' id='inputFuncao' class='form-control'>
                                                <option value='1' {$funcaoFunc}>Funcionario</option>
                                                <option value='2'{$funcaoDent}>Dentista</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class='col text-center'>
                                        <a href='" . DIRPAGE . 'cadastro_funcio/listar' . "'><button type='button' class='btn btn-lg text-uppercase btn-warning'>Voltar</button></a>
                                        <button name='btn-editar' type='submit' class='btn btn-lg text-uppercase btn-danger'>Atualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src='" . DIRJS . 'jquery.min.js' . "'></script>
            <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
            <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
            </body>
            ";
        }
    }

    public function editar(){
        $this->recebeVariaveis();
        $validar = $this->verificarCadastro($this->login, $this->funcionario_id);
        if ($validar == true) { # Quer dizer que o cadastro já existe
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Sinto muito, <br>usuario inserido já existe :(";
        } else {
            $ok = $this->editarFuncionario($this->funcionario_id, $this->nome, $this->cpf, $this->rg, $this->celular, $this->email, $this->endereco, $this->funcao_id, $this->nivelacesso_id);
            if ($ok): # Verificando se o update da tabela funcionarios deu certo
                $this->usuario = new ClassUsuario();
                $B = $this->usuario->editarUsuario($this->login, $this->senha, $this->nivelacesso_id, $this->cpf);
                if ($B): # Verificando se o update da tabela usuarios deu certo
                    $_SESSION['sucesso'] = true;
                    $_SESSION['msg'] = "Atualizado com sucesso!";
                else:
                    $_SESSION['erro'] = true;
                    $_SESSION['msg'] = "Sinto muito, <br>ocorreu um erro ao tentar atualizar o usuário :(";
                endif;
            else:
                $_SESSION['erro'] = true;
                $_SESSION['msg'] = "Sinto muito, <br>ocorreu um erro ao tentar atualizar o funcionário :(";
            endif;
        }
        header('Location: ' . DIRPAGE . 'cadastro_funcio/editando/' . $this->funcionario_id);
        exit();
    }

    public function confirmar_exclusao($funcionario_id){
        $this->recebeVariaveis();
        echo "
        <link href='" . DIRCSS . 'bootstrap.min.css' . "' rel='stylesheet'/>
        <link href='" . DIRCSS . 'style.css' . "' rel='stylesheet'/>
        <link href='" . DIRCSS . 'bootstrap.css' . "' rel='stylesheet'/>
        <body class='fundo'>

        <div style='outline: none' id='modalExemplo' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLabel'>Tem certeza que deseja continuar?</h5>
                        <a href='" . DIRPAGE . 'cadastro_funcio/listar' . "'> <button style='outline: none' type='button' class='close' data-dismiss='modal' aria-label='Fechar'>
                            <span aria-hidden='true'>&times;</span>
                        </button></a>
                    </div>
                    <div style='color: darkred;outline: none' class='modal-body'>
                        <strong>O funcionário selecionado será excluído permanentemente!<br>(muito tempo!)</strong>
                    </div>
                    <div class='modal-footer'>
                        <a href='" . DIRPAGE . 'cadastro_funcio/listar/' . "'><button type='button' class='btn btn-primary' data-dismiss='modal'>Voltar</button></a>
                        <a href='" . DIRPAGE . 'cadastro_funcio/excluir/' . "{$funcionario_id}'><button type='button' class='btn btn-danger'>Excluir</button></a>
                    </div>
                </div>
            </div>
        </div>
        <script src='" . DIRJS . 'jquery.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>";
    }

    public function excluir($funcionario_id){
        $this->recebeVariaveis();
        $this->usuario = new ClassUsuario();
        $U = $this->usuario->excluirUsuario($funcionario_id);
        if($U):
            $F = $this->excluirFuncionario($funcionario_id);
            if($F):
                $_SESSION['sucesso'] = true;
                $_SESSION['msg'] = "Funcionario/Usuario excluídos com sucesso!";
            else:
                $_SESSION['erro'] = true;
                $_SESSION['msg'] = "Sinto muito, ocorreu um erro ao tentar atualizar o funcionário :(";
            endif;
        else:
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Sinto muito, ocorreu um erro ao tentar atualizar o usuário :(";
        endif;
        header('Location: ' . DIRPAGE . 'cadastro_funcio/listar');
        exit();
    }
}