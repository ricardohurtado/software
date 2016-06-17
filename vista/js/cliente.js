$(document).ready(function () {
    listar();
});



function listar() {
    var codigoDepartamento = $("#cbolinea").val();

    if (codigoDepartamento === null) {
        codigoDepartamento = '00';
    }

    var codigoProvincia = $("#cbocategoria").val();
    if (codigoProvincia === null) {
        codigoProvincia = '00';
    }
    var codigoDistrito = $("#cbomarca").val();
    if (codigoDistrito === null) {
        codigoDistrito = '00';
    }

    $.post("../controlador/cliente.listar.controlador.php",
            {
                codigoDepartamento: codigoDepartamento,
                codigoProvincia: codigoProvincia,
                codigoDistrito: codigoDistrito
            }
    ).done(function (resultado) {
        var datosJSON = resultado;
        if (datosJSON.estado === 200) {
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            html += '<th>N</th>';
            html += '<th>CODIGO</th>';
            html += '<th>DOCUMENTO DE IDENTIDAD</th>';
            html += '<th>NOMBRE</th>';
            html += '<th>DIRECCION</th>';
            html += '<th>TELEFONO</th>';
            html += '<th>EMAIL</th>';
            html += '<th>DIRECCION WEB</th>';
            html += '<th>DEPARTAMENTO</th>';
            html += '<th>PROVINCIA</th>';
            html += '<th>DISTRITO</th>';
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function (i, item) {
                html += '<tr>';
                html += '<td>' + i + '</td>';
                html += '<td align="center">' + item.codigo_cliente + '</td>';
                html += '<td>' + item.nro_documento_identidad + '</td>';
                html += '<td>' + item.nombre + '</td>';
                html += '<td>' + item.direccion + '</td>';
                html += '<td>' + item.telefono_fijo + '</td>';
                html += '<td>' + item.email + '</td>';
                html += '<td>' + item.direccion_web + '</td>';
                html += '<td>' + item.departamento + '</td>';
                html += '<td>' + item.provincia + '</td>';
                html += '<td>' + item.distrito + '</td>';
                html += '<td align="center">';
                html += '<button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal" onclick="leerDatos(' + item.codigo_cliente + ')"><i class="fa fa-pencil"></i></button>';
                html += '&nbsp;&nbsp;';
                html += '<button type="button" class="btn btn-danger btn-xs" onclick="eliminar(' + item.codigo_cliente + ')"><i class="fa fa-close"></i></button>';
                html += '</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';

            $("#listado").html(html);

            $('#tabla-listado').dataTable({
                "aaSorting": [[2, "asc"]]
            });

        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}

function cargarComboDepartamento(p_nombreCombo, p_tipo) {
    $.post(
            "../controlador/linea.cargar.combo.controlador.php"
            ).done(function (resultado) {
        var datosJSON = resultado;

        if (datosJSON.estado === 200) {
            var html = "";
            if (p_tipo === "seleccione") {
                html += '<option value="">Seleccione una linea</option>';
            } else {
                html += '<option value="0">Todas las lineas</option>';
            }


            $.each(datosJSON.datos, function (i, item) {
                html += '<option value="' + item.codigo_linea + '">' + item.descripcion + '</option>';
            });

            $(p_nombreCombo).html(html);
        } else {
            swal("Mensaje del sistema", resultado, "warning");
        }
    }).fail(function (error) {
        var datosJSON = $.parseJSON(error.responseText);
        swal("Error", datosJSON.mensaje, "error");
    });
}