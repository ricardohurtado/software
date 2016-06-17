<?php
require_once '../datos/Conexion.clase.php';

class Cliente extends Conexion {
    private $codigoCliente;
    private $apellidoPaterno;
    private $apellidoMaterno;
    private $nombres;
    private $nroDocumentoIdentidad;
    private $direccion;
    private $telefonoFijo;
    private $telefonoMovil1;
    private $telefonoMovil2;
    private $email;
    private $direccionWeb;
    private $codigoDepartamento;
    private $codigoProvincia;
    private $codigoDistrito;
    
    function getCodigoCliente() {
        return $this->codigoCliente;
    }

    function getApellidoPaterno() {
        return $this->apellidoPaterno;
    }

    function getApellidoMaterno() {
        return $this->apellidoMaterno;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getNroDocumentoIdentidad() {
        return $this->nroDocumentoIdentidad;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getTelefonoFijo() {
        return $this->telefonoFijo;
    }

    function getTelefonoMovil1() {
        return $this->telefonoMovil1;
    }

    function getTelefonoMovil2() {
        return $this->telefonoMovil2;
    }

    function getEmail() {
        return $this->email;
    }

    function getDireccionWeb() {
        return $this->direccionWeb;
    }

    function getCodigoDepartamento() {
        return $this->codigoDepartamento;
    }

    function getCodigoProvincia() {
        return $this->codigoProvincia;
    }

    function getCodigoDistrito() {
        return $this->codigoDistrito;
    }

    function setCodigoCliente($codigoCliente) {
        $this->codigoCliente = $codigoCliente;
    }

    function setApellidoPaterno($apellidoPaterno) {
        $this->apellidoPaterno = $apellidoPaterno;
    }

    function setApellidoMaterno($apellidoMaterno) {
        $this->apellidoMaterno = $apellidoMaterno;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setNroDocumentoIdentidad($nroDocumentoIdentidad) {
        $this->nroDocumentoIdentidad = $nroDocumentoIdentidad;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setTelefonoFijo($telefonoFijo) {
        $this->telefonoFijo = $telefonoFijo;
    }

    function setTelefonoMovil1($telefonoMovil1) {
        $this->telefonoMovil1 = $telefonoMovil1;
    }

    function setTelefonoMovil2($telefonoMovil2) {
        $this->telefonoMovil2 = $telefonoMovil2;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDireccionWeb($direccionWeb) {
        $this->direccionWeb = $direccionWeb;
    }

    function setCodigoDepartamento($codigoDepartamento) {
        $this->codigoDepartamento = $codigoDepartamento;
    }

    function setCodigoProvincia($codigoProvincia) {
        $this->codigoProvincia = $codigoProvincia;
    }

    function setCodigoDistrito($codigoDistrito) {
        $this->codigoDistrito = $codigoDistrito;
    }
    
    public function listar($p_codigoDepartamento, $p_codigoProvincia, $p_codigoDistrito) {
        try {
            $sql = "select * from f_listar_cliente(:p_codigoDepartamento, :p_codigoProvincia, :p_codigoDistrito);";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoDepartamento", $p_codigoDepartamento);
            $sentencia->bindParam(":p_codigoProvincia", $p_codigoProvincia);
            $sentencia->bindParam(":p_codigoDistrito", $p_codigoDistrito);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function cargarDatosCliente($nombre) {
        try {
            $sql = "
		select 
		    codigo_cliente, 
		    (apellido_paterno || ' ' || apellido_materno || ', ' || nombres) as nombre_completo, 
		    direccion, 
		    telefono_fijo, 
		    coalesce(telefono_movil1, '')  as movil1,
		    coalesce(telefono_movil2, '')  as movil2
		from 
		    cliente 
		where 
		    lower(apellido_paterno || ' ' || apellido_materno || ' ' || nombres) like :p_nombre";
            $sentencia = $this->dblink->prepare($sql);
            $nombre = '%'.  strtolower($nombre).'%';
            $sentencia->bindParam(":p_nombre", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
    
    
}