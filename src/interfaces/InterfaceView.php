<?php
namespace Src\Interfaces;

interface InterfaceView{
    public function setDir($dir);
    public function setTitle($title);
    public function setKeywords($keywords);
    public function renderLayout();

}