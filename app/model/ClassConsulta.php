<?php
use App\Model\ClassFuncionario;
use App\Model\ClassCliente;
class Consultas{

    # Atributos
    private $consulta_id;
    private $dtConsulta;
    private $hrConsulta;
    private $custo;
    private $desconto;
    private $dtAbertura;
    private $dtEncerr;
    private $solucao;
    private $situacao;
    private $cliente_id;
    private $funcionario_id;
    private $funcao_id;
    # $this->funcionario_id=$this->getFuncionarioId();
    # Métodos getters e setters
    public function setDtConsulta($dtConsulta){
        $this->dtConsulta = $dtConsulta;

    }
    public function getDtConsulta(){
        return $this->dtConsulta;
    }
    public function setHrConsulta($hrConsulta){
        $this->hrConsulta = $hrConsulta;
    }
    public function getHrConsulta(){
        return $this->hrConsulta;
    }
    public function setCusto($custo){
        $this->custo = $custo;
    }
    public function getCusto(){
        return $this->custo;
    }
    public function setDesconto($desconto){
        $this->desconto = $desconto;
    }
    public function getDesconto(){
        return $this->desconto;
    }
    public function setDtAbertura($dtAbertura){
        $this->dtAbertura = $dtAbertura;
    }
    public function getDtAbertura(){
        return $this->dtAbertura;
    }
    public function setDtEncerr($dtEncerr){
        $this->dtEncerr = $dtEncerr;
    }
    public function getDtEncerr(){
        return $this->dtEncerr;
    }
    public function setSolucao($solucao){
        $this->solucao = $solucao;
    }
    public function getSolucao(){
        return $this->solucao;
    }
    public function setSituacao($situacao){
        $this->situacao = $situacao;
    }
    public function getSituacao(){
        return $this->situacao;
    }
    public function setClienteId(ClassCliente $cliente_id){
        $this->cliente_id = $cliente_id->getClienteId();
    }
    public function getClienteId(){
        return $this->cliente_id;
    }
    public function setFuncionarioId(ClassFuncionario $funcionario_id){
        $this->funcionario_id = $funcionario_id->getFuncionarioId();
    }
    public function getFuncionarioId(){
        $this->funcionario_id;
    }

    # Métodos para abrir, cancelar, visualizar, editar e encerrar consultas
    public function abrirConsultas($dtConsulta, $hrConsulta, $custo, $desconto, $dtAbertura, $dtEncerr, $solucao, $situacao, ClassCliente $cliente_id, ClassFuncionario $funcionario_id, $funcao_id){
        $this->dtConsulta = $dtConsulta;
        $this->hrConsulta = $hrConsulta;
        $this->custo = $custo;
        $this->desconto = $desconto;
        $this->dtAbertura = $dtAbertura;
        $this->dtEncerr = $dtEncerr;
        $this->solucao = $solucao;
        $this->situacao = $situacao;
        $this->cliente_id = $cliente_id->getClienteId();
        $this->funcionario_id = $funcionario_id->getFuncionarioId();
        $this->funcao_id = $funcao_id;
    }
    public function cancelarConsulta($consulta_id){

    }
    public function verConsultas($consulta_id){

    }
    public function editarConsulta($consulta_id){

    }
    public function encerrarConsulta($consulta_id){

    }
}

?>