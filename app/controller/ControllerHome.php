<?php
namespace App\Controller;
use Src\Classes\ClassRender;
use Src\Interfaces\InterfaceView;
class ControllerHome extends ClassRender implements InterfaceView{
    public function __construct(){
        if(isset($_SESSION['logado']) && $_SESSION['nivelacesso'] != 3){
            $this->setTitle("Consultório OdontoMonicao");
            $this->setDir("home");
            $this->renderLayout();
        }else{
            header('Location: ' . DIRPAGE . 'login');
            exit();
        }
    }

}
