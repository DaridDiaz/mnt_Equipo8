<?php
namespace Dao\Mnt;

use Dao\Table;

class Funciones extends Table
{
    public static function obtenerFunciones()
    {
        $sqlStr = "SELECT * from funciones;";
        return self::obtenerRegistros($sqlStr, array());
    }
    public static function obtenerFuncion($catid)
    {
        $sqlStr = "SELECT * from funciones where fncod = :fncod;";
        return self::obtenerUnRegistro($sqlStr, array("fncod"=>intval($fncod)));
    }
    public static function crearFuncion($fncod,$fndsc, $fnest, $fntyp)
    {
        $sqlstr = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp) values (:fncod, :fndsc, :fnest, :fntyp);";
        $parametros = array(
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }

    public static function editarFuncion($fndsc, $fnest, $fntyp, $fncod)
    {
        $sqlstr = "UPDATE funciones set fndsc=:fndsc, fnest=:fnest, fntyp=:fntyp where fncod = :fncod;";
        $parametros = array(
            "fndsc" =>  $fndsc,
            "fnest" =>  $fnest,
            "fntyp" =>  $fntyp,
            "fncod" => ($fncod)
        );
        return self::executeNonQuery($sqlstr, $parametros);
        // sqlstr = "UPDATE X SET Y = '".$Y."' where Z='".$Z."';";
        // $Y = "'; DROP DATABASE mysql; SELECT * FROM (SELECT DATE)
    }

    public static function eliminarFuncion($fncod)
    {
        $sqlstr = "DELETE FROM funciones where fncod=:fncod;";
        $parametros = array(
            "fncod" => ($fncod)
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }
}

?>