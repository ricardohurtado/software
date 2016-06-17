<?php
require_once '../negocio/Venta.clase.php';
require_once '../util/funciones/Funciones.clase.php';
try {
    if (!isset($_POST["p_numero_venta"])) {
        Funciones::imprimeJSON(500, "Faltan parametros", "");
        exit;
    }
    $numero_venta = $_POST["p_numero_venta"];
    $objVenta = new Venta();
    $resultado = $objVenta->anular($numero_venta);
    if($resultado == true){
        Funciones::imprimeJSON(200, "Venta anulada correctamente", "");
    }
} catch (Exception $ex) {
    Funciones::imprimeJSON(500, $ex->getMessage(), "");
}