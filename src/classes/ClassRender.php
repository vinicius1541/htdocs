<?php
namespace Src\Classes;

class ClassRender{
    # Propriedades
    private $dir;
    private $title;
    private $keywords;

    public function getDir(){ return $this->dir; }
    public function setDir($dir){ $this->dir = $dir; }
    public function getTitle(){return $this->title; }
    public function setTitle($title){ $this->title = $title; }
    public function getKeywords(){ return $this->keywords; }
    public function setKeywords($keywords){ $this->keywords = $keywords; }


    # Método responsável por renderizar todos os layouts
    public function renderLayout(){
        include_once(DIRREQ . "app/view/Layout.php");
    }
    public function renderLoginPage(){
        include_once (DIRREQ . "app/view/login/login.php");
    }
    # Método que vai adicionar características específicas no head
    public function addHead(){
        if(file_exists(DIRREQ."app/view/{$this->getDir()}/Head.php")){
            include(DIRREQ."app/view/{$this->getDir()}/Head.php");
        }
    }
    # Método que vai adicionar características específicas no header
    public function addHeader(){
        if(file_exists(DIRREQ."app/view/{$this->getDir()}/Header.php")){
            include(DIRREQ."app/view/{$this->getDir()}/Header.php");
        }
    }
    # Método que vai adicionar características específicas no main
    public function addMain(){
        if(file_exists(DIRREQ."app/view/{$this->getDir()}/Main.php")){
            include(DIRREQ."app/view/{$this->getDir()}/Main.php");
        }
    }
    # Método que vai adicionar características específicas no footer
    public function addFooter(){
        if(file_exists(DIRREQ."app/view/{$this->getDir()}/Footer.php")){
            include(DIRREQ."app/view/{$this->getDir()}/Footer.php");
        }
    }
}
