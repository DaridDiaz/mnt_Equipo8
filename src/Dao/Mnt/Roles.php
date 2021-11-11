<?php
namespace Dao\Mnt;

use Dao\Table;

class Roles extends Table
{
    public static function obtenerRoles()
    {
        $sqlStr = "SELECT * from roles;";
        return self::obtenerRegistros($sqlStr, array());
    }
    public static function obtenerRol($rolescod)
    {
        $sqlStr = "SELECT * from roles where rolescod = :rolescod;";
        return self::obtenerUnRegistro($sqlStr, array("rolescod"=>intval($rolescod)));
    }
    public static function crearRol($rolescod, $rolesdsc, $rolesest)
    {
        $sqlstr = "INSERT INTO roles (rolescod, rolesdsc, rolesest) values (:rolescod, :rolesdsc, :rolesest);";
        $parametros = array(
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }

    public static function editarRol($rolesdsc, $rolesest, $rolescod)
    {
        $sqlstr = "UPDATE roles set rolesdsc=:rolesdsc, rolesest=:rolesest where rolescod = :rolescod;";
        $parametros = array(
            "rolesdsc" =>  $rolesdsc,
            "rolesest" =>  $rolesest,
            "rolescod" => ($rolescod)
        );
        return self::executeNonQuery($sqlstr, $parametros);
        // sqlstr = "UPDATE X SET Y = '".$Y."' where Z='".$Z."';";
        // $Y = "'; DROP DATABASE mysql; SELECT * FROM (SELECT DATE)
    }

    public static function eliminarRol($rolescod)
    {
        $sqlstr = "DELETE FROM roles where rolescod=:rolescod;";
        $parametros = array(
            "rolescod" => ($rolescod)
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }
}

?>