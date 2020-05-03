<?php
namespace App\Model;
use App\Model\ClassConexao;

class ClassCliente extends ClassConexao{
    //Atributos
    private $cliente_id;
    private $cli_nome;
    private $cli_rg;
    private $cli_cpf;
    private $cli_cep;
    private $endereco;
    private $celular;
    private $problema;
    //Métodos setters e getters.
    public function getClienteId(){
        return $this->cliente_id;
    }
    public function setClienteNome($nome_cli){
        $this->cli_nome = $nome_cli;
    }
    public function getClienteNome(){
        return $this->cli_nome;
    }
    public function setRG($rg_cli){
        $this->cli_rg = $rg_cli;
    }
    public function getRG(){
        return $this->cli_rg;
    }
    public function setCPF($cpf){
        $this->cli_cpf = $cpf;
    }
    public function getCPF(){
        return $this->cli_cpf;
    }
    public function setCEP($cep){
        $this->cli_cep = $cep;
    }
    public function getCEP(){
        return $this->cli_cep;
    }
    public function setEndereco($end){
        $this->endereco = $end;
    }
    public function getEndereco(){
        return $this->endereco;
    }
    public function setCelular($cel){
        $this->celular = $cel;
    }
    public function getCelular(){
        return $this->celular;
    }
    public function setProblema($prob){
        $this->problema = $prob;
    }
    public function getProblema(){
        return $this->problema;
    }
    //Métodos para add, excluir e editar
    public function addCliente($cli_nome, $cli_rg, $cli_cpf, $cli_cep, $endereco, $celular, $problema){
        $this->cli_nome = $cli_nome; 
        $this->cli_rg = $cli_rg;
        $this->cli_cpf = $cli_cpf;
        $this->cli_cep = $cli_cep;
        $this->endereco = $endereco;
        $this->celular = $celular;
        $this->problema = $problema;      
    }
    public function excluirCliente($cliente_id){
    }
    public function listarCliente($cliente_id){
    }
    public function editarCliente($cliente_id){
    }
}
?>