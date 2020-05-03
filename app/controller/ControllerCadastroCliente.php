<?php
namespace App\Controller;

use Src\Classes\ClassRender;
use App\Model\ClassCadastro;

class ControllerCadastroCliente extends ClassCadastro {
    protected $usuario_id;
    protected $usuario;
    protected $senha;

    use \Src\Traits\TraitUrlParser;

    public function __construct(){

        if(count($this->parseUrl())==1){
            $render = new ClassRender();
            if(isset($_SESSION['logado'])){
                $render->setTitle("Cadastro de Clientes");
                $render->setDir("cadastro");
                $render->renderLayout();
            }elseif(isset($_SESSION['nao_logado'])){
                header('Location: ' . DIRPAGE . 'login');
                exit();
            }
        }

    }
    # Vai receber as variaveis
    public function recebeVariaveis(){
        if(isset($_POST['usuario_id'])){$this->usuario_id=$_POST['usuario_id'];}
        if(isset($_POST['usuario'])){$this->usuario=filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_SPECIAL_CHARS);}
        if(isset($_POST['senha'])){$this->senha=filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_SPECIAL_CHARS);}
    }
    # Chamar método de cadastro da ClassCadastro
    public function cadastrar(){
        $this->recebeVariaveis();
        $this->cadastroUsuarios($this->usuario, $this->senha);
    }
    # Método responsável por selecionar e exibir os dados do banco;
    public function visualizar(){
        $this->recebeVariaveis();
        #print("<pre>".print_r(parent::listarDados($this->usuario),true)."</pre>");
        $B=$this->listarDados($this->usuario);
        echo "
            <form name='formDeletar' id='formDeletar' action='".DIRPAGE."cadastrar_cliente/deletar' method='post'>
                <table border='1'>
                    <tr>
                        <td>ClassUsuario</td>
                        <td>Açoes</td>
                    </tr>
        ";
        foreach ($B as $C){
            echo "
                    <tr>
                        <td>$C[usuario]</td>
                        <td><input type='checkbox' id='usuario_id' name='usuario_id[]' value='$C[usuario_id]'>
                        <img rel='$C[usuario_id]' class='ImageEdit' src='".DIRIMG."btn_editar.png' alt='Editar'>
                        </td>                                               
                    </tr>
            ";
        }
        echo "    </table>
                <input type='submit' id='deletar' value='Deletar'>
              </form>";
    }
    # Método reponsável por deletar
    public function deletar(){
        $this->recebeVariaveis();
        foreach ($this->usuario_id as $usuario_idDeletar){
            $this->deletarClientes($usuario_idDeletar);
        }
    }

    #Puxando dados do DB
    public function puxaDB($usuario_id){
        $this->recebeVariaveis();
        $B=$this->listarDados($this->usuario);
        foreach ($B as $C){
            if($C['usuario_id'] == $usuario_id){
                $Usuario= $C['usuario'];
            }
        }
        echo "
            <form name='FormEditar' id='FormEditar' action='". DIRPAGE."cadastrar_cliente/editar' method='post'>
                <input type='hidden' name='usuario_id' id='usuario_id' value='$usuario_id'><br>
                ClassUsuario: <input type='text' name='usuario' id='usuario' value='$Usuario'><br>
                Senha: <input type='password' name='senha' id='senha'><br>
                <input type='submit' value='EDITAR'>
            </form>
        ";

    }
    #Atualizar dados dos clientes
    public function editar(){
        $this->recebeVariaveis();
        $this->editarClientes($this->usuario_id, $this->usuario,$this->senha);
        echo "Usuário Atualizado com Sucesso!";
    }
}
