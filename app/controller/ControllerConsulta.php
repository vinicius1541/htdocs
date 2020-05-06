<?php

namespace App\Controller;

use DateTimeZone;
use Src\Classes\ClassRender;
use Src\Interfaces\InterfaceView;



setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');


class ControllerConsulta extends ClassRender implements InterfaceView
{
    public function __construct()
    {
        if (isset($_SESSION['logado'])) {
            $this->setTitle("Consultório OdontoMonicao");
            $this->setDir("consulta");
            $this->renderConsulta();
        } else {
            header('Location: ' . DIRPAGE . 'login');
            exit();

        }
    }

    public function monthPT_BR()
    {
        return strtoupper(strftime('%B / %Y', strtotime('today')));
    }

    #implementar busca de consultas no mês para exibir no calendário
    /*public function buscaConsulta($mes)
    {
        $mes->monthPT_BR();
        return $mes;
    }

    public function buscaFirstDay(){
        $today= getdate();
        $lastDay = strftime('%d',mktime(0,0,0,$today['mon'],1,$today['year']));
        return $lastDay;
    }
    public function buscaLastDay(){
        $today= getdate();
        $lastDay = strftime('%d',mktime(0,0,0,$today['mon']+1,0,$today['year']));
        return $lastDay;
    }

    public function prev(){
        return strtoupper(strftime('%B / %Y', strtotime('-1 month')));
    }

    public function next(){
        return strtoupper(strftime('%B / %Y', strtotime('+1 month')));
    }

    public function nofDay(){
        return strtoupper(strftime('%B / %Y', strtotime('-1 month')));
    }*/
}
