<?php

require_once '../negocio/Articulo.clase.php';
try {

    $codigoLinea = $_POST["cbolinea"];

    if (isset($_POST["cbocategoria"])) {
        $codigoCategoria = $_POST["cbocategoria"];
    } else {
        $codigoCategoria = 0;
    }

    $codigoMarca = $_POST["cbomarca"];

    $objArticulo = new Articulo();
    $resultado = $objArticulo->listar($codigoLinea, $codigoCategoria, $codigoMarca);

//    echo '<pre>';
//    print_r($resultado);
//    echo '</pre>';
    $htmlDatosReporte = '<table border="0" cellpadding="3" cellspacing="0">';
    $htmlDatosReporte .= '<thead>';

    $htmlDatosReporte .= '<tr>';
    $htmlDatosReporte .= '<td colspan="6" class="titulo-reporte">REPORTE DE ARTICULOS</td>';
    $htmlDatosReporte .= '</tr>';

    $htmlDatosReporte .= '<tr>';
    $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">CODIGO</td>';
    $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">NOMBRE DEL ARTICULO</td>';
    $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">PRECIO</td>';
    $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">LINEA</td>';
    $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">CATEGORIA</td>';
    $htmlDatosReporte .= '<td class="cabecera-reporte-lineas">MARCA</td>';
    $htmlDatosReporte .= '</tr>';
    $htmlDatosReporte .= '</thead>';


    $htmlDatosReporte .= '<tbody>';
    for ($i = 0; $i < count($resultado); $i++) {
        $htmlDatosReporte .= '<tr>';
        $htmlDatosReporte .= '<td>' . $resultado[$i]["codigo"] . '</td>';
        $htmlDatosReporte .= '<td>' . $resultado[$i]["nombre"] . '</td>';
        $htmlDatosReporte .= '<td>' . $resultado[$i]["precio"] . '</td>';
        $htmlDatosReporte .= '<td>' . $resultado[$i]["linea"] . '</td>';
        $htmlDatosReporte .= '<td>' . $resultado[$i]["categoria"] . '</td>';
        $htmlDatosReporte .= '<td>' . $resultado[$i]["marca"] . '</td>';
        $htmlDatosReporte .= '</tr>';
    }
    $htmlDatosReporte .= '</tbody>';


    $htmlDatosReporte .= '</table>';

//    echo $htmlDatosReporte;
    $htmlReporte = Funciones::generarHTMLReporte($htmlDatosReporte);
    
    $tipo_reporte = $_POST["tipo_reporte"];
    Funciones::generarReporte($htmlReporte, $tipo_reporte, "reporte-articulos");

//    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $ex) {
//    Funciones::mensaje($ex->getMessage(), "e");
    Funciones::imprimeJSON(500, $ex->getMessage(), "");
}

