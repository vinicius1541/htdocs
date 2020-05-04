<?php
namespace Src\Classes;

use Src\Traits\TraitUrlParser;

class ClassRoutes{
    use TraitUrlParser;
    private $rota;

    # Método de retorno da rota
    public function getRota(){
        $url=$this->parseUrl();
        $indice = $url[0];
        if(isset($_SESSION['logado'])){
            $rotaLogado= "ControllerHome";
        }else{
            $rotaLogado= "ControllerLogin";
        }
        $this->rota=array(
            ""=>$rotaLogado,
            "home"=>"ControllerHome",
            "cadastrar_cliente"=>"ControllerCadastroCliente",
            "cadastro_funcio"=>"ControllerCadastroFuncio",
            "login"=>"ControllerLogin",
            "consulta"=>"ControllerConsulta",
            "listar_funcio"=>"ControllerListarFuncio",
            "editar_funcio"=>"ControllerEditarFuncio"
        );
        if(array_key_exists($indice, $this->rota)) {#se existir o caminho digitado dentro das rotas colocadas no array
            if (file_exists(DIRREQ . "app/controller/{$this->rota[$indice]}.php")){ #se o arquivo do caminho digitado estiver lá
                return $this->rota[$indice]; #retorna o controller da url digitado
            }else{ #se o arquivo nao existir, irá retornar para a controller 'home'
                return "ControllerHome";
            }
        }else{
            return "Controller404";
        }
    }
}