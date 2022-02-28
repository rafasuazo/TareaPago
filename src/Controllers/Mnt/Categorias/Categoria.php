<?php

namespace Controllers\Mnt\Categorias;

use Controllers\PublicController;
use Views\Renderer;

class Categoria extends PublicController{

    private $modeString = array(
        "INS" => "Nueva Categoría",
        "UPD" => "Editar %s (%s)",
        "DSP" => "Detalle de %s (%s)",
        "DEL" => "Eliminando %s (%s)"
    );

    private $catesOptions = array(

        "ACT" => "Activo",
        "INA" => "Inactivo"
    );

    private $viewData = array(

        "mode" => 'INS',
        "catid" => 0,
        "catnom" => "",
        "catest" => "ACT",
        "modeDsc" => "",
        "readonly" => false,
        "isInsert" => false,
        "catestOptions" => [],
        "crsxToken" => ""
    );

    private function init(){
        
        if(isset($_GET["mode"])){
            
            $this -> viewData["mode"] = $_GET["mode"];
        }

        if(isset($_GET["catid"])){

            $this -> viewData["catid"] = $_GET["catid"];
        }

        // en caso que se mande a una acción que no existe
        if(!isset($this -> modeString[$this -> viewData["mode"]])){

            error_log($this -> toString() . "Mode not valid" . $this -> viewData["mode"], 0);

            \Utilities\Site::redirectToWithMsg('index.php?page=mnt.categorias.categorias', 
            'Sucedió un error al procesar la página');
        }

        if($this -> viewData["mode"] !== "INS" && intval($this -> viewData["catid"], 10) !== 0){
            $this -> viewData["mode"] !== "DSP";
        }
    }

    private function handlePost(){

        \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this -> viewData);

        if(!(isset($_SESSION["categoria_crsxtoken"]) && $_SESSION["categoria_crsxtoken"] == $this -> viewData["crsxToken"])){

            unset($_SESSION["categoria_crsxtoken"]);
            \Utilities\Site::redirectToWithMsg(
                'index.php?page=mnt.categorias.categorias',
                'Ocurrio un error, no se puede procesar el formulario.'
            );
        }

        // convirtiendo el valor de catid en int, porque cuando viene en post, viene como String
        $this -> viewData["catid"] = intval($this -> viewData["catid"],10);

        // si no coincide el estado
        if(!\Utilities\Validators::isMatch($this -> viewData["catest"], "/^(ACT)|(INA)$/")){

            $this -> viewData["errors"][] = "Categoría debe ser ACT o INA";
        }

        // si hay errores, vamos a hacer X cosa
        if(isset($this -> viewData["errors"]) && count($this -> viewData["errors"]) > 0){

        }
        else{
            
            unset($_SESSION["categoria_crsxToken"]);

            switch($this -> viewData["mode"]){

                case 'INS':

                    $result = \Dao\Mnt\Categorias::nuevaCategoria(
                        $this -> viewData["catnom"],
                        $this -> viewData["catest"]
                    );

                    if($result){
                        
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt.categorias.categorias",
                            "Categoría guardada exitosamente"
                        );
                    }
                    break;
                
                case 'UPD':

                    $result = \Dao\Mnt\Categorias::actualizarCategoria(
                        $this -> viewData["catnom"],
                        $this -> viewData["catest"],
                        $this -> viewData["catid"]
                    );

                    if($result){
                        
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt.categorias.categorias",
                            "Categoría modificada exitosamente"
                        );
                    }
                    break;

                case 'DEL':

                    $result = \Dao\Mnt\Categorias::eliminarCategoria(
                        $this -> viewData["catid"]
                    );

                    if($result){
                        
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt.categorias.categorias",
                            "Categoría eliminada exitosamente"
                        );
                    }
                    break;
            }
        }
    }

    private function prepareViewData(){

        if($this -> viewData["mode"] == "INS"){

            $this -> viewData["modeDsc"] = $this -> modeString[$this -> viewData["mode"]];
        }
        else{

            // obtener el código en base 10, ossa decimal
            $tmpCategoria = \Dao\Mnt\Categorias::obtenerCatId(
                intval($this -> viewData["catid"], 10)
            );

            \Utilities\ArrUtils::mergeFullArrayTo($tmpCategoria, $this -> viewData);

            // extrayendo los valores para mostrarlos al form
            $this -> viewData["modeDsc"] = sprintf(
                $this -> modeString[$this -> viewData["mode"]],
                $this -> viewData["catnom"],
                $this -> viewData["catid"]
            );
        }

        $this -> viewData["catestOptions"] = 

        \Utilities\ArrUtils::toOptionsArray(
            $this -> catesOptions,
            'value',
            'text',
            'selected',
            $this -> viewData["catest"]
        );

        $this -> viewData["crsxToken"] = md5(time()."categoria");
        $_SESSION["categoria_crsxtoken"] = $this -> viewData["crsxToken"];
    }

    public function run(): void
    {
        
        $this -> init();

        if($this -> isPostBack()){

            $this -> handlePost();
        }

        $this -> prepareViewData();
        Renderer::render('mnt/Categoria', $this -> viewData);
    }
}

?>