<?php
#Arquivos diretórios raízes
$PastaInterna="";
#caminho absoluto do site, exemplo: http://localhost/OdontoMonicao_POO/
define('DIRPAGE', "http://{$_SERVER['HTTP_HOST']}/{$PastaInterna}");
#caminho absoluto fisico, exemplo: C:/xampp/htdocs/OdontoMonicao_POO/
if(substr($_SERVER['DOCUMENT_ROOT'], -1) == '/'){ //se a última letra do servidor for igual a uma barra "/"
    define('DIRREQ', "{$_SERVER['DOCUMENT_ROOT']}{$PastaInterna}");
}else{
    define('DIRREQ', "{$_SERVER['DOCUMENT_ROOT']}/{$PastaInterna}");
}

#Diretórios Específicos
#IMAGEM
define('DIRIMG',DIRPAGE."public/img/");
#CSS
define('DIRCSS',DIRPAGE."public/css/");
#JS
define('DIRJS',DIRPAGE."public/js/");

#Acesso ao banco de dados
define('HOST', "localhost");
define('DB', "monicao");
define('USER', "root");
define('PASS', "02052000");


