<?php
namespace App\Controller;

class Controller404{
    public function __construct(){
        if(isset($_SESSION['logado']) && $_SESSION['nivelacesso'] != 3):
            echo "<h1>Error 404: An error was detected!</h1>";
        else:
            unset($_SESSION['msg']); unset($_SESSION['erro']); unset($_SESSION['sucesso']);
            header('Location: ' . DIRPAGE . 'login');
            exit();
        endif;
    }
}
