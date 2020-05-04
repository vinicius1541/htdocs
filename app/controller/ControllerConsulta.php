<?php
namespace App\Controller;
use App\Model\ClassConsulta;
use Src\Classes\ClassRender;
class ControllerConsulta extends ClassConsulta {
    public function __construct(){
        if(count($this->parseUrl())==1){
            $render = new ClassRender();
            if(isset($_SESSION['logado'])){
                $render->setTitle("Cadastro de Consulta");
                $render->setDir("consulta");
                $render->renderLayout();
            }elseif(isset($_SESSION['nao_logado'])){
                header('Location: ' . DIRPAGE . 'login');
                exit();
            }
        }
    }

}
