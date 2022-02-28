<?php

// Clientes, debe coincidir con el nombre de la carpeta
namespace Controllers\Clientes;

use Controllers\PublicController;
use Views\Renderer;

// este debe ser igual al nombre del archivo Clientes
class Clientes extends PublicController{

    // pide al extender PubliController
    public function run(): void{

        $viewData = array();
        $viewData["titulo"] = "Manejo de Clientes";
        $viewData["clientes"] = array(
            "Luis",
            "Josué",
            "Diana",
            "Adrian", 
            "Carlos"
        );


        // así se renderiza la vista clientes
        Renderer::render('Clientes/clientes', $viewData);
    }
    
}

?>