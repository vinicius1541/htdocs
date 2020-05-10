<?php
namespace App\Controller;

use App\Model\ClassLogin;
use Src\Classes\ClassRender;

class ControllerLogin extends ClassLogin {
    # Atributos
    protected $login;
    protected $senha;

    use \Src\Traits\TraitUrlParser;

    public function __construct(){
            if(count($this->parseUrl()) == 1){
                $render = new ClassRender();
                $render->setTitle("Login");
                $render->setDir("login");
                $render->renderLoginPage();
            }
    }
    # Vai receber as variaveis
    public function recebeVariaveis(){
        #if(isset($_POST['usuario_id'])){$this->usuario_id=$_POST['usuario_id'];}
        if(isset($_POST['login'])){$this->login=filter_input(INPUT_POST, 'login', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['senha'])){$this->senha=filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);}
    }
    # Método para validar se o login está correto
    public function autenticar(){
        $this->recebeVariaveis();
        $validar = $this->searchLogin($this->login, $this->senha);
        if(empty($_POST['login']) || empty($_POST['senha'])){
            header('Location: ' . DIRPAGE . 'login');
            exit();
        }
        if($validar == true){
            header('Location: ' . DIRPAGE . 'home');
            exit();
        }else{
            header('Location: ' . DIRPAGE . 'login');
            exit();
        }
    }
    public function logout(){
        unset($_SESSION['logado']);
        unset($_SESSION['funcionario_id']);
        unset($_SESSION['login']);
        unset($_SESSION['nao_logado']);
        header('Location: ' . DIRPAGE . 'login');
        exit();
    }

}
