<div class="container">
    <div class="row">
        <div class="col-sm-auto col-md-auto col-lg-auto mx-auto">
            <div class="fundoLogado card card-signin my-5">
                <div class="card-body">
                    <?php
                    if (isset($_SESSION['status_cadastro'])) :
                        ?>
                        <div class='alert alert-success'>
                            <p>Cadastro concluido com sucesso!</p>
                        </div>
                    <?php endif;
                    if (isset($_SESSION['usuario_existe'])) :
                        ?>
                        <div class='alert alert-danger'>
                            <p>Usuario escolhido já existe. Informe outro e tente novamente.</p>
                        </div>
                    <?php endif;
                    unset($_SESSION['usuario_existe']);
                    unset($_SESSION['status_cadastro']);
                    unset($_SESSION['erro']);
                    unset($_SESSION['msg']);
                    ?>
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
                                <input name="celular" type="text" class="form-control" id="inputPhone" placeholder="Celular" autocomplete="off" required>
                                <label for="inputPhone">Celular</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="cpf" type="text" class="form-control" id="inputCpf" placeholder="CPF" autocomplete="off" required>
                                    <label for="inputCpf">CPF</label>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="rg" type="text" class="form-control" id="inputRg" placeholder="RG" autocomplete="off" required>
                                    <label for="inputRg">RG</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="form-label-group">
                                <select name="nivelacesso_id" id="inputNvlAcesso" class="form-control">
                                    <option value="3" selected>Acesso NEGADO</option>
                                    <option value="2">Funcionario</option>
                                    <option value="1">Dentista/Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="form-label-group">
                                <select name="funcao_id" id="inputFuncao" class="form-control">
                                    <option value="1">Funcionario</option>
                                    <option value="2">Dentista</option>
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

                        <div class="text-center">
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <a href="<?php echo DIRPAGE . 'cadastro_funcio/listar'; ?>"><button id="listarFuncio" type="button" class="my-btn btn btn-warning btn-lg text-uppercase">Listar Funcionários</button></a>
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