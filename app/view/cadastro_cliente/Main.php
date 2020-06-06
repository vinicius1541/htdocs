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
                    unset($_SESSION['status_cadastro']); ?>
                    <?php
                    if (isset($_SESSION['cliente_existe']) || isset($_SESSION['erro'])) :
                        ?>
                        <div class='alert alert-danger'>
                            <p><?php echo $_SESSION['msg_erro'];?></p>
                        </div>
                    <?php endif;
                    unset($_SESSION['cliente_existe']);
                    unset($_SESSION['msg_erro']);
                    unset($_SESSION['erro'])?>
                    <h5 class="card-title text-center">Cadastrar Cliente</h5>
                    <form class="form-signin" action="<?php echo DIRPAGE.'cadastro_cliente/cadastrar'?>" method="POST">
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="cli_nome" type="text" class="form-control" id="inputNome" placeholder="Nome do cliente" autocomplete="off" required autofocus>
                                <label for="inputNome">Nome do cliente</label>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="cli_cpf" type="number" class="form-control" id="inputCpf" placeholder="CPF" autocomplete="off" required>
                                    <label for="inputCpf">CPF</label>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="cli_rg" type="number" class="form-control" id="inputRg" placeholder="RG" autocomplete="off" required>
                                    <label for="inputRg">RG</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="cli_cep" type="number" class="form-control" id="inputCEP" placeholder="CEP" autocomplete="off" required>
                                    <label for="inputCEP">CEP</label>
                                    <!--<script> document.getElementById("inputCEP").innerHTML = cepLogradouro(); </script>-->
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <div class="form-label-group">
                                    <input name="celular" type="number" class="form-control" id="inputPhone" placeholder="Celular" autocomplete="off" required>
                                    <label for="inputPhone">Celular</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="cli_email" type="email" class="form-control" id="inputEmail" placeholder="E-mail do cliente" autocomplete="off" required>
                                <label for="inputEmail">E-mail</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <input name="endereco" type="text" class="form-control" id="inputAddress" placeholder="Endereço do cliente" autocomplete="off" required>
                                <label for="inputAddress">Endereço</label>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <a href="<?php echo DIRPAGE . 'cadastro_cliente/listar'; ?>"><button id="listarCliente" type="button" class="my-btn btn btn-warning btn-lg text-uppercase">Listar Clientes</button></a>
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