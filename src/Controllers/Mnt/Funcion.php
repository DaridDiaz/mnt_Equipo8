<?php
namespace Controllers\Mnt;

use Controllers\PublicController;

class Funcion extends PublicController
{
    private function nope()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_funciones",
            "Ocurrió algo inesperado. Intente Nuevamente."
        );
    }
    private function yeah()
    {
        \Utilities\Site::redirectToWithMsg(
            "index.php?page=mnt_funciones",
            "Operación ejecutada Satisfactoriamente!"
        );
    }
    public function run() :void
    {
        $viewData = array(
            "mode_dsc"=>"",
            "mode" => "",
            "fncod" => "",
            "fndsc" => "",
            "fnest_ACT"=>"",
            "fnest_INA" => "",
            "fnest_PLN"=>"",
            "fntyp" => "",
            "hasErrors" => false,
            "Errors" => array(),
            "showaction"=>true,
            "readonly" => false
        );
        $modeDscArr = array(
            "INS" => "Nueva Funcion",
            "UPD" => "Editando Funcion (%s) %s",
            "DEL" => "Eliminando Funcion (%s) %s",
            "DSP" => "Detalle de Funcion (%s) %s"
        );

        if ($this->isPostBack()) {
            // se ejecuta al dar click sobre guardar
            $viewData["mode"] = $_POST["mode"];
            $viewData["fncod"] = $_POST["fncod"] ;
            $viewData["fndsc"] = $_POST["fndsc"];
            $viewData["fnest"] = $_POST["fnest"];
            $viewData["fntyp"] = $_POST["fntyp"];
            $viewData["xsrftoken"] = $_POST["xsrftoken"];
            // Validate XSRF Token
            if (!isset($_SESSION["xsrftoken"]) || $viewData["xsrftoken"] != $_SESSION["xsrftoken"]) {
                $this->nope();
            }
            // Validaciones de Errores
            if (\Utilities\Validators::IsEmpty($viewData["fndsc"])) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "El nombre no Puede Ir Vacio!";
            }
            if (($viewData["fnest"] == "INA"
                || $viewData["fnest"] == "ACT"
                || $viewData["fnest"] == "PLN"
                ) == false
            ) {
                $viewData["hasErrors"] = true;
                $viewData["Errors"][] = "Estado de Categoria Incorrecto!";
            }

            
            if (!$viewData["hasErrors"]) {
                switch($viewData["mode"]) {
                case "INS":
                    if (\Dao\Mnt\Funciones::crearFuncion(
                        $viewData["fncod"],
                        $viewData["fndsc"],
                        $viewData["fnest"],
                        $viewData["fntyp"]
                    )
                    ) {
                        $this->yeah();
                    }
                    break;
                case "UPD":
                    if (\Dao\Mnt\Funciones::editarFuncion(
                        $viewData["fndsc"],
                        $viewData["fnest"],
                        $viewData["fntyp"],
                        $viewData["fncod"]
                    )
                    ) {
                        $this->yeah();
                    }
                    break;
                case "DEL":
                    if (\Dao\Mnt\Funciones::eliminarFuncion(
                        $viewData["fncod"]
                    )
                    ) {
                        $this->yeah();
                    }
                    break;
                }
            }
        } else {
            // se ejecuta si se refresca o viene la peticion
            // desde la lista
            if (isset($_GET["mode"])) {
                if (!isset($modeDscArr[$_GET["mode"]])) {
                    $this->nope();
                }
                $viewData["mode"] = $_GET["mode"];
            } else {
                $this->nope();
            }
            if (isset($_GET["fncod"])) {
                $viewData["fncod"] = $_GET["fncod"];
            } else {
                if ($viewData["mode"] !=="INS") {
                    $this->nope();
                }
            }
        }

        // Hacer elementos en comun
       
        if ($viewData["mode"] == "INS") {
            $viewData["mode_dsc"]  = $modeDscArr["INS"];
        } else {
            $tmpFuncion = \Dao\Mnt\Funciones::obtenerFuncion($viewData["fncod"]);
            $viewData["fndsc"] = $tmpFuncion["fndsc"];
            $viewData["fnest_ACT"] = $tmpFuncion["fnest"] == "ACT" ? "selected": "";
            $viewData["fnest_INA"] = $tmpFuncion["fnest"] == "INA" ? "selected" : "";
            $viewData["fnest_PLN"] = $tmpFuncion["fnest"] == "PLN" ? "selected" : "";
            $viewData["fntyp"] = $tmpFuncion["fntyp"];
            $viewData["mode_dsc"]  = sprintf(
                $modeDscArr[$viewData["mode"]],
                $viewData["fncod"],
                $viewData["fndsc"],
                $viewData["fntyp"]
            );
            if ($viewData["mode"] == "DSP") {
                $viewData["showaction"]= false ;
                $viewData["readonly"] = "readonly";
            }
            if ($viewData["mode"] == "DEL") {
                $viewData["readonly"] = "readonly";
            }

        }
        // Generar un token XSRF para evitar esos ataques
        $viewData["xsrftoken"] = md5($this->name . random_int(10000, 99999));
        $_SESSION["xsrftoken"] = $viewData["xsrftoken"];

        \Views\Renderer::render("mnt/funcion", $viewData);
    }
}


?>