<?php
require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';
try {
    if(!isset($_POST["codigoDepartamento"]) || !isset($_POST["codigoProvincia"]) || !isset($_POST["codigoDistrito"])){
        Funciones::imprimeJSON(500, "Faltan parametros", "");
//        El error 500 en http significa que ha ocurrido un error.
        exit;
    }
    $codigoDepartamento = $_POST["codigoDepartamento"];
    $codigoProvincia = $_POST["codigoProvincia"];
    $codigoDistrito = $_POST["codigoDistrito"];
    $objCliente = new Cliente();
    $resultado = $objCliente->listar($codigoDepartamento, $codigoProvincia, $codigoDistrito);
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $ex) {
//    Funciones::mensaje($ex->getMessage(), "e");
    Funciones::imprimeJSON(500, $ex->getMessage(), "");
}
