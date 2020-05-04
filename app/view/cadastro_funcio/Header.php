<?php
ob_start();
#$paginaLink = $_SERVER['SCRIPT_NAME'];
//print_r($_SESSION['nivelacesso']);
#echo DIRPAGE;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php echo $this->addHead(); ?>
</head>

<body class="fundoLogado">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo DIRPAGE . 'home';?>">Odonto Monicao</a>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?php echo DIRPAGE . 'home';?>">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php if ($_SESSION['nivelacesso'] == 1) : ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Cadastrar
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="<?php echo DIRPAGE . 'cadastro_funcio';?>">Funcionário(usuário)</a>
                        <a class="dropdown-item" href="#<?php #echo DIRPAGE . 'listar_funcio';?>">Listar Funcionários</a>
                    </div>
                </li>

            <?php endif; ?>

            <li class="nav-item">
                <a class="nav-link" href="<?php echo DIRPAGE . 'consulta';?>">Consultas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Estoque</a>
            </li>
            <!--<li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ComboBoxAqui
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="#">Opçao 1</a>
                    <a class="dropdown-item" href="#">Opçao 2</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Opcao 3 separado</a>
                </div>
            </li>-->


        </ul>
        <!--<form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>-->
    </div>
    <div class="d-flex flex-row-reverse bd-highlight">
        <!--essa linha coloca alinha os itens abaixo para a direita-->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown active">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION['login']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item disabled" href="#">Nível de Acesso:
                            <?php
                            if ($_SESSION['nivelacesso'] == 1) {
                                echo "Admin";
                            } else if ($_SESSION['nivelacesso'] == 2) {
                                echo "Funcionário";
                            }
                            ?></a>
                        <a class="dropdown-item" href="#">Editar perfil</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo DIRPAGE . 'login/logout';?>">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<!--<div class="d-flex flex-row-reverse bd-highlight">
        <div class="btn-group dropleft" role="group">
            <button type="button" class="btn btn-outline-secondary  btn-sm">
                <h5 class="usuario"> //echo $_SESSION['usuario'];
                                    </h5>
            </button>
            <button type="button" class="btn btn-outline-secondary  btn-sm dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" disabled>Nível de Acesso: </?= "Admin" ?></a>
                <a class="dropdown-item" href="#" disabled>Editar perfil</a>
                <div class="dropdown-divider"></div>
                <a class=" dropdown-item" href="logado/logout.php">Logout</a>
                <a class="dropdown-item" href="#">Link separado</a>
            </div>
        </div>
    </div>

</body>
</html>-->