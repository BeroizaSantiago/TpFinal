<?php
require_once('BaseDatos.php');
class ResponsableV {

    private $rnumeroempleado;
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeOp;
    static $mensajeFallo = '';


    public function __construct(){
        $this->rnumeroempleado = '';
        $this->rnumerolicencia = '';
        $this->rnombre = '';
        $this->rapellido = '';
    }

    public function cargarDatos($numEmpleado, $numLicencia, $nombre, $apellido){
        $this->setNumEmpleado($numEmpleado);
        $this->setNumLicencia($numLicencia);
        $this->setNombre($nombre);
        $this->setApellido($apellido);
    }

    
    public function getNumEmpleado(){
        return $this->rnumeroempleado;
    }
    public function setNumEmpleado($numEmpleado){
        $this->rnumeroempleado = $numEmpleado;
    }
    public function getNumLicencia(){
        return $this->rnumerolicencia;
    }
    public function setNumLicencia($numLicencia){
        $this->rnumerolicencia = $numLicencia;
    }
    public function getNombre(){
        return $this->rnombre;
    }
    public function setNombre($nombre){
        $this->rnombre = $nombre;
    }
    public function getApellido(){
        return $this->rapellido;
    }
    public function setApellido($apellido){
        $this->rapellido = $apellido;
    }
    public function getMensajeOp(){
        return $this->mensajeOp;
    }
    public function setMensajeOp($mensajeOp){
        $this->mensajeOp = $mensajeOp;
    }
    public static function getMensajeFallo(){
        return ResponsableV::$mensajeFallo;
    }
    public static function setMensajeFallo($mensajeFallo){
        ResponsableV::$mensajeFallo = $mensajeFallo;
    }

    //toString
    public function __toString(){
        $numEmpleado = $this->getNumEmpleado();
        $numLicencia = $this->getNumLicencia();
        $nombre = $this->getNombre();
        $apellido = $this->getApellido();
        $str = "
        Número de empleado: $numEmpleado.\n
        Número de licencia: $numLicencia.\n
        Nombre: $nombre.\n
        Apellido: $apellido.\n";
        return $str;
    }

    public function buscar($numEmpleado){
        $base = new BaseDatos();
        $respuesta = false;
        $consultaNumEmpleado = "SELECT * FROM responsable WHERE rnumeroempleado = $numEmpleado";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaNumEmpleado)){
                if($row2 = $base->Registro()){
                    $this->setNumEmpleado($numEmpleado);
                    $this->setNumLicencia($row2['rnumerolicencia']);
                    $this->setNombre($row2['rnombre']);
                    $this->setApellido($row2['rapellido']);
                    $respuesta = true;
                }
            }else{
                $this->setMensajeOp($base->getError());
            }
        }else{
            $this->setMensajeOp($base->getError());
        }
        return $respuesta;
    }

    public static function listar($condicion = ''){
        $arregloResponsable = null;
        $base = new BaseDatos();
        $consultaResponsable = "SELECT * FROM responsable";
        if($condicion != ''){
            $consultaResponsable = $consultaResponsable . ' WHERE ' . $condicion;
        }
        if($base->Iniciar()){
            if($base->Ejecutar($consultaResponsable)){
                $arregloResponsable = array();
                while($row2 = $base->Registro()){
                    $numEmpleado = $row2['rnumeroempleado'];
                    $numLicencia = $row2['rnumerolicencia'];
                    $nombre = $row2['rnombre'];
                    $apellido = $row2['rapellido'];

                    $responsable = new ResponsableV();
                    $responsable->cargarDatos($numEmpleado, $numLicencia, $nombre, $apellido);
                    array_push($arregloResponsable, $responsable);
                }
            }else{
                ResponsableV::setMensajeFallo($base->getError());
            }
        }else{
            //$this->setMensajeOp($base->getError());
            ResponsableV::setMensajeFallo($base->getError());
        }
        return $arregloResponsable;
    }
    
    public function insertar(){
        $base = new BaseDatos();
        $respuesta = false;
        $consultaInsertar = "INSERT INTO responsable VALUES ({$this->getNumEmpleado()}, {$this->getNumLicencia()}, '{$this->getNombre()}', '{$this->getApellido()}')";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaInsertar)){
                $respuesta = true;
            }else{
                $this->setMensajeOp($base->getError());    
            }
        }else{
            $this->setMensajeOp($base->getError());
        }
        return $respuesta;
    }

    public function modificar(){
        $base = new BaseDatos();
        $respuesta = false;
        $consultaModifica = "UPDATE responsable SET rnumerolicencia = {$this->getNumLicencia()}, rnombre = '{$this->getNombre()}', rapellido = '{$this->getApellido()}' WHERE rnumeroempleado = {$this->getNumEmpleado()}";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaModifica)){
                $respuesta = true;
            }else{
                $this->setMensajeOp($base->getError());    
            }
        }else{
            $this->setMensajeOp($base->getError());
        }
        return $respuesta;
    }

    public function eliminar(){
        $base = new BaseDatos();
        $respuesta = false;
        $consultaElimina = "DELETE FROM responsable WHERE rnumeroempleado = {$this->getNumEmpleado()}";
        if($base->Iniciar()){
            if($base->Ejecutar($consultaElimina)){
                $respuesta = true;
            }else{
                $this->setMensajeOp($base->getError());
            }
        }else{
            $this->setMensajeOp($base->getError());
        }
        return $respuesta;
    }

    
    function verResponsables() {
        $r = new ResponsableV;
        $resp = $r->listar();
    
        if (!empty($resp)) {
            echo "Lista de Responsables:\n".
            "\n*************************************************************\n";
            foreach ($resp as $res) {
                echo $res."\n*************************************************************\n";
            }
        } else {
            echo "No hay Responsables registrados.\n";
        }
    }
    
}