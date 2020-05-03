<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php echo $this->addHead(); ?>
</head>
<body class="fundo">
    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                <div class="card card-signin my-5">
                    <div class="card-body">
                        <?php
                        if(isset($_SESSION['nao_autenticado'])){
                            echo "<div class='alert alert-danger'><p>ERRO: Usuário e/ou Senha incorretos</p></div>";
                        }
                        unset($_SESSION['nao_autenticado']);
                        ?>
                        <h5 class="card-title text-center">Login</h5>
                        <form class="form-signin" action="<?php echo DIRPAGE .'login/autenticar';?>" method="POST">
                            <div class="form-label-group">
                                <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Login" autocomplete="off" required autofocus>
                                <label for="inputLogin">Usuário</label>
                            </div>

                            <div class="form-label-group">
                                <input name="senha" type="password" id="inputPassword" class="form-control" placeholder="Senha" autocomplete="off" required>
                                <label for="inputPassword">Senha</label>
                            </div>
                            <button class="my-btn btn btn-lg btn-primary btn-block text-uppercase" type="submit">Autenticar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>