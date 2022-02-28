<?php

namespace Dao\Mnt;

use Dao\Table;

class Categorias extends Table{

    // tiene que ser estatico porque tambien lo son las funciones en Table
    public static function obtenerTodos(){
        
        $sqlstr = "SELECT * FROM categorias; ";
        return self::obtenerRegistros($sqlstr, array());
    }

    public static function obtenerCatId($catid){
        
        $sqlstr = "SELECT * FROM categorias  WHERE catid = :catid ; ";
        return self::obtenerUnRegistro(
            $sqlstr, 
            array("catid" => $catid)
        );
    }

    public static function nuevaCategoria($catnom, $catest){

        $sqlstr = "INSERT INTO categorias (catnom, catest) VALUES(:catnom, :catest); ";

        return self::executeNonQuery(
             $sqlstr,
             array(
                 "catnom" => $catnom,
                 "catest" => $catest
             )
         );
    }


    public static function actualizarCategoria($catnom, $catest, $catid){

        $sqlstr = "UPDATE categorias SET catnom = :catnom, catest = :catest WHERE
        catid = :catid";

         return self::executeNonQuery(
             $sqlstr, 
             array(
                 "catnom" => $catnom,
                 "catest" => $catest,
                 "catid" => $catid));
    }

    public static function eliminarCategoria($catid){

        $sqlstr = "DELETE FROM categorias WHERE catid = :catid";

        return self::executeNonQuery(
            $sqlstr,
            array(
                "catid" => $catid
            )
        );
    }
}

?>