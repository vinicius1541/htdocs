<?php
#if ($_SESSION['nivelacesso'] != 2) {
    #header('Location: logged.php');
    #exit;
#}
?>

<div class="container">
    <div class="row">
        <div class="col-sm-auto col-md-auto col-lg-auto mx-auto">
            <div class="card card-signin my-5">
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['status_cadastro'])) :
                        ?>
                        <div class='alert alert-success'>
                            <p>Cadastro concluido com sucesso!</p>
                        </div>
                    <?php endif;
                    unset($_SESSION['status_cadastro']); ?>
                    <?php
                    if (isset($_SESSION['usuario_existe'])) :
                        ?>
                        <div class='alert alert-danger'>
                            <p>Usuario escolhido já existe. Informe outro e tente novamente.</p>
                        </div>
                    <?php endif;
                    unset($_SESSION['usuario_existe']); ?>
                    <h5 class="card-title text-center">Cadastrar usuário</h5>
                    <form class="form-signin" action="<?php echo DIRPAGE.'cadastro_funcio/addFuncionario'?>" method="POST">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="nome" type="text" class="form-control" id="inputNome" placeholder="Email" autocomplete="off" required autofocus>
                                <label for="inputNome">nome</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="login" type="text" class="form-control" id="inputLogin" placeholder="Usuário" autocomplete="off" required>
                                    <label for="inputLogin">Usuário</label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-label-group ">
                                    <input name="senha" type="password" class="form-control" id="inputPassword" placeholder="Password" autocomplete="off" required>
                                    <label for="inputPassword">Senha</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email" autocomplete="off" required>
                                <label for="inputEmail">E-mail</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="endereco" type="text" class="form-control" id="inputAddress" placeholder="Endereço" autocomplete="off" required>
                                <label for="inputAddress">Endereço</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="celular" type="number" class="form-control" id="inputPhone" placeholder="Celular" autocomplete="off" required>
                                <label for="inputPhone">Celular</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="cpf" type="number" class="form-control" id="inputCpf" placeholder="CPF" autocomplete="off" required>
                                    <label for="inputCpf">CPF</label>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="rg" type="number" class="form-control" id="inputRg" placeholder="RG" autocomplete="off" required>
                                    <label for="inputRg">RG</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="form-label-group">
                                <select name="nivelacesso_id" id="inputNvlAcesso" class="form-control">
                                    <option value="3" selected>Acesso NEGADO</option>
                                    <option value="1">Funcionario</option>
                                    <option value="2">Dentista/Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="form-label-group">
                                <select name="funcao_id" id="inputFuncao" class="form-control">
                                    <option value="1">Funcionario</option>
                                    <option value="2">Dentista/Admin</option>
                                </select>
                            </div>
                        </div><!--
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="gridCheck">
                            <label class="form-check-label" for="gridCheck">
                                Check me out
                            </label>
                        </div>
                    </div>-->
                        <button type="submit" class="btn btn-primary btn-block">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>