<?php
namespace App\Controller;

use App\Model\ClassCliente;
use Src\Classes\ClassRender;

class ControllerCadastroCliente extends ClassCliente{
    protected $cliente_id;
    protected $cli_nome;
    protected $cli_cpf;
    protected $cli_rg;
    protected $cli_cep;
    protected $celular;
    protected $cli_email;
    protected $endereco;
    use \Src\Traits\TraitUrlParser;

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
                    $render->setTitle("Cadastro de Clientes");
                    $render->setDir("cadastro_cliente");
                    $render->renderLayout();
                endif;
            } elseif (isset($_SESSION['nao_logado'])) {
                header('Location: ' . DIRPAGE . 'login');
                exit();
            }
        }
    }

    # Vai receber as variaveis
    public function recebeVariaveis(){
        if ($_SESSION['nivelacesso'] >= 2):
            unset($_SESSION['msg']); unset($_SESSION['erro']); unset($_SESSION['sucesso']);
            header('Location: ' . DIRPAGE . 'login');
            exit();
        else:
            if (isset($_POST['cliente_id'])){$this->cliente_id = $_POST['cliente_id'];}
            if (isset($_POST['cli_nome'])){$this->cli_nome = filter_input(INPUT_POST, 'cli_nome', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['cli_cpf'])){$this->cli_cpf = filter_input(INPUT_POST, 'cli_cpf', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['cli_rg'])){$this->cli_rg = filter_input(INPUT_POST, 'cli_rg', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['cli_cep'])){$this->cli_cep = filter_input(INPUT_POST, 'cli_cep', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['celular'])){$this->celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['cli_email'])){$this->cli_email = filter_input(INPUT_POST, 'cli_email', FILTER_SANITIZE_SPECIAL_CHARS);}
            if (isset($_POST['endereco'])){$this->endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);}
        endif;
    }

    # Chamar método de cadastro da ClassCadastro
    public function cadastrar(){
        $this->recebeVariaveis();

        $validar = $this->verificarCadastro($this->cli_cpf, $this->cli_rg, $this->cli_email, $this->cliente_id);
        if ($validar == true): # Quer dizer que o cadastro já existe
            $_SESSION['cliente_existe'] = true;
            $_SESSION['msg_erro'] = "Algum dos dados digitados já existe na base de dados :(<br>Por favor, insira outro! =)";
        else:
            $C = $this->salvarCliente($this->cli_nome, $this->cli_cpf, $this->cli_rg, $this->cli_cep, $this->celular, $this->cli_email, $this->endereco);
            if ($C == true):
                $_SESSION['status_cadastro'] = true;
            else:
                $_SESSION['erro'] = true;
                $_SESSION['msg_erro'] = "Sinto muito, <br> Ocorreu um erro durante a o cadastro do cliente :(";
            endif;
        endif;
        header('Location: ' . DIRPAGE . 'cadastro_cliente');
        exit();
    }
    public function listar(){
        $this->recebeVariaveis();
        $Array = $this->listarClientes();
        if($Array!=null):
        echo "
        <link href='" . DIRCSS . 'bootstrap.min.css' . "' rel='stylesheet'/>
        <link href='" . DIRCSS . 'style.css' . "' rel='stylesheet'/>
        <link href='" . DIRCSS . 'bootstrap.css' . "' rel='stylesheet'/>
        <body class='fundoLogado'>";
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
        unset($_SESSION['sucesso']);
        unset($_SESSION['erro']);
        unset($_SESSION['msg']);
        unset($_SESSION['msg_erro']);
        echo "
        <div class='tabelaFunc table-responsive'>
            <table class='table table-hover table-dark table-striped table-bordered'>
                <thead class='thead-dark '>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Nome cliente</th>
                    <th scope='col'>CPF</th>
                    <th scope='col'>RG</th>
                    <th scope='col'>Celular</th>
                    <th scope='col'>E-mail</th>
                    <th scope='col'>Endereço</th>
                </tr>
                </thead>
                <tbody>";

        foreach ($Array as $dados) {
            echo "
                <tr>
                    <th scope='row'>$dados[cliente_id]</th>
                    <td>$dados[cli_nome]</td>
                    <td>$dados[cli_cpf]</td>
                    <td>$dados[cli_rg]</td>
                    <td>$dados[celular]</td>
                    <td>$dados[cli_email]</td>
                    <td>$dados[endereco]</td>
                    <td>
                        <div class=' text-center'>
                            <a href='" . DIRPAGE . 'cadastro_cliente/editando/' . "$dados[cliente_id]'><button type='button' class='btn btn-success'>Editar</button></a>
                            <a href='" . DIRPAGE . 'cadastro_cliente/confirmar_exclusao/' . "$dados[cliente_id]'><button type='button' class='btn btn-danger' data-toggle='modal' data-target='#modalExemplo'>Excluir</button></a>
                        </div>     
                    </td>
                </tr>";
        }
        echo "
                </tbody >
            </table>
            <div class='col text-center'>
                <a href='" . DIRPAGE . 'home' . "'><button type='button' class='btn btn-warning btn-lg text-uppercase'>Voltar</button></a>
                <a href='" . DIRPAGE . 'cadastro_cliente' . "'><button type='button' class='btn btn-primary btn-lg text-uppercase'>Cadastrar Cliente</button></a><br>
            </div>
        </div>
        <script src='" . DIRJS . 'jquery.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>
        ";
        else:
            ?>
            <link href="<?php echo DIRCSS . 'bootstrap.min.css' ?>" rel="stylesheet"/>
            <link href="<?php echo DIRCSS . 'style.css' ?>" rel="stylesheet"/>
            <link href="<?php echo DIRCSS . 'bootstrap.css' ?>" rel="stylesheet"/>
            <body class="fundo">

            <?php
            unset($_SESSION['erro']);
            unset($_SESSION['sucesso']);
            unset($_SESSION['msg']);
            echo "<h1 style='color: darkred;' class='text-center'>Sem clientes no momento, cadastre algum e logo aparecerá aqui! :)</h1>";
            echo "
            <div class='col text-center'>
                <a href='" . DIRPAGE . 'home' . "'><button type='button' class='btn btn-warning btn-lg text-uppercase'>Voltar</button></a>
                <a href='" . DIRPAGE . 'cadastro_cliente' . "'><button type='button' class='btn btn-primary btn-lg text-uppercase'>Cadastrar Cliente</button></a><br>
            </div>
            <script src='" . DIRJS . 'jquery.min.js' . "'></script>
            <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
            <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
            </body>";
        endif;
    }

    # Método que irá abrir a tela de ediçao do cliente solicitado
    public function editando($cliente_id){ # Formulario de ediçao do Funcionário
        $this->recebeVariaveis();
        $Array = $this->procurarCliente($cliente_id);
        foreach ($Array as $dados) {
            echo "
            <link href='" . DIRCSS . 'bootstrap.min.css' . "' rel='stylesheet'/>
            <link href='" . DIRCSS . 'style.css' . "' rel='stylesheet'/>
            <link href='" . DIRCSS . 'bootstrap.css' . "' rel='stylesheet'/>
            <script src='" . DIRJS . 'jquery.min.js' . "'></script>            
            <script src='https://code.jquery.com/jquery-3.4.1.min.js'
                    integrity='sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo='
                    crossorigin='anonymous'>
            </script>
            <script src='" . DIRJS . 'jquery.mask.min.js' . "'></script>            
            <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
            <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
            <script type='text/javascript'>
                $(document).ready(function () {
                  $(\"#inputCEP\").blur(function () { //ativa o script quando o campo CEP perde o foco
                    var cep = $(this).val().replace(/\D/g, ''); //A expressão \D valida apenas números. O que não for numeral é descartado.
                    if (cep != \"\") {
                      var validacep = /^[0-9]{8}$/; //expressão regular para certificar que o CEP tem exatamente 8 dígitos numéricos de 0 a 9.
                      console.debug(cep);
                      if (validacep.test(cep)) {
                        $(\"#inputAddress\").val(\"...\");
                
                        $.getJSON(\"https://viacep.com.br/ws/\" + cep + \"/json/?callback=?\", function (dados) {
                
                          if (!(\"erro\" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            if (!dados.logradouro) {
                              var logradouro = dados.bairro + \", \" + dados.localidade + \"/\" + dados.uf;
                              $(\"#inputAddress\").val(logradouro);
                            }
                            else {
                              var logradouro = dados.logradouro + \" - \" + dados.bairro + \", \" + dados.localidade + \"/\" + dados.uf;
                              $(\"#inputAddress\").val(logradouro);
                            }
                            var erroCep = document.getElementById('erroCEP');
                            erroCep.hidden=true;
                          } //end if.
                          else {
                            //var erro = \"<div id='erroCEP' style='padding-top: 15px;'><div class='alert alert-danger'><p>CEP não encontrado.</p></div></div>\";
                            //$(\"#card_body\").before(erro);
                            alert(\"CEP não encontrado.\");
                            $(\"#inputCEP\").val(\"\");
                            $(\"#inputAddress\").val(\"\");
                            $(document).ready(function(){
                              $(\"#inputCEP\").focus();
                            });
                          }
                        });
                      } else {
                        /*var erro = \"<div id='erroCEP' style='padding-top: 15px;'><div class='alert alert-danger'><p>Há mais/menos de 8 digitos...</p></div></div>\";
                        $(\"#card_body\").before(erro);*/
                        alert(\"Há mais de 8 digitos...\");
                        $(\"#inputCEP\").val(\"\");
                        $(\"#inputAddress\").val(\"\");
                        $(document).ready(function(){
                          $(\"#inputCEP\").focus();
                        });
                        
                      }
                    }
                  })
                });
                
                $(document).ready(function () {
                  $(\"#inputEmail\").blur(function () {
                    var mail = $(this).val();
                    if (mail != \"\") {
                      validacaoEmail(this);
                    }
                    else {
                
                    }
                  });
                });
                /*function cleanError(){
                  document.getElementById(\"erroCEP\").style.display = \"none\";
                }*/
                function validacaoEmail(field) {
                  usuario = field.value.substring(0, field.value.indexOf(\"@\"));
                  dominio = field.value.substring(field.value.indexOf(\"@\") + 1, field.value.length);
                  if ((usuario.length >= 1) &&
                    (dominio.length >= 3) &&
                    (usuario.search(\"@\") == -1) &&
                    (dominio.search(\"@\") == -1) &&
                    (usuario.search(\" \") == -1) &&
                    (dominio.search(\" \") == -1) &&
                    (dominio.search(\".\") != -1) &&
                    (dominio.indexOf(\".\") >= 1) &&
                    (dominio.lastIndexOf(\".\") < dominio.length - 1)) {
                  }
                  else {
                    document.getElementById(\"inputEmail\").innerHTML = \"<font color='red'>Email inválido </font>\";
                    $(\"#inputEmail\").val(\"\");
                    alert(\"E-mail invalido\");
                    $(document).ready(function () {
                      $(\"#inputEmail\").focus();
                    })
                
                  }
                }
                
                $(document).ready(function(){
                  $(\"#inputCpf\").mask(\"000.000.000-00\")
                  //$(\"#cnpj\").mask(\"00.000.000/0000-00\")
                  //$(\"#telefone\").mask(\"(00) 0000-0000\")
                  //$(\"#salario\").mask(\"999.999.990,00\", {reverse: true})
                  $(\"#inputCEP\").mask(\"00000-000\")
                  //$(\"#dataNascimento\").mask(\"00/00/0000\")
                
                  $(\"#inputRg\").mask(\"99.999.999-W\", {
                    translation: {
                      'W': {
                        pattern: /[X0-9]/
                      }
                    },
                    reverse: true
                  })
                
                  var options = {
                    translation: {
                      'A': {pattern: /[A-Z]/},
                      'a': {pattern: /[a-zA-Z]/},
                      'S': {pattern: /[a-zA-Z0-9]/},
                      'L': {pattern: /[a-z]/},
                    }
                  }
                
                  //$(\"#placa\").mask(\"AAA-0000\", options)
                  //$(\"#codigo\").mask(\"AA.LLL.0000\", options)
                  //$(\"#celular\").mask(\"(00) 0000-00009\")
                
                  $(\"#inputPhone\").blur(function(event){
                    if ($(this).val().length === 15){
                      $(\"#inputPhone\").mask(\"(00) 00000-0009\")
                    }else{
                      $(\"#inputPhone\").mask(\"(00) 0000-00009\")
                    }
                  })
                })
                $(document).ready(function () {
                  $(\"#inputCpf\").blur(function () {
                    var cpf = $(this).val();
                    if (cpf != \"\") validaCpf(this);
                    else cpfError(this);
                  });
                });
                
                function validaCpf(field) {
                  cpf = field.value.substring(0, field.value.length);
                  cpf = cpf.replace(/\D/g, '');
                  if (cpf != \"\" &&
                    cpf.length == 11 &&
                    trollCheck(cpf) != true) {
                    chk1 = cpf.substring(0, 9);
                    chk2 = cpf.substring(0, 10);
                    sum1 = 0;
                    sum2 = 0;
                    while (i < 9) {
                      sum1 = sum1 + (chk1[i] * ((chk1.length + 1) - i));
                      i++;
                    }
                    i = 0;
                    while (i < 10) {
                      sum2 = sum2 + (chk2[i] * ((chk2.length + 1) - i));
                      i++;
                    }
                    i = 0;
                    chk1 = (sum1 * 10) % 11;
                    chk2 = (sum2 * 10) % 11;
                    if (chk1 != cpf[9] || chk2 != cpf[10]) cpfError(this);
                  }
                  else cpfError(this);
                }
                
                function cpfError(field) {
                  document.getElementById(\"inputCpf\").innerHTML = \"<font color='red'>CPF inválido </font>\";
                  $(\"#inputCpf\").val(\"\");
                  alert(\"CPF invalido\");
                  $(document).ready(function () {
                    $(\"#inputCpf\").focus();
                  })
                }
                
                function trollCheck() {
                  troll = true;
                  i = 0;
                  while (i < 11) {
                    if (cpf[0] == cpf[i]) {
                      troll = true;
                    }
                    else {
                      troll = false;
                      break;
                    }
                    i++;
                  }
                  i = 0;
                  return troll;
                }

            </script>
            <body class='fundo'>
            <div class='container'>
                <div class='row'>
                    <div class='col-sm-auto col-md-auto col-lg-auto mx-auto'>
                        <div class='fundoLogado card card-signin my-5'>
                            <div class='card-body' id='card_body'>";
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
                                <h5 class='card-title text-center'>Editando:  $dados[cli_nome] </h5>
                                <form class='form-signin' action='" . DIRPAGE . 'cadastro_cliente/editar' . "' method='POST'>
                                    <input name='cliente_id' type='hidden' value='$dados[cliente_id]' id='inputID'>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <input name='cli_nome' type='text' class='form-control' id='inputNome' value='$dados[cli_nome]' placeholder='Nome do Cliente' autocomplete='off'>
                                            <label for='inputNome'>Nome do Cliente</label>
                                        </div>
                                    </div>
                                    <div class='form-row'>
                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group'>
                                                <input name='cli_cpf' type='text' class='form-control' id='inputCpf' value='$dados[cli_cpf]' placeholder='CPF' autocomplete='off'>
                                                <label for='inputCpf'>CPF</label>
                                            </div>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group '>
                                                <input name='cli_rg' type='text' class='form-control' id='inputRg' value='$dados[cli_rg]' placeholder='RG' autocomplete='off'>
                                                <label for='inputRg'>RG</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class='form-row'>
                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group '>
                                                <input name='cli_cep' type='text' class='form-control' id='inputCEP' value='$dados[cli_cep]' placeholder='RG' autocomplete='off'>
                                                <label for='inputCEP'>CEP</label>
                                            </div>
                                        </div>
                                        <div class='form-group col-md-6'>
                                            <div class='form-label-group '>
                                                <input name='celular' type='text' class='form-control' id='inputPhone' value='$dados[celular]' placeholder='RG' autocomplete='off'>
                                                <label for='inputPhone'>Celular</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <input name='cli_email' type='email' class='form-control' id='inputEmail' value='$dados[cli_email]' placeholder='E-mail' autocomplete='off'>
                                            <label for='inputEmail'>E-mail</label>
                                        </div>
                                    </div>
                                    <div class='form-group'>
                                        <div class='form-label-group'>
                                            <input name='endereco' type='text' class='form-control' id='inputAddress' value='$dados[endereco]' placeholder='Endereço' autocomplete='off'>
                                            <label for='inputAddress'>Endereço</label>
                                        </div>
                                    </div>
                                    
                                    <div class='col text-center'>
                                        <a href='" . DIRPAGE . 'cadastro_cliente/listar' . "'><button type='button' class='btn btn-lg text-uppercase btn-warning'>Voltar</button></a>
                                        <button name='btn-editar' type='submit' class='btn btn-lg text-uppercase btn-danger'>Atualizar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </body>
            ";
        }
    }
    public function editar(){
        $this->recebeVariaveis();
        $validar = $this->verificarCadastro($this->cli_cpf, $this->cli_rg, $this->cli_email, $this->cliente_id);
        if ($validar == true): # Quer dizer que o cadastro já existe
            $_SESSION['cliente_existe'] = true;
            $_SESSION['msg_erro'] = "Algum dos dados digitados já existe na base de dados :(<br>Por favor, insira outro! =)";
        else:
            $C = $this->editarCliente($this->cliente_id,$this->cli_nome,$this->cli_cpf,$this->cli_rg,$this->cli_cep,$this->celular, $this->cli_email,$this->endereco);
            if ($C): # Verificando se o update da tabela funcionarios deu certo
                $_SESSION['sucesso'] = true;
                $_SESSION['msg'] = "Atualizado com sucesso!";
            else:
                $_SESSION['erro'] = true;
                $_SESSION['msg'] = "Sinto muito, <br>ocorreu um erro ao tentar atualizar o cliente :(";
            endif;
        endif;
        header('Location: ' . DIRPAGE . 'cadastro_cliente/editando/' . $this->cliente_id);
        exit();
    }
    public function confirmar_exclusao($cliente_id){
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
                        <a href='" . DIRPAGE . 'cadastro_cliente/listar' . "'> <button style='outline: none' type='button' class='close' data-dismiss='modal' aria-label='Fechar'>
                            <span aria-hidden='true'>&times;</span>
                        </button></a>
                    </div>
                    <div style='color: darkred;outline: none' class='modal-body'>
                        <strong>O cliente selecionado será excluído permanentemente!<br>(muito tempo!)</strong>
                    </div>
                    <div class='modal-footer'>
                        <a href='" . DIRPAGE . 'cadastro_cliente/listar/' . "'><button type='button' class='btn btn-primary' data-dismiss='modal'>Voltar</button></a>
                        <a href='" . DIRPAGE . 'cadastro_cliente/excluir/' . "{$cliente_id}'><button type='button' class='btn btn-danger'>Excluir</button></a>
                    </div>
                </div>
            </div>
        </div>
        <script src='" . DIRJS . 'jquery.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.min.js' . "'></script>
        <script src='" . DIRJS . 'bootstrap.bundle.min.js' . "'></script>
        </body>";
    }
    public function excluir($cliente_id){
        $this->recebeVariaveis();
        $F = $this->excluirCliente($cliente_id);
        if($F):
            $_SESSION['sucesso'] = true;
            $_SESSION['msg'] = "Cliente excluído com sucesso!";
        else:
            $_SESSION['erro'] = true;
            $_SESSION['msg'] = "Sinto muito, ocorreu um erro ao tentar atualizar o funcionário :(";
        endif;
        header('Location: ' . DIRPAGE . 'cadastro_cliente/listar');
        exit();
    }
}