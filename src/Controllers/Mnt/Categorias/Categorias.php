<?php

namespace Controllers\Mnt\Categorias;

use Controllers\PublicController;
use Views\Renderer;

class Categorias extends PublicController{

    public function run(): void
    {
        $viewData = array();

        // aquí obtenemos los valores desde la consulta 
        $viewData["categorias"] = \Dao\Mnt\Categorias::obtenerTodos();

        Renderer::render('mnt/categorias', $viewData);
    }
}

?>