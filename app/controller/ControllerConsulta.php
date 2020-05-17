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
    # Atributos que irao receber listas(arrays)
    protected $clienteNome;
    protected $funcioNome;
    protected $horarioInicio;

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
            if (isset($_POST['consulta_id'])){$this->consulta_id = filter_input(INPUT_POST, 'consulta_id');}
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
        $horarioArray = $this->listarHorarios();
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
                                    <p><?php echo $_SESSION['msg'];?></p>
                                </div>
                            <?php endif;
                            unset($_SESSION['status_consulta']); ?>
                            <?php
                            if (isset($_SESSION['erro'])) :
                                ?>
                                <div class='alert alert-danger'>
                                    <p><?php echo $_SESSION['msg'];?></p>
                                </div>
                            <?php endif;
                            unset($_SESSION['erro']);
                            unset($_SESSION['msg']);
                            ?>
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
                                            <select name="hr_inicio" id="inputHr_inicio" class="form-control">
                                                <option selected>Selecionar horário inicial</option>
                                                <?php
                                                foreach ($horarioArray as $hr_inicial){
                                                    echo "
                                                <option value='$hr_inicial[horario_id]'>$hr_inicial[horario]</option>
                                                ";
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <select name="hr_final" id="inputHr_final" class="form-control">
                                                <option selected>Selecionar horário final</option>
                                                <?php
                                                foreach ($horarioArray as $hr_final){
                                                    echo "
                                                <option value='$hr_final[horario_id]'>$hr_final[horario]</option>
                                                ";
                                                }?>
                                            </select>
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
                                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                            <input name="situacao" type="checkbox" class="custom-control-input" id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Situação pagamento</label>
                                        </div>
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
        if($this->situacao==true){ # A situaçao é o checkbox do formulário
            $this->situacao=1;
        }else{
            $this->situacao=0;
        }
        $validar = $this->verificarHorario($this->consulta_id,$this->funcionario_id,$this->dtConsulta,$this->hr_inicio,$this->hr_final);
        if($validar==true):
            header('Location: ' . DIRPAGE . 'consulta/cadastro/' . $this->dtConsulta);
            exit();
        else:
            $C = $this->abrirConsultas($this->dtConsulta,$this->hr_inicio,$this->hr_final,$this->custo,$this->desconto,$this->problema,$this->situacao,$this->cliente_id,$this->funcionario_id);
            if($C==true):
                $_SESSION['status_consulta'] = true;
                $_SESSION['msg'] = "Consulta marcada com sucesso!";
            else:
                $_SESSION['erro'] = true;
                $_SESSION['msg'] = "Ocorreu um erro ao tentar abrir a consulta :(";
            endif;
        endif;
        header('Location: ' . DIRPAGE . 'consulta/cadastro/' . $this->dtConsulta);
        exit();
    }
    public function listar(){
        $this->recebeVariaveis();
        $Array = $this->listarConsultas();
        $cliente = new ClassCliente();
        $clienteArray = $cliente->listarClientes(); # listar todos os clientes cadastrados
        $funcio = new ClassFuncionario();
        $funcioArray = $funcio->listarDentistas(); # listar funcionários(que sao dentistas
        $horarioArray = $this->listarHorarios(); # listar todos os horários na combo-box

        ?>
        <link href="<?php echo DIRCSS . 'bootstrap.min.css' ?>" rel="stylesheet"/>
        <link href="<?php echo DIRCSS . 'style.css' ?>" rel="stylesheet"/>
        <link href="<?php echo DIRCSS . 'bootstrap.css' ?>" rel="stylesheet"/>
        <body class="fundo">
            <?php
            if (isset($_SESSION['sucesso'])): ?>

            <div class='alert alert-success'>
                <p><?php echo $_SESSION['msg'];?></p>
            </div>
            <?php
            elseif (isset($_SESSION['erro'])) :
            ?>
            <div class='alert alert-danger'>
                <p><?php echo $_SESSION['msg'];?></p>
            </div>
            <?php
            endif;
            unset($_SESSION['erro']);
            unset($_SESSION['sucesso']);
            unset($_SESSION['msg']);
            ?>
            <div class='tabelaFunc table-responsive'>
                <table class='table table-hover table-dark table-striped table-bordered'>
                    <thead class='thead-dark '>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Cliente</th>
                        <th scope='col'>Profissional</th>
                        <th scope='col'>Data Consulta</th>
                        <th scope='col'>Hora</th>
                        <th scope='col'>Problema</th>
                        <th scope='col'>Custo</th>
                        <th scope='col'>Situação</th>
                    </tr>
                    </thead>
                    <tbody>

                <?php foreach ($Array as $dados) {
                    foreach ($clienteArray as $cliente){
                        if($cliente['cliente_id'] == $dados['cliente_id']){
                            $this->clienteNome = $cliente['cli_nome'];
                        }
                    }
                    foreach ($funcioArray as $funcio){
                        if($funcio['funcionario_id'] == $dados['funcionario_id']){
                            $this->funcioNome = $funcio['nome'];
                        }
                    }
                    foreach ($horarioArray as $horario){
                        if($horario['horario_id'] == $dados['hr_inicio']){
                            $this->horarioInicio = $horario['horario'];
                        }
                    }
                    $situation = "$dados[situacao]";
                    $this->situacao = !(empty($dados['dtEncerr'])) ? "<strong style='color:red'>Encerrado</strong>" : ($this->situacao = $situation == 1 ? "<strong style='color:lightgreen'>Pago</strong>" : "<strong style='color:lightcoral'>Pendente</strong>");

                    $this->dtConsulta = date('d/m/Y', strtotime("$dados[dtConsulta]"));

                    echo "<tr>
                        <th scope='row'>$dados[consulta_id]</th>
                        <td>{$this->clienteNome}</td>
                        <td>{$this->funcioNome}</td>
                        <td>{$this->dtConsulta}</td>
                        <td>{$this->horarioInicio}</td>
                        <td>$dados[problema]</td>
                        <td>R$$dados[custo],00</td>
                        <td>{$this->situacao}</td>
                        
                        <td>
                            <div class=' text-center'>
                                <a href='" . DIRPAGE . 'consulta/editando/' . "$dados[consulta_id]'><button type='button' class='btn btn-success'>Editar</button></a>
                                <a href='" . DIRPAGE . 'consulta/confirmar_exclusao/' . "$dados[consulta_id]'><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modalExemplo'>Excluir</button></a>
                            </div>
                        </td>
                    </tr>";
                    }
                    echo "
                    </tbody >
                </table>
                <div class='col text-center'>
                    <a href='" . DIRPAGE . 'home' . "'><button type='button' class='btn btn-warning btn-lg text-uppercase'>Voltar</button></a>
                    <a href='" . DIRPAGE . 'consulta' . "'><button type='button' class='btn btn-primary btn-lg text-uppercase'>Calendário</button></a><br>
                </div>
            </div>
            <script src='" . DIRJS . 'jquery.min.js' . "'></script>
            <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
            <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>
        ";
    }

    public function editando($consulta_id){
        $funcionario_id = $this->buscarFuncionario($consulta_id);
        $funcio = new ClassFuncionario();
        $funcioArray = $funcio->listarDentistas(); # listar funcionários(que sao dentistas
        $horarioArray = $this->listarHorarios();
        $consulArray = $this->buscarConsulta($consulta_id);
        $hr_inicioid = $this->recHrInicio($consulta_id);
        $hr_finalid = $this->recHrFinal($consulta_id);
        ?>
        <?php
        foreach ($consulArray as $dadosConsul){
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
                                    <p><?php echo $_SESSION['msg'];?></p>
                                </div>
                            <?php endif;
                            unset($_SESSION['status_consulta']); ?>
                            <?php
                            if (isset($_SESSION['erro'])) :
                                ?>
                                <div class='alert alert-danger'>
                                    <p><?php echo $_SESSION['msg'];?></p>
                                </div>
                            <?php endif;
                            unset($_SESSION['erro']);
                            unset($_SESSION['msg']);
                            ?>
                            <h5 class="card-title text-center">Editando consulta nº: <?php echo $dadosConsul['consulta_id'];?></h5>
                            <form class="form-signin" action="<?php echo DIRPAGE.'consulta/editar'?>" method="POST">
                                <input name="consulta_id" type="hidden" value="<?php echo $dadosConsul['consulta_id'];?>">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <input value="<?php echo $dadosConsul['dtConsulta'];?>" name="dtConsulta" type="text" class="form-control" id="inputDtConsulta" placeholder="dtConsulta" autocomplete="off"  required>
                                        <label for="inputDtConsulta">Data da Consulta</label>
                                    </div>
                                </div>
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <select name="hr_inicio" id="inputHr_inicio" class="form-control">
                                                <option selected>Selecionar horário inicial</option>
                                                <?php
                                                foreach ($horarioArray as $dados_hr_inicio){
                                                    $hr_inicio = $dados_hr_inicio['horario_id'] == $hr_inicioid ? "selected" : "";
                                                    echo "
                                                        <option value='$dados_hr_inicio[horario_id]' {$hr_inicio}>$dados_hr_inicio[horario]</option>
                                                    ";
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <select name="hr_final" id="inputHr_final" class="form-control">
                                                <option selected>Selecionar horário final</option>
                                                <?php
                                                foreach ($horarioArray as $dados_hr_final){
                                                    $hr_final = $dados_hr_final['horario_id'] == $hr_finalid ? "selected" : "";
                                                    echo "
                                                        <option value='$dados_hr_final[horario_id]' {$hr_final}>$dados_hr_final[horario]</option>
                                                    ";
                                                }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <input value="<?php echo $dadosConsul['custo'];?>" name="custo" type="number" class="form-control" id="inputCusto" placeholder="Custo" autocomplete="off" required>
                                            <label for="inputCusto">Custo</label>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-label-group">
                                            <input value="<?php echo $dadosConsul['desconto'];?>" name="desconto" type="number" class="form-control" id="inputDesconto" placeholder="Desconto" autocomplete="off" required>
                                            <label for="inputDesconto">Desconto</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Problema</label>
                                    <textarea name="problema" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $dadosConsul['problema'];?></textarea>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group text-center">
                                        <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                            <input name="situacao" type="checkbox" class="custom-control-input" id="customControlInline" <?php echo $dadosConsul['situacao'] == 1 ? "checked" : "";?>>
                                            <label class="custom-control-label" for="customControlInline">Situação pagamento</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="form-label-group">
                                        <select name="funcionario_id" id="inputFuncionario" class="form-control">
                                            <option value="#">Selecione o profissional</option>
                                            <?php
                                            foreach ($funcioArray as $dadosFuncio){
                                                $funcSelecionado = $dadosFuncio['funcionario_id'] == $funcionario_id ? "selected" : "";
                                                echo "
                                                    <option value='$dadosFuncio[funcionario_id]' {$funcSelecionado}>$dadosFuncio[nome]</option>
                                                ";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col text-center">
                                    <a href="<?php echo DIRPAGE . 'consulta/listar'; ?>"><button type='button' class='btn btn-lg text-uppercase btn-warning'>Voltar</button></a>
                                    <a href="<?php echo DIRPAGE . 'consulta/confirmar_encerramento/'.$dadosConsul['consulta_id'] ; ?>"><button type='button' class='btn btn-lg text-uppercase btn-outline-danger'>Encerrar</button></a>
                                    <button name='btn-editar' type='submit' class='btn btn-lg text-uppercase btn-danger'>Atualizar</button>
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
    }
    public function editar(){
        $this->recebeVariaveis();

        if($this->situacao==true){ # A situaçao é o checkbox do formulário
            $this->situacao=1;
        }else{
            $this->situacao=0;
        }

        $validar = $this->verificarHorario($this->consulta_id,$this->funcionario_id,$this->dtConsulta,$this->hr_inicio,$this->hr_final);
        if($validar==true):
            header('Location: ' . DIRPAGE . 'consulta/editando/' . $this->consulta_id);
            exit();
        else:
            $C = $this->editarConsulta($this->consulta_id,$this->dtConsulta,$this->hr_inicio,$this->hr_final,$this->custo,$this->desconto,$this->problema,$this->situacao,$this->funcionario_id);
            if($C==true):
                $_SESSION['status_consulta'] = true;
                $_SESSION['msg'] = "Consulta editada com sucesso!";
            else:
                $_SESSION['erro'] = true;
                $_SESSION['msg'] = "Ocorreu um erro ao tentar editar a consulta :(";
            endif;
        endif;
        header('Location: ' . DIRPAGE . 'consulta/editando/' . $this->consulta_id);
        exit();

    }
    # método que irá mostrar uma página de confirmaçao de exclusao
    public function confirmar_exclusao($consulta_id){
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
                        <a href='" . DIRPAGE . 'consulta/listar' . "'> <button style='outline: none' type='button' class='close' data-dismiss='modal' aria-label='Fechar'>
                            <span aria-hidden='true'>&times;</span>
                        </button></a>
                    </div>
                    <div style='color: darkred;outline: none' class='modal-body'>
                        <strong>A consulta selecionada será excluída permanentemente!<br>(muito tempo!)</strong>
                    </div>
                    <div class='modal-footer'>
                        <a href='" . DIRPAGE . 'consulta/listar/' . "'><button type='button' class='btn btn-lg text-uppercase btn-primary' data-dismiss='modal'>Voltar</button></a>
                        <a href='" . DIRPAGE . 'consulta/excluir/' . "{$consulta_id}'><button type='button' class='btn btn-lg text-uppercase btn-danger'>Excluir</button></a>
                    </div>
                </div>
            </div>
        </div>
        <script src='" . DIRJS . 'jquery.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>";
    }
    # Método que irá encerrar a consulta(sem excluir ela)
    public function confirmar_encerramento($consulta_id){
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
                        <h5 class='modal-title' id='exampleModalLabel'>Encerramento da consulta nº: {$consulta_id}</h5>
                        <a href='" . DIRPAGE . 'consulta/listar' . "'> <button style='outline: none' type='button' class='close' data-dismiss='modal' aria-label='Fechar'>
                            <span aria-hidden='true'>&times;</span>
                        </button></a>
                    </div>
                    <div style='color: darkred;outline: none' class='modal-body'>
                        <strong>Coloque abaixo a solução do problema.</strong>
                        <form class='form-signin' action='". DIRPAGE. 'consulta/encerrar' . "' method='POST'>
                            <input name='consulta_id' type='hidden' value='". $consulta_id ."'>
                            <div class='form-group'>
                                <label for='message-text' class='col-form-label'>Solução:</label>
                                <textarea name='solucao' class='form-control' id='message-text' required></textarea>
                            </div>
                            <div class='modal-footer'>
                                <a href='" . DIRPAGE . 'consulta/listar/' . "'><button type='button' class='btn btn-primary' data-dismiss='modal'>Voltar</button></a>
                                <button type='submit' class='btn btn-lg text-uppercase btn-danger'>Encerrar</button>
                            </div>
                        </form>               
                    </div>
                    
                </div>
            </div>
        </div>
        <script src='" . DIRJS . 'jquery.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>";
    }
    # Método que irá encerrar a consulta
    public function encerrar(){
        $this->recebeVariaveis();
        var_dump($this->consulta_id); echo "<br>";
        var_dump($this->solucao);
        $C = $this->encerrarConsulta($this->consulta_id, $this->solucao);
        if($C):
            $_SESSION['sucesso'] = true;
            $_SESSION['msg'] = "Consulta encerrada com sucesso!";
        else:
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Sinto muito, ocorreu um erro ao tentar encerrar a consulta :(";
        endif;
        header('Location: ' . DIRPAGE . 'consulta/listar');
        exit();
    }
    # Método que irá excluir definitivamente a consulta
    public function excluir($consulta_id){
        $this->recebeVariaveis();
        $C = $this->excluirConsulta($consulta_id);
        if($C):
            $_SESSION['sucesso'] = true;
            $_SESSION['msg'] = "Consulta excluída com sucesso!";
        else:
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Sinto muito, ocorreu um erro ao tentar excluir a consulta :(";
        endif;
        header('Location: ' . DIRPAGE . 'consulta/listar');
        exit();
    }
}