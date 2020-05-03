<?php
namespace Src\Traits;

trait TraitUrlParser{ # Rotas

    # Divide a url em um array
    public function parseUrl(){
        # explode() transforma em array
        # rtrim() retira os espaços vazios
        # a 'url' é a mesma delimitada no .htaccess

        return explode("/", rtrim($_GET['url']), FILTER_SANITIZE_URL);
    }
}
