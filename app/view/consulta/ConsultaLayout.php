<!doctype html>
<html lang="pt-br">
<head>
    <?php echo $this->addHead(); ?>
</head>
<body class="fundo">
<!--<a href="<?php echo DIRPAGE.'cadastrar_cliente';?>">Cadastrar Clientes</a>-->


<div class="header">
    <?php echo $this->addHeader();
    #$breadcrumb = new Src\Classes\ClassBreadcrumbs();
    #$breadcrumb->addBreadcrumb();
    ?>

</div>
<div class="main">
    <?php echo $this->addMain(); ?>
</div>
<div class="footer">
    <?php echo $this->addFooter(); ?>
</div>


</body>
</html>
