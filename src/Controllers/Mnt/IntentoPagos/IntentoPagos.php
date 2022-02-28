<?php 

namespace Controllers\Mnt\IntentoPagos;

use Controllers\PublicController;
use Views\Renderer;

class IntentoPagos extends PublicController{

    public function run(): void
    {
        $viewData = array();
        $viewData["pagos"] = \Dao\IntentoPagos\IntentoPagos::obtenerPagos();

        Renderer::render('mnt/intentoPagos', $viewData);
    }
}

?>