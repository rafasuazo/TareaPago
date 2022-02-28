<?php

namespace Dao\IntentoPagos;

use Dao\Table;

class IntentoPagos extends Table{

    public static function obtenerPagos(){

        $sqltr = "SELECT * FROM intentospagos; ";
        return self::obtenerRegistros(
            $sqltr,
            array()
        );
    }

    public static function obtenerPagoId($id){

        $sqltr = "SELECT * FROM intentospagos WHERE id = :id";
        return self::obtenerUnRegistro(
            $sqltr,
            array("id" => $id)
        );
    }

    public static function nuevoPago($cliente, $monto, $fechaVencimiento, $estado){

        $sqltr = "INSERT INTO intentospagos(fecha, cliente, monto, fechaVencimiento, estado)
        VALUES(date(now()), :cliente, :monto, :fechaVencimiento, :estado);";

        return self::executeNonQuery(
            $sqltr,
            array(
                "cliente" => $cliente,
                "monto" => $monto,
                "fechaVencimiento" => $fechaVencimiento,
                "estado" => $estado
            )
        );
    }

    public static function actualizarPago($fecha, $cliente, $monto, $fechaVencimiento, $estado, $id){

        $sqltr = "UPDATE intentospagos SET fecha = :fecha, 
        cliente = :cliente, monto = :monto,
        fechaVencimiento = :fechaVencimiento, 
        estado = :estado WHERE id = :id; ";

        return self::executeNonQuery(
            $sqltr,
            array(
                "fecha" => $fecha,
                "cliente" => $cliente,
                "monto" => $monto,
                "fechaVencimiento" => $fechaVencimiento,
                "estado" => $estado,
                "id" => $id
            )
        );
    }

    public static function eliminarPago($id){

        $sqltr = "DELETE FROM intentospagos WHERE id = :id";
        return self::executeNonQuery(
            $sqltr,
            array(
                "id" => $id
            )
        );
    }
}

?>