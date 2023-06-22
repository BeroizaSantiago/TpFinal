<?php
require_once('BaseDatos.php');
require_once('Empresa.php');
require_once('ResponsableV.php');

class Viaje {
    private $idviaje;
    private $vdestino;
    private $vcantmaxpasajeros;
    private $idempresa; // Referencia a la clase Empresa
    private $rnumeroempleado; // Referencia a la clase ResponsableV
    private $vimporte;
    private $mensajeOp;
    private $mensajeFallo = '';

    public function __construct() {
        $this->idviaje = '';
        $this->vdestino = '';
        $this->vcantmaxpasajeros = 0;
        $this->idempresa = new Empresa();
        $this->rnumeroempleado = new ResponsableV();
        $this->vimporte = 0.0;
        $this->mensajeOp = '';
    }

    public function getIdviaje() {
        return $this->idviaje;
    }

    public function setIdviaje($idviaje) {
        $this->idviaje = $idviaje;
    }

    public function getVdestino() {
        return $this->vdestino;
    }

    public function setVdestino($vdestino) {
        $this->vdestino = $vdestino;
    }

    public function getVcantmaxpasajeros() {
        return $this->vcantmaxpasajeros;
    }

    public function setVcantmaxpasajeros($vcantmaxpasajeros) {
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function getEmpresa() {
        return $this->idempresa;
    }

    public function setEmpresa($empresa) {
        $this->idempresa = $empresa;
    }

    public function getResponsable() {
        return $this->rnumeroempleado;
    }

    public function setResponsable($responsable) {
        $this->rnumeroempleado = $responsable;
    }

    public function getVimporte() {
        return $this->vimporte;
    }

    public function setVimporte($vimporte) {
        $this->vimporte = $vimporte;
    }

    public function getMensajeOp() {
        return $this->mensajeOp;
    }

    public function setMensajeOp($mensajeOp) {
        $this->mensajeOp = $mensajeOp;
    }

    public static function getMensajeFallo() {
        return Viaje::$mensajeFallo;
    }

    public static function setMensajeFallo($mensajeFallo) {
        Viaje::$mensajeFallo = $mensajeFallo;
    }



    //toString
    public function __toString()
    {
        $str = "
        Id de Viaje: {$this->getIdviaje()}.\n
        Destino: {$this->getVdestino()}.\n
        Cantidad máxima de pasajeros: {$this->getVcantmaxpasajeros()}.\n
        Empresa: {$this->getEmpresa()}.\n
        Responsable: {$this->getResponsable()}.\n
        Importe: {$this->getVimporte()}.\n";
        return $str;
    }



    public function cargarDatos($idviaje, $vdestino, $vcantmaxpasajeros, $empresa, $responsable, $vimporte) {
        $this->setIdviaje($idviaje);
        $this->setVdestino($vdestino);
        $this->setVcantmaxpasajeros($vcantmaxpasajeros);
        $this->setEmpresa($empresa);
        $this->setResponsable($responsable);
        $this->setVimporte($vimporte);
    }

    public function buscar($idviaje) {
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM viaje WHERE idviaje = $idviaje";
        $respuesta = false;

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                if ($row = $base->Registro()) {
                    $this->setIdviaje($row['idviaje']);
                    $this->setVdestino($row['vdestino']);
                    $this->setVcantmaxpasajeros($row['vcantmaxpasajeros']);

                    // Obtener la instancia de Empresa relacionada
                    $empresa = new Empresa();
                    if ($empresa->buscar($row['idempresa'])) {
                        $this->setEmpresa($empresa);
                    }

                    // Obtener la instancia de ResponsableV relacionada
                    $responsable = new ResponsableV();
                    if ($responsable->buscar($row['rnumeroempleado'])) {
                        $this->setResponsable($responsable);
                    }

                    $this->setVimporte($row['vimporte']);
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

    public function listar($condicion = '') {
        $arregloViajes = null;
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM viaje";

        if ($condicion != '') {
            $consultaViaje .= " WHERE " . $condicion;
        }

        if ($base->Iniciar()) {
            if ($base->Ejecutar($consultaViaje)) {
                $arregloViajes = array();

                while ($row = $base->Registro()) {
                    $idviaje = $row['idviaje'];
                    $vdestino = $row['vdestino'];
                    $vcantmaxpasajeros = $row['vcantmaxpasajeros'];
                    $vimporte = $row['vimporte'];

                    // Obtener la instancia de Empresa relacionada
                    $empresa = new Empresa();
                    if ($empresa->buscar($row['idempresa'])) {
                        // Obtener la instancia de ResponsableV relacionada
                        $responsable = new ResponsableV();
                        if ($responsable->buscar($row['rnumeroempleado'])) {
                            $viaje = new Viaje();
                            $viaje->cargarDatos($idviaje, $vdestino, $vcantmaxpasajeros, $empresa, $responsable, $vimporte);
                            array_push($arregloViajes, $viaje);
                        }
                    }
                }
            } else {
                Viaje::$mensajeFallo = $base->getError();
            }
        } else {
            Viaje::$mensajeFallo = $base->getError();
        }

        return $arregloViajes;
    }

    public function insertar() {
        $base = new BaseDatos();
        $respuesta = false;
        $consultaInsertar = "INSERT INTO viaje (vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
            VALUES ('{$this->getVdestino()}', {$this->getVcantmaxpasajeros()}, {$this->getEmpresa()->getIdempresa()}, {$this->getResponsable()->getNumEmpleado()}, {$this->getVimporte()})";
    
        if ($base->Iniciar()) {
            $idInsercion = $base->devuelveIDInsercion($consultaInsertar);
            if ($idInsercion !== null) {
                $this->setIdviaje($idInsercion);
                $respuesta = true;
            } else {
                $this->setMensajeOp($base->getError());
            }
        } else {
            $this->setMensajeOp($base->getError());
        }
    
        return $respuesta;
    }

    public function modificar() {
        $respuesta = false;
        $base = new BaseDatos();
        $consultaModifica = "UPDATE viaje SET vdestino = '{$this->getVdestino()}', vcantmaxpasajeros = {$this->getVcantmaxpasajeros()}, idempresa = {$this->getEmpresa()->getIdempresa()}, rnumeroempleado = {$this->getResponsable()->getNumEmpleado()}, vimporte = {$this->getVimporte()} WHERE idviaje = {$this->getIdviaje()}";

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

    public function eliminar() {
        $base = new BaseDatos();
        $respuesta = false;
        $consultaElimina = "DELETE FROM viaje WHERE idviaje = {$this->getIdviaje()}";

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



    function verViajes() {
        $v = new Viaje;
        $viajes = $v->listar();
    
        if (!empty($viajes)) {
            echo "Lista de Viajes:\n".
            "\n*************************************************************\n";
            foreach ($viajes as $viaje) {
                echo $viaje."\n*************************************************************\n";
            }
        } else {
            echo "No hay viajes registrados.\n";
        }
    }



    
}