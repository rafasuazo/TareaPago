<?php

namespace Controllers\Mnt\IntentoPagos;

use Controllers\PublicController;
use Views\Renderer;

use function PHPSTORM_META\map;

class IntentoPago extends PublicController{

    private $modeString = array(
        "INS" => "Nuevo Pago",
        "UPD" => "Editar pago del cliente  %s (%s)",
        "DSP" => "Detalle pago del cliente %s (%s)",
        "DEL" => "Eliminando pago del cliente %s (%s)"
    );

    private $estadoOpciones = array(

        // ENV|PGD|CNL|ERR
        "ENV" => "Enviado",
        "PGD" => "Pagado",
        "CNL" => "Cancelado",
        "ERR" => "Error"
    );

    private $viewData = array(

        "mode" => "INS",
        "id" => 0,
        "fecha" => "",
        "cliente" => "",
        "monto" => 0.00,
        "fechaVencimiento" => "",
        "estado" => "ENV",
        "modeDsc" => "",
        "readonly" => "readonly",
        "isInsert" => false,
        "isViewMode" => false,
        "isRead" => false,
        "estadoOpciones" => [],
        "crsxToken" => ""
    );

    private function init(){

        if(isset($_GET["mode"])){
            $this -> viewData["mode"] = $_GET["mode"];
        }

        if(isset($_GET["id"])){
            $this -> viewData["id"] = $_GET["id"];
        }

        if(!isset($this -> modeString[$this -> viewData["mode"]])){

            error_log($this -> toString()."Modo no válido".$this -> viewData["mode"], 0);

            \Utilities\Site::redirectToWithMsg(
                "index.php?page=mnt.intentopagos.intentopagos",
                "Error al procesar la página"
            );
        }

        if($this -> viewData["mode"] !== 'INS' && intval($this -> viewData["id"],10) !== 0){
            $this -> viewData["mode"] !== 'DSP';
        }
    }

    private function handlPost(){

        \Utilities\ArrUtils::mergeFullArrayTo($_POST, $this -> viewData);

        if(!(isset($_SESSION["pago_crsxToken"]) 
        && $_SESSION["pago_crsxToken"] == $this -> viewData["crsxToken"])){

            unset($_SESSION["pago_crsxToken"]);
            \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt.intentopagos.intentopagos",
            "Ocurrió un problema al procesar el formulario");
        }

        $this -> viewData["id"] = intval($this -> viewData["id"],10);

        if(!\Utilities\Validators::isMatch($this -> viewData["estado"], "/^(ENV)|(PGD)|(CNL)|(ERR)$/")){
            $this -> viewData["errors"][] = "Pago debe ser ENV o PGD o CNL o ERR";
        }

        if(isset($this -> viewData["errors"]) && count($this -> viewData["errors"]) > 0){

        }
        else{

            unset($_SESSION["pago_crsxToken"]);
            
            switch($this -> viewData["mode"]){

                case 'INS':

                    $result = \Dao\IntentoPagos\IntentoPagos::nuevoPago(
                        $this -> viewData["cliente"],
                        $this -> viewData["monto"],
                        $this -> viewData["fechaVencimiento"],
                        $this -> viewData["estado"]
                    );

                    if($result){
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt.intentopagos.intentopagos",
                            "Pago guardado satisfactoriamente"
                        );
                    }
                    break;

                case 'UPD':

                    $result = \Dao\IntentoPagos\IntentoPagos::actualizarPago(
                        $this -> viewData["fecha"],
                        $this -> viewData["cliente"],
                        $this -> viewData["monto"],
                        $this -> viewData["fechaVencimiento"],
                        $this -> viewData["estado"],
                        $this -> viewData["id"]
                    );

                    if($result){
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt.intentopagos.intentopagos",
                            "Pago modificado satisfactoriamente"
                        );
                    }
                    break;

                case 'DEL':

                    $result = \Dao\IntentoPagos\IntentoPagos::eliminarPago(
                        $this -> viewData["id"]
                    );

                    if($result){
                        \Utilities\Site::redirectToWithMsg(
                            "index.php?page=mnt.intentopagos.intentopagos",
                            "Pago eliminado satisfactoriamente"
                        );
                    }
                    break;
            }
        }
    }

    private function prepareViewData(){

        if($this -> viewData["mode"] == 'INS'){
            
            $this -> viewData["modeDsc"] = $this -> modeString[$this -> viewData["mode"]];
        }
        else{

            $tmpPago = \Dao\IntentoPagos\IntentoPagos::obtenerPagoId(
                intval($this -> viewData["id"],10)
            );

            // si el estado es actualizar, eliminar o solo mostrar, seteamos la variable en true
            if($this -> viewData["mode"] == 'UPD' || $this -> viewData["mode"] == 'DEL'
               || $this -> viewData["mode"] == 'DSP'){

                $this -> viewData["isViewMode"] = true;
            }

            // si es display, dejar los campos no editables
            if($this -> viewData["mode"] == 'DSP' || $this -> viewData["mode"] == 'DEL'){
                $this -> viewData["isRead"] = true;
            }

            \Utilities\ArrUtils::mergeFullArrayTo($tmpPago, $this -> viewData);

            $this -> viewData["modeDsc"] = sprintf(

                $this -> modeString[$this -> viewData["mode"]],
                $this -> viewData["cliente"],
                $this -> viewData["id"]
            );
        }

        $this -> viewData["estadoOpciones"] =
            
        \Utilities\ArrUtils::toOptionsArray(
            $this -> estadoOpciones,
            'value',
            'text',
            'selected',
            $this -> viewData["estado"]
        );

        $this -> viewData["crsxToken"] = md5(time()."pago");
        $_SESSION["pago_crsxToken"] = $this -> viewData["crsxToken"];
    }



    public function run(): void
    {
        $this -> init();

        if($this -> isPostBack()){
            $this -> handlPost();
        }

        $this -> prepareViewData();
        Renderer::render('mnt/intentopago', $this -> viewData);
    }
}

?>