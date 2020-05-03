<?php 
class ClassEstoque{
    // Atributos
    private $produto_id;
    private $prod_nome;
    private $qtd;
    private $produto_valor;
    private $descricao;
    // Métodos getters e setters
    public function setProdNome($prod_nome){
        $this->prod_nome = $prod_nome;
    }
    public function getProdNome(){
        return $this->prod_nome;
    }
    public function setQtd($qtd){
        $this->qtd = $qtd;
    }
    public function getQtd(){
        return $this->qtd;
    }
    public function setProdutoValor($produto_valor){
        $this->produto_valor = $produto_valor;
    }
    public function getProdutoValor(){
        return $this->produto_valor;
    }
    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }
    public function getDescricao(){
        return $this->descricao;
    }
    //Métodos para add, excluir e editar
    public function addEstoque($prod_nome, $qtd, $produto_valor, $descricao){
        $this->prod_nome = $prod_nome;
        $this->qtd = $qtd;
        $this->produto_valor = $produto_valor;
        $this->descricao = $descricao;
    }
    public function verEstoque($produto_id){

    }
    public function editarEstoque($produto_id){

    }
    public function excluirItem($produto_id){

    }
}

?>