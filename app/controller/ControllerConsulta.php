<?php
namespace App\Controller;

use DateTimeZone;
use Src\Classes\ClassRender;
use Src\Interfaces\InterfaceView;
class ControllerConsulta extends ClassRender implements InterfaceView{
    public function __construct(){
        if(isset($_SESSION['logado'])){
            $this->setTitle("Consultório OdontoMonicao");
            $this->setDir("consulta");
            $this->renderConsulta();
        }else{
            header('Location: ' . DIRPAGE . 'login');
            exit();
        }
    }

    public function monthPT_BR(){
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');
        echo strtoupper(strftime('%B', strtotime('today')));
    }

    #implementar busca de consultas no mês para exibir no calendário
    public function buscaConsulta($mes){
        $mes -> monthPT_BR();


    }
}
