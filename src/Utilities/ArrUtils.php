<?php 
  namespace Utilities;

  class ArrUtils
  {

    /**
     * Combina el arreglo de origen con el arreglo destino donde las llaves
     * del destino coinciden con las llaves del origen.
     *
     * @param array $origin  Arreglo de Origen
     * @param array $destiny Arreglo de Destino
     *
     * @return void
     */
    public static function mergeArrayTo(&$origin, &$destiny)
    {
        if (is_array($origin) && is_array($destiny)) {
            foreach ($origin as $okey => $ovalue) {
                if (isset($destiny[$okey])) {
                    $destiny[$okey] = $ovalue;
                }
            }
        }
    }

    /**
     * Combina el arreglo de origen con el arreglo destino donde las llaves
     * del destino coinciden con las llaves del origen y agregando las 
     * llaves no existentes a las de origen.
     *
     * @param array $origin  Arreglo de Origen
     * @param array $destiny Arreglo de Destino
     *
     * @return void
     */
    public static function mergeFullArrayTo(&$origin, &$destiny)
    {
        if (is_array($origin) && is_array($destiny)) {
            foreach ($origin as $okey => $ovalue) {
                $destiny[$okey] = $ovalue;
            }
        }
    }

    public static function toOptionsArray($baseArray, $codeName, $textName, $selectedName, $selectedValue){

        $tmpArray = array();

        foreach($baseArray as $key => $value){

            $tmpArray[] = array(

                $codeName => $key,
                $textName => $value,
                $selectedName => ($selectedValue == $key) ? 'selected' : ''
            );
        }

        return $tmpArray;
        
    }

    private function __construct()
    {
      
    }
  }

?>
