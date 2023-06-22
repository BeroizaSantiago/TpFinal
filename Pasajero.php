<?php
require_once('BaseDatos.php');
require_once('Viaje.php');

class Pasajero{
    private $pdocumento;
    private $pnombre;
    private $papellido;
    private $ptelefono;
    private $idviaje;
    private $mensajeOp;
    static $mensajeFallo = '';

    public function __construct(){
        $this->pdocumento = '';
        $this->pnombre = '';
        $this->papellido = '';
        $this->ptelefono = '';
        $this->idviaje = new Viaje;
        $this->mensajeOp = '';
    }

    public function getPdocumento(){
        return $this->pdocumento;
    }
    public function setPdocumento($pDocumento){
        $this->pdocumento = $pDocumento;
    }
    public function getPnombre(){
        return $this->pnombre;
    }
    public function setPnombre($pnombre){
        $this->pnombre = $pnombre;
    }
    public function getPapellido(){
        return $this->papellido;
    }
    public function setPapellido($papellido){
        $this->papellido = $papellido;
    }
    public function getPtelefono(){
        return $this->ptelefono;
    }
    public function setPtelefono($ptelefono){
        $this->ptelefono = $ptelefono;
    }
    public function getObjViaje(){
        return $this->idviaje;
    }
    public function setObjViaje($objViaje){
        $this->idviaje = $objViaje;
    }
    public function getMensajeOp(){
        return $this->mensajeOp;
    }
    public function setMensajeOp($mensajeOp){
        $this->mensajeOp = $mensajeOp;
    }
    public static function getMensajeFallo(){
        return Pasajero::$mensajeFallo;
    }
    public static function setMensajeFallo($mensajeFallo){
        Pasajero::$mensajeFallo = $mensajeFallo;
    }

    public function __toString(){
        $str = "
        Documento de Identidad: {$this->getPdocumento()}.\n
        Nombre: {$this->getPnombre()}.\n
        Apellido: {$this->getPapellido()}.\n
        Teléfono: {$this->getPtelefono()}.\n";
        if ($this->getObjViaje() != null) {
            $str .= "Viaje asignado:\n{$this->getObjViaje()}\n";
        }
        return $str;
    }

    public function cargarDatos($pDocumento, $pnombre, $papellido, $ptelefono,$idviaje){
        $this->setPdocumento($pDocumento);
        $this->setPnombre($pnombre);
        $this->setPapellido($papellido);
        $this->setPtelefono($ptelefono);
        $this->setObjViaje($idviaje);
    }

    public function buscar($pDocumento){
        $base = new BaseDatos();
        $consultaPasajero = "SELECT * FROM pasajero WHERE pdocumento = $pDocumento";
        $respuesta = false;

        if($base->Iniciar()){
            if($base->Ejecutar($consultaPasajero)){
                if($row = $base->Registro()){
                    $this->setPdocumento($row['pdocumento']);
                    $this->setPnombre($row['pnombre']);
                    $this->setPapellido($row['papellido']);
                    $this->setPtelefono($row['ptelefono']);
                    
                    $objViaje = new Viaje();
                    if($objViaje->buscar($row['idviaje'])){
                        $this->setObjViaje($objViaje);
                    }
                    
                    
                    $respuesta = true;
                }
            } else {
                $this->setMensajeOp($base->getError());
            }
        } else {
            $this->setMensajeOp($base->getError());
        }

        return $respuesta;
    }

    public static function listar($condicion = ''){
        $arregloPasajeros = null;
        $base = new BaseDatos();
        $consultaPasajeros = "SELECT * FROM pasajero";

        if ($condicion != '') {
            $consultaPasajeros .= " WHERE " . $condicion;
        }

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaPasajeros)) {
                $arregloPasajeros = array();
                while ($row = $base->Registro()) {
                    $pDocumento = $row['pdocumento'];
                    $pnombre = $row['pnombre'];
                    $papellido = $row['papellido'];
                    $ptelefono = $row['ptelefono'];
                    
                    $objViaje = new Viaje();
                   if( $objViaje->buscar($row['idviaje'])){
                        $pasajero = new Pasajero();
                        $pasajero->cargarDatos($pDocumento, $pnombre, $papellido, $ptelefono,$objViaje);
                        // $pasajero->setObjViaje($objViaje);
                        array_push($arregloPasajeros, $pasajero);
                   } 
                    
                }
            } else {
                Pasajero::setMensajeFallo($base->getError());
            }
        } else {
            Pasajero::setMensajeFallo($base->getError());
        }

        return $arregloPasajeros;
    }

    public function insertar(){
        $base = new BaseDatos();
        $respuesta = false;
        $consultaInsertar = "INSERT INTO pasajero (pdocumento, pnombre, papellido, ptelefono, idviaje) VALUES ({$this->getPdocumento()}, '{$this->getPnombre()}', '{$this->getPapellido()}', '{$this->getPtelefono()}', {$this->getObjViaje()->getIdviaje()})";

        if ($base->Iniciar()) {
            $idInsercion = $base->devuelveIDInsercion($consultaInsertar);
            if ($idInsercion !== null) {
                $this->setPdocumento($idInsercion);
                $respuesta = true;
            } else {
                $this->setMensajeOp($base->getError());
            }
        } else {
            $this->setMensajeOp($base->getError());
        }

        return $respuesta;
    }

    public function modificar(){
        $respuesta = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE pasajero SET pnombre = '{$this->getPnombre()}', papellido = '{$this->getPapellido()}', ptelefono = '{$this->getPtelefono()}', idviaje = {$this->getObjViaje()->getIdviaje()} WHERE pdocumento = {$this->getPdocumento()}";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaModifica)) {
                $respuesta = true;
            } else {
                $this->setMensajeOp($base->getError());
            }
        } else {
            $this->setMensajeOp($base->getError());
        }

        return $respuesta;
    }

    public function eliminar(){
        $base = new BaseDatos();
        $respuesta = false;
        $consultaElimina = "DELETE FROM pasajero WHERE pdocumento = {$this->getPdocumento()}";

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaElimina)) {
                $respuesta = true;
            } else {
                $this->setMensajeOp($base->getError());
            }
        } else {
            $this->setMensajeOp($base->getError());
        }

        return $respuesta;
    }


    function verPasajeros() {
        $p = new Pasajero;
        $pasajeros = $p->listar();
    
        if (!empty($pasajeros)) {
            echo "Lista de pasajeros:\n".
            "\n*************************************************************\n";
            foreach ($pasajeros as $pasajero) {
                echo $pasajero."\n*************************************************************\n";
            }
        } else {
            echo "No hay pasajeros registradas.\n";
        }
    }


}