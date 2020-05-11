<?php

namespace App\Controller;

use App\Model\ClassCliente;
use App\Model\ClassConsulta;
use App\Model\ClassFuncionario;
use DateTimeZone;
use Src\Classes\ClassRender;



setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


class ControllerConsulta extends ClassConsulta {
    use \Src\Traits\TraitUrlParser;
    protected $consulta_id;
    protected $dtConsulta;
    protected $hr_inicio;
    protected $hr_final;
    protected $custo;
    protected $desconto;
    protected $dtAbertura;
    protected $dtEncerr;
    protected $problema;
    protected $solucao;
    protected $situacao;
    protected $cliente_id;
    protected $funcionario_id;
    protected $funcao_id;

    public function __construct(){
        if (count($this->parseUrl()) == 1) {
            $render = new ClassRender();
            if (isset($_SESSION['logado'])) {
                if ($_SESSION['nivelacesso'] > 2):
                    header('Location: ' . DIRPAGE . 'login');
                    exit();
                else:
                    $render->setTitle("Consultório OdontoMonicao");
                    $render->setDir("consulta");
                    $render->renderLayout();
                endif;
            } elseif (isset($_SESSION['nao_logado'])) {
                header('Location: ' . DIRPAGE . 'login');
                exit();
            }
        }
    }
    # Irá receber as variáveis
    public function recebeVariaveis(){
        if($_SESSION['nivelacesso'] == 3):
            unset($_SESSION['msg']); unset($_SESSION['erro']); unset($_SESSION['sucesso']);
            header('Location: ' . DIRPAGE . 'login');
            exit();
        else:
            if (isset($_POST['consulta_id'])){$this->consulta_id = filter_input(INPUT_POST, 'consulta_id', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['dtConsulta'])){$this->dtConsulta = filter_input(INPUT_POST, 'dtConsulta', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['hr_inicio'])){ $this->hr_inicio = filter_input(INPUT_POST, 'hr_inicio', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['hr_final'])){$this->hr_final = filter_input(INPUT_POST, 'hr_final', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['custo'])){$this->custo = filter_input(INPUT_POST, 'custo', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['desconto'])){$this->desconto = filter_input(INPUT_POST, 'desconto', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['dtAbertura'])){$this->dtAbertura = filter_input(INPUT_POST, 'dtAbertura', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['dtEncerr'])){$this->dtEncerr = filter_input(INPUT_POST, 'dtEncerr', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['problema'])){$this->problema = filter_input(INPUT_POST, 'problema', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['solucao'])){$this->solucao = filter_input(INPUT_POST, 'solucao', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['situacao'])){$this->situacao = filter_input(INPUT_POST, 'situacao', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['cliente_id'])){$this->cliente_id = filter_input(INPUT_POST, 'cliente_id', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['funcionario_id'])){$this->funcionario_id = filter_input(INPUT_POST, 'funcionario_id', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['funcao_id'])){$this->funcao_id = filter_input(INPUT_POST, 'funcao_id', FILTER_SANITIZE_SPECIAL_CHARS);}
        endif;
    }
    public function monthPT_BR(){
        return strtoupper(strftime('%B / %Y', strtotime('today')));
    }
    public function cadastro($dtConsulta){
        $this->recebeVariaveis();
        $cliente = new ClassCliente();
        $clienteArray = $cliente->listarClientes();
        $funcio = new ClassFuncionario();
        $funcioArray = $funcio->listarDentistas();
        ?>
        <link href="<?php echo DIRCSS . 'bootstrap.min.css' ?>" rel="stylesheet"/>
        <link href="<?php echo DIRCSS . 'style.css' ?>" rel="stylesheet"/>
        <link href="<?php echo DIRCSS . 'bootstrap.css' ?>" rel="stylesheet"/>
        <body class="fundo">
        <div class="container">
            <div class="row">
                <div class="col-sm-auto col-md-auto col-lg-auto mx-auto">
                    <div class="fundoLogado card card-signin my-5">
                        <div class="card-body">
                            <?php
                            if (isset($_SESSION['status_consulta'])) :
                                ?>
                                <div class='alert alert-success'>
                                    <p>Consulta cadastrada com sucesso!</p>
                                </div>
                            <?php endif;
                            unset($_SESSION['status_consulta']); ?>
                            <?php
                            if (isset($_SESSION['consulta_existe'])) :
                                ?>
                                <div class='alert alert-danger'>
                                    <p>Oops... algo deu errado! :(</p>
                                </div>
                            <?php endif;
                            unset($_SESSION['consulta_existe']); ?>
                            <h5 class="card-title text-center">Cadastro de Consulta</h5>
                            <form class="form-signin" action="<?php echo DIRPAGE.'consulta/cadastrar'?>" method="POST">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <input name="dtConsulta" type="text" class="form-control" id="inputDtConsulta" placeholder="dtConsulta" autocomplete="off" value="<?php echo $dtConsulta;?>" required>
                                        <label for="inputDtConsulta">Data da Consulta</label>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <input name="hr_inicio" type="time" class="form-control" id="inputHr_inicio" placeholder="hr_inicio" autocomplete="off" required>
                                            <label for="inputHr_inicio">Horário Início</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group ">
                                            <input name="hr_final" type="time" class="form-control" id="inputHr_final" placeholder="hr_final" autocomplete="off" required>
                                            <label for="inputHr_final">Horário Final</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <input name="custo" type="number" class="form-control" id="inputCusto" placeholder="Custo" autocomplete="off" required>
                                            <label for="inputCusto">Custo</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <input name="desconto" type="number" class="form-control" id="inputDesconto" placeholder="Desconto" autocomplete="off" required>
                                            <label for="inputDesconto">Desconto</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <textarea name="problema" class="form-control" id="inputProblema" placeholder="Problema" required></textarea>
                                    </div>
                                </div><!--
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <textarea name="solucao" class="form-control" id="inputSolucao" placeholder="Solucao" required></textarea>
                                    </div>
                                </div>-->
                                <div class="form-group">
                                    <div class="form-label-group text-center">
                                        Situacao: <input name="situacao" type="checkbox" id="inputSituacao" value="true">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-label-group">
                                        <select name="cliente_id" id="inputCliente" class="form-control">
                                            <option selected>Selecione o cliente</option>
                                            <?php
                                            foreach ($clienteArray as $dadosCliente){
                                                echo "
                                                <option value='$dadosCliente[cliente_id]'>$dadosCliente[cli_nome]</option>
                                                ";
                                            }?>

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-label-group">
                                        <select name="funcionario_id" id="inputFuncionario" class="form-control">
                                            <option value="#">Selecione o profissional</option>
                                            <?php
                                                foreach ($funcioArray as $dadosFuncio){
                                                    echo "
                                                    <option value='$dadosFuncio[funcionario_id]'>$dadosFuncio[nome]</option>
                                                    ";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="form-row">
                                        <div class="form-group col-md-7">
                                            <a href="<?php echo DIRPAGE . 'consulta/listar'; ?>"><button id="listarConsulta" type="button" class="my-btn btn btn-warning btn-lg text-uppercase">Listar Consultas</button></a>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <button type="submit" class="btn btn-primary btn-block btn-lg text-uppercase">Cadastrar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo DIRJS . 'jquery.min.js' ?>"></script>
        <script src="<?php echo DIRJS . 'bootstrap.min.js' ?>"></script>
        <script src="<?php echo DIRJS . 'bootstrap.bundle.min.js'?>"></script>
        </body>
        <?php

    }
    public function cadastrar(){
        $this->recebeVariaveis();
        /*var_dump($this->dtConsulta);echo "<br>";
        var_dump($this->hr_inicio);echo "<br>";
        var_dump($this->hr_final);echo "<br>";
        var_dump($this->custo);echo "<br>";
        var_dump($this->desconto);echo "<br>";
        var_dump($this->problema);echo "<br>";
        var_dump($this->solucao);echo "<br>";
        var_dump($this->situacao);echo "<br>";
        var_dump($this->cliente_id);echo "<br>";
        var_dump($this->funcionario_id);echo "<br>";*/

        if($this->situacao==true){
            $this->situacao=1;
        }else{
            $this->situacao=0;
        }
        $validar = $this->verificarHorario($this->funcionario_id,$this->dtConsulta,$this->hr_inicio,$this->hr_final);
        if($validar==true):
            $_SESSION['consul_existe']=true;
        else:
            $this->abrirConsultas($this->dtConsulta,$this->hr_inicio,$this->hr_final,$this->custo,$this->desconto,$this->problema,$this->situacao,$this->cliente_id,$this->funcionario_id);
            $_SESSION['status_consulta'] = true;
        endif;
        /*header('Location: ' . DIRPAGE . 'consulta/cadastro/' . $this->dtConsulta);
        exit();*/
    }
}
