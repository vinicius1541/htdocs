<!-- # JS-->
<script src="<?php echo DIRJS . 'main.js' ?>"></script>
<script src="<?php echo DIRJS . 'jquery.min.js' ?>"></script>
<script src="<?php echo DIRJS . 'bootstrap.min.js' ?>"></script>
<script src="<?php echo DIRJS . 'bootstrap.bundle.min.js'?>"></script>

<?php

$paginaLink = DIRPAGE . $_GET['url'];
#&& $paginaLink != DIRREQ.'app/controller/listarCadastros.php'
if ($paginaLink != DIRPAGE.'cadastro_funcio' && $paginaLink != DIRPAGE.'cadastro_cliente') {?>
        <footer id='sticky-footer' class='py-4 bg-dark text-white-50'>
            <div class='container text-center'>
                <small>Copyright &copy; 2020</small>
            </div>
        </footer>
    </body>
</html>
<?php
}
