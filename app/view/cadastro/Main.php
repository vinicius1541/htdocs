<form name="FormCadastroCliente" id="FormCliente" action="<?php echo DIRPAGE.'cadastrar_cliente/cadastrar'?>" method="post">
    Usuario: <input type="text" name="usuario" id="usuario"><br>
    Senha: <input type="password" name="senha" id="senha"><br>
    <input type="submit" value="CADASTRAR" name="cadastrarbtn" id="cadastrarbtn">
</form>
<br><br>
<hr>
<br><br>
<h1>LISTAR DADOS</h1>
<form name="FormSelectCliente" id="FormSelectCliente" action="<?php echo DIRPAGE.'cadastrar_cliente/visualizar'?>" method="post">
    Usuario: <input type="text" name="usuario" id="usuario"><br>
    <input type="submit" value="PESQUISAR" name="pesqbtn" id="pesqbtn">
</form>
<!--RECEBERA TABELA DE PESQUISA-->
<div class="resultadoPesquisa" style="width: 100%; height: 300px; background: hotpink;"></div>
<hr>
<br><br>
<h1>Formulário de Atualizações</h1>
<div class="ResultadoFormulario" style="width: 100%; height: 300px; background: green;"></div>

