<?php
namespace App;
use Src\Classes\ClassRoutes;

# Dispatch vai servir para cuidar do tratamento da url

class Dispatch extends ClassRoutes{
    # Atributos
    private $method;
    private $param=[];
    private $obj;

    protected function getMethod(){ return $this->method;}
    public function setMethod($method){ $this->method = $method;}
    public function getParam(){ return $this->param;}
    public function setParam($param){ $this->param = $param;}

    # Método Construtor
    public function __construct(){
        self::addController();
    }
    # Método de adiçao de controller
    private function addController(){
        $rotaController=$this->getRota(); # retornaria, por exemplo: "ControllerLogin"
        $nameSpace="App\\Controller\\{$rotaController}";
        $this->obj=new $nameSpace;
        # obj=new App\Controller\ControllerCadastrarCliente
        if(isset($this->parseUrl()[1])){
            self::addMethod();
        }
    }
    # Método de adiçao de método do controller
    private function addMethod(){
        # method_exists(objeto, nome_metodo) verifica se algum metodo existe dentro da classe do objeto
        if(method_exists($this->obj, $this->parseUrl()[1])){

            $this->setMethod("{$this->parseUrl()[1]}");
            self::addParam();
            call_user_func_array([$this->obj, $this->getMethod()], $this->getParam()); //chamar um array de parametrosl
        }
    }
    # Método de adiçao de parametros do controller
    private function addParam(){
        $contArray=count($this->parseUrl()); # conta quantos elementos tem no array da url
        if($contArray > 2){
            foreach ($this->parseUrl() as $key => $value){ #percorre os elementos do array
                if($key>1){
                    $this->setParam($this->param += [$key => $value]);
                }
            }
        }

    }
}
