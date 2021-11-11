<?php
namespace Dao\Mnt;

use Dao\Table;

class Usuarios extends Table
{
    public static function obtenerUsuarios()
    {
        $sqlStr = "SELECT * from usuario;";
        return self::obtenerRegistros($sqlStr, array());
    }
    public static function obtenerUsuario($usercod)
    {
        $sqlStr = "SELECT * from usuario where usercod = :usercod;";
        return self::obtenerUnRegistro($sqlStr, array("usercod"=>intval($usercod)));
    }
    public static function crearUsuario($useremail, $username, $userpswd, $userfching, $userpswdest, $userpswdexp, $userest, $useractcod, $userpswdchg, $usertipo)
    {
        $sqlstr = "INSERT INTO usuario (useremail, username, userpswd, userfching, userpswdest, userpswdexp, userest, useractcod, userpswdchg, usertipo) values (:useremail, :username, :userpswd, :userfching, :userpswdest, :userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo);";
        $parametros = array(
            "useremail" => $useremail, 
            "username" => $username, 
            "userpswd" => $userpswd, 
            "userfching" => $userfching, 
            "userpswdest" => $userpswdest, 
            "userpswdexp" => $userpswdexp, 
            "userest" => $userest, 
            "useractcod" => $useractcod, 
            "userpswdchg" => $userpswdchg, 
            "usertipo" => $usertipo
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }

    public static function editarUsuario($usercod, $useremail, $username, $userpswd, $userpswdest, $userest, $usertipo)
    {
        // campos modificables directamente: useremail, username, userpswd, userpswdest, userest, usertipo 
        // los demas campos se consideran no muteables

        if(isset($useremail)) //correo
        {
            $sqlstr = "UPDATE usuario set useremail=:useremail, useractcod=:useractcod where usercod = :usercod;";
            $parametros = array(
                "useremail" => $useremail,
                "useractcod" => hash("sha256", $useremail.time()),
                "usercod" => intval($usercod)
            );
            return self::executeNonQuery($sqlstr, $parametros);
        }

        if(isset($username)) //nombre de usuario
        {
            $sqlstr = "UPDATE usuario set username=:username where usercod = :usercod;";
            $parametros = array(
                "username" => $username,
                "usercod" => intval($usercod)
            );
            return self::executeNonQuery($sqlstr, $parametros);
        }

        if(isset($userpswd)) //password
        {
            $sqlstr = "UPDATE usuario set userpswd=:userpswd where usercod = :usercod;";
            $parametros = array(
                "userpswd" => $userpswd,
                "userpswdchg" => date('Y-m-d H:i:s'), 
                "usercod" => intval($usercod)
            );
            return self::executeNonQuery($sqlstr, $parametros);
        }        

        if(isset($userpswd)) //estado
        {
            $sqlstr = "UPDATE usuario set userest=:userest where usercod = :usercod;";
            $parametros = array(
                "userest" => $userest,
                "usercod" => intval($usercod)
            );
            return self::executeNonQuery($sqlstr, $parametros);
        } 

        if(isset($userpswd)) //usertipo
        {
            $sqlstr = "UPDATE usuario set usertipo=:usertipo where usercod = :usercod;";
            $parametros = array(
                "usertipo" => $usertipo,
                "usercod" => intval($usercod)
            );
            return self::executeNonQuery($sqlstr, $parametros);
        } 

        // sqlstr = "UPDATE X SET Y = '".$Y."' where Z='".$Z."';";
        // $Y = "'; DROP DATABASE mysql; SELECT * FROM (SELECT DATE)
    }

    public static function eliminarUsuario($usercod)
    {
        $sqlstr = "DELETE FROM usuario where usercod=:usercod;";
        $parametros = array(
            "usercod" => intval($usercod)
        );
        return self::executeNonQuery($sqlstr, $parametros);
    }
}

?>
