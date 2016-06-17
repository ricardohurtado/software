$(document).ready(function () {
    listar();
});


$("#btnagregar").click(function () {
    document.location.href = "venta.vista.php";
});

$("#btnfiltrar").click(function () {
    listar();
});


function listar() {
    var fecha1 = $("#txtfecha1").val();
    var fecha2 = $("#txtfecha2").val();
    var tipo = $("#rbtipo:checked").val();

    $.post("../controlador/venta.listar.controlador.php",
            {fecha1: fecha1, fecha2: fecha2, tipo: tipo}
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '<th>Nro</th>';
            html += '<th>T. COMP.</th>';
            html += '<th>SERIE</th>';
            html += '<th>DOC.</th>';
            html += '<th>FECHA DE VENTA</th>';
            html += '<th>CLIENTE</th>';
            html += '<th>SUB TOTAL</th>';
            html += '<th>IGV</th>';
            html += '<th>TOTAL</th>';
            html += '<th>PORCENT.IGV</th>';
            html += '<th>ESTADO</th>';
            html += '<th>USUARIO</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                if (item.estado === "Emitido") {
                    html += '<tr>';
                    html += '<td align="center">';
                    html += '<button type="button" class="btn btn-danger btn-xs" onclick="anular(' + item.nv + ')"><i class="fa fa-close"></i></button>';
                    html += '</td>';
                } else {
                    html += '<tr style="text-decoration:line-through; color: red" >';
                    html += '<td align="center">';
                    html += '</td>';
                }

                html += '<td>' + item.nv + '</td>';
                html += '<td align="center">' + item.tip_com + '</td>';
                html += '<td>' + item.serie + '</td>';
                html += '<td>' + item.doc + '</td>';
                html += '<td>' + item.fec_vta + '</td>';
                html += '<td>' + item.cliente + '</td>';
                html += '<td>' + item.sub_total + '</td>';
                html += '<td>' + item.igv + '</td>';
                html += '<td>' + item.total + '</td>';
                html += '<td>' + item.por_igv + '</td>';
                html += '<td>' + item.estado + '</td>';
                html += '<td>' + item.usuario + '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listado").html(html);

            $('#tabla-listado').dataTable({
                "aaSorting": [[1, "desc"]],
                "sScrollX": "100%",
                "sScrollXInner": "150%",
                "bScrollCollapse": true,
                "bPaginate": true
            });
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function anular(nroVenta) {
    swal({
        title: "Confirme",
        text: "¿Esta seguro de eliminar el registro seleccionado?",
        showCancelButton: true,
        confirmButtonColor: '#d93f1f',
        confirmButtonText: 'Si',
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: true,
        imageUrl: "../imagenes/eliminar.png"
    },
            function (isConfirm) {
                if (isConfirm) {
                    $.post("../controlador/venta.anular.controlador.php",
                            {p_numero_venta: nroVenta}
                    ).done(function (resultado) {
                        var datosJSON = resultado;
                        if (datosJSON.estado === 200) {
                            listar();
                            swal("Exito", datosJSON.mensaje, "success");
                        }
                    }).fail(function (error) {
                        var datosJSON = $.parseJSON(error.responseText);
                        swal("Error", datosJSON.mensaje, "error");
                    });
                }
            });
}