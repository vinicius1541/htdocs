<?php
namespace Src\Classes;
# BreadCrumbs sao o caminho em que o usuário percorreu no site, exemplo: homepage > about > contact
class ClassBreadcrumbs{

    use \Src\Traits\TraitUrlParser;

    # Cria os breadcrumbs do site
    public function addBreadcrumb(){
        $contador=count($this->parseUrl());
        $arrayLink[0]='';
        echo "<a href=" . DIRPAGE . 'home' .">Home</a> >";
        for($i=0;$i < $contador; $i++){
            $arrayLink[0].=$this->parseUrl()[$i] . '/'; #vai receber o link da url do array retornado de parseUrl()
            echo "<a href=" . DIRPAGE . $arrayLink[0] . ">" . $this->parseUrl()[$i] . "</a>"; #criado um link para cada um
            if($i<$contador-1){ # Se nao for o ultimo link, acrescenta '>'
                echo " > ";
            }
        }
    }
}