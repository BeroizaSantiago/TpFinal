<?php
require_once('Empresa.php');
require_once('ResponsableV.php');
require_once('Viaje.php');
require_once('Pasajero.php');


function menuPrincipal()
{
    echo "\n************ MENU PRINCIPAL ************\n";
    echo "1. Gestionar Empresa\n";
    echo "2. Gestionar Viaje\n";
    echo "3. Gestionar Responsable\n";
    echo "4. Gestionar Pasajero\n";
    echo "5. Salir\n";
    echo "*****************************************\n";
    echo "Ingrese una opción: ";

    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case '1':
            // Opción para gestionar la empresa
            menuEmpresa();
            break;
        case '2':
            // Opción para gestionar el viaje
            menuViaje();
            break;
        case '3':
            // Opción para gestionar el responsable
            menuResponsable();
            break;
        case '4':
            // Opción para gestionar el pasajero
            menuPasajero();
            break;
        case '5':
            // Salir del programa
            echo "¡Hasta luego!\n";
            break;
        default:
            echo "Opción inválida. Por favor, ingrese una opción válida.\n";
            menuPrincipal();
            break;
    }
}



function menuEmpresa()
{
   
        echo "\n************ MENU EMPRESA ************\n";
        echo "1. Ingresar Empresa\n";
        echo "2. Modificar Empresa\n";
        echo "3. Eliminar Empresa\n";
        echo "4. Listar Empresa\n";
        echo "5. Volver al Menú Principal\n";
        echo "*****************************************\n";
        echo "Ingrese una opción: ";

        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case '1':                                
                // Cargar Empresa
                cargarEmpresa();
                break;
            case '2':
                // Modificar Empresa
                modificarEmpresa();
                break;
            case '3':
                // Eliminar Empresa
                eliminarEmpresa();
                break;
            case '4':
                // Listar Empresa
                $empresa = new Empresa();
                $empresa->verEmpresas() ;
            case '5':
                // Volver al Menú Principal
                echo "Volviendo al Menú Principal...\n";
                menuPrincipal(); 
                return;
            default:
                echo "Opción inválida. Por favor, ingrese una opción válida.\n";
                menuEmpresa();
                break;
            }
    
}

function menuViaje()
{
    
        echo "\n************ MENU VIAJE ************\n";
        echo "1. Ingresar Viaje\n";
        echo "2. Modificar Viaje\n";
        echo "3. Eliminar Viaje\n";
        echo "4. Listar Viajes\n";
        echo "5. Volver al Menú Principal\n";
        echo "*****************************************\n";
        echo "Ingrese una opción: ";

        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case '1':
                // Cargar Viaje
                cargarViaje();
                break;
            case '2':
                // Modificar Viaje
                modificarViaje();
                break;
            case '3':
                // Eliminar Viaje
                eliminarViaje();
                break;
            case '4':
                // Listar Viajes
                $viajeLis = new Viaje();
                $viajeLis->verViajes();
            case '5':
                // Volver al Menú Principal
                echo "Volviendo al Menú Principal...\n";
                menuPrincipal();
                return;
            default:
                echo "Opción inválida. Por favor, ingrese una opción válida.\n";
                menuViaje();
                break;
        }
    
}

function menuResponsable()
{
    
        echo "\n************ MENU RESPONSABLE ************\n";
        echo "1. Cargar Responsable\n";
        echo "2. Modificar Responsable\n";
        echo "3. Eliminar Responsable\n";
        echo "4. Listar Responsable\n";
        echo "5. Volver al Menú Principal\n";
        echo "*****************************************\n";
        echo "Ingrese una opción: ";
        
        $opcion = trim(fgets(STDIN));
        
        switch ($opcion) {
            case '1':
                // Cargar Responsable
                cargarResponsable();
                break;
            case '2':
                // Modificar Responsable
                modificarResponsable();
                break;
            case '3':
                // Eliminar Responsable
                eliminarResponsable();
                break;
            case '4':
                // Listar Responsables
                $responsableLis = new ResponsableV();
                $responsableLis->verResponsables();
            case '5':
                // Volver al Menú Principal
                echo "Volviendo al Menú Principal...\n";
                menuPrincipal();
                return;
            default:
                echo "Opción inválida. Por favor, ingrese una opción válida.\n";
                menuResponsable();
                break;
        }
    
}

function menuPasajero()
{
        echo "\n************ MENU PASAJERO ************\n";
        echo "1. Cargar Pasajero\n";
        echo "2. Modificar Pasajero\n";
        echo "3. Eliminar Pasajero\n";
        echo "4. Listar Pasajeros\n";
        echo "5. Volver al Menú Principal\n";
        echo "*****************************************\n";
        echo "Ingrese una opción: ";

        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            case '1':
                // Cargar Pasajero
                cargarPasajero();
                break;
            case '2':
                // Modificar Pasajero
                modificarPasajero();
                break;
            case '3':
                // Eliminar Pasajero
                eliminarPasajero();
                break;
            case '4':
                // Listar Pasjaeros
                $pasajeroLis = new Pasajero();
                $pasajeroLis->verPasajeros();
            case '5':
                // Volver al Menú Principal
                echo "Volviendo al Menú Principal...\n";
                menuPrincipal();    
                return;
            default:
                echo "Opción inválida. Por favor, ingrese una opción válida.\n";
                menuPasajero();
                break;
        }
    
}


function cargarEmpresa()
{
    $empresa = new Empresa();
    echo "Ingrese el nombre de la empresa: ";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese la dirección de la empresa: ";
    $direccion = trim(fgets(STDIN));

    $empresa->cargarDatos('', $nombre, $direccion);
    $empresa->insertar();

    echo "Empresa ingresada exitosamente.\n";
}


function modificarEmpresa()
{
    $empresa = new Empresa();
    echo $empresa->verEmpresas();
    echo "Ingrese el ID de la empresa a modificar: ";
    $id = trim(fgets(STDIN));

    if ($empresa->buscar($id)) {
        echo "Empresa encontrada:\n";
        echo $empresa;

        echo "Ingrese el nuevo nombre de la empresa: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese la nueva dirección de la empresa: ";
        $direccion = trim(fgets(STDIN));

        $empresa->setNombre($nombre);
        $empresa->setEdireccion($direccion);
        $empresa->modificar();

        echo "Empresa modificada exitosamente.\n";
    } else {
        echo "No se encontró una empresa con el ID proporcionado.\n";
    }
}


function eliminarEmpresa()
{
    echo "Ingrese el ID de la empresa a eliminar: ";
    $id = trim(fgets(STDIN));

    $empresa = new Empresa();
    if ($empresa->buscar($id)) {
        echo "Empresa encontrada:\n";
        echo $empresa;

        echo "¿Está seguro de que desea eliminar esta empresa? (s/n): ";
        $confirmacion = trim(fgets(STDIN));

        if (strtolower($confirmacion) === 's') {
            $empresa->eliminar();
            echo "Empresa eliminada exitosamente.\n";
        } else {
            echo "Operación cancelada. La empresa no ha sido eliminada.\n";
        }
    } else {
        echo "No se encontró una empresa con el ID proporcionado.\n";
    }
}


function cargarViaje()
{
    $viaje = new Viaje();
    echo "Ingrese el destino del viaje: ";
    $destinoViaje = trim(fgets(STDIN));
    echo "Ingrese la cantidad máxima de pasajeros: ";
    $cantMaxPasajeros = trim(fgets(STDIN));

    // Crear objeto Empresa y asignar sus atributos
    $empresa = new Empresa();
    echo "Ingrese el ID de la empresa del viaje: ";
    $idEmpresa = trim(fgets(STDIN));
    //  Buscar y cargar los datos de la empresa
    $empresa->buscar($idEmpresa);

    // Crear objeto Responsable y asignar sus atributos
    $responsable = new ResponsableV();
    echo "Ingrese el ID del responsable del viaje: ";
    $idResponsable = trim(fgets(STDIN));
    // Verificar y cargar los datos del responsable
    if ($responsable->buscar($idResponsable)) {
        echo "Responsable encontrado, Carga Fallida.\n";

        echo "Ingrese el importe del viaje: ";
        $importeViaje = trim(fgets(STDIN));

        $viaje->cargarDatos('', $destinoViaje, $cantMaxPasajeros, $empresa, $responsable, $importeViaje);
        $viaje->insertar();

        echo "Viaje ingresado exitosamente.\n";
    } else {
        echo "Responsable no encontrado.\n";
    }
    menuViaje();
}


function modificarViaje()
{   $viaje = new Viaje();
    echo $viaje->verViajes();
    echo "Ingrese el ID del viaje a modificar: ";
    $idViaje = trim(fgets(STDIN));

    
    if ($viaje->buscar($idViaje)) {
        echo "Viaje encontrado:\n";
        echo $viaje;

        echo "Ingrese el nuevo destino del viaje: ";
        $destinoViaje = trim(fgets(STDIN));
        echo "Ingrese la nueva cantidad máxima de pasajeros: ";
        $cantMaxPasajeros = trim(fgets(STDIN));

        // Crear objeto Empresa y asignar sus atributos
        $empresa = new Empresa();
        echo "Ingrese el nuevo ID de la empresa del viaje: ";
        $idEmpresa = trim(fgets(STDIN));
        // Buscar y cargar los datos de la empresa
        $empresa->buscar($idEmpresa);

        // Crear objeto Responsable y asignar sus atributos
        $responsable = new ResponsableV();
        echo "Ingrese el nuevo ID del responsable del viaje: ";
        $idResponsable = trim(fgets(STDIN));
        // Buscar y cargar los datos del responsable
        $responsable->buscar($idResponsable);

        echo "Ingrese el nuevo importe del viaje: ";
        $importeViaje = trim(fgets(STDIN));

        $viaje->getVdestino($destinoViaje);
        $viaje->setVcantMaxPasajeros($cantMaxPasajeros);
        $viaje->setEmpresa($empresa);
        $viaje->setResponsable($responsable);
        $viaje->setVimporte($importeViaje);
        $viaje->modificar();

        echo "Viaje modificado exitosamente.\n";
    } else {
        echo "No se encontró un viaje con el ID proporcionado.\n";
    }
}


function eliminarViaje()
{
    echo "Ingrese el ID del viaje a eliminar: ";
    $id = trim(fgets(STDIN));

    $viaje = new Viaje();
    if ($viaje->buscar($id)) {
        echo "Viaje encontrado:\n";
        echo $viaje;

        echo "¿Está seguro de que desea eliminar este viaje? (s/n): ";
        $confirmacion = trim(fgets(STDIN));

        if (strtolower($confirmacion) === 's') {
            $viaje->eliminar();
            echo "Viaje eliminado exitosamente.\n";
        } else {
            echo "Operación cancelada. El viaje no ha sido eliminado.\n";
        }
    } else {
        echo "No se encontró un viaje con el ID proporcionado.\n";
    }
}


function cargarResponsable()
{
    $responsable = new ResponsableV();
    echo "Ingrese el número de empleado: ";
    $numEmpleado = trim(fgets(STDIN));
    echo "Ingrese el número de licencia: ";
    $numLicencia = trim(fgets(STDIN));
    echo "Ingrese el nombre: ";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese el apellido: ";
    $apellido = trim(fgets(STDIN));

    $responsable->cargarDatos($numEmpleado, $numLicencia, $nombre, $apellido);
    $responsable->insertar();

    echo "Responsable cargado exitosamente.\n";
}


function modificarResponsable()
{
    $responsable = new ResponsableV();
    echo $responsable->verResponsables();
    echo "Ingrese el número de empleado del responsable a modificar: ";
    $numEmpleado = trim(fgets(STDIN));

    
    if ($responsable->buscar($numEmpleado)) {
        echo "Responsable encontrado:\n";
        echo $responsable;

        echo "Ingrese el nuevo número de licencia: ";
        $numLicencia = trim(fgets(STDIN));
        echo "Ingrese el nuevo nombre: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el nuevo apellido: ";
        $apellido = trim(fgets(STDIN));

        $responsable->setNumLicencia($numLicencia);
        $responsable->setNombre($nombre);
        $responsable->setApellido($apellido);
        $responsable->modificar();

        echo "Responsable modificado exitosamente.\n";
    } else {
        echo "No se encontró un responsable con el número de empleado proporcionado.\n";
    }
}


function eliminarResponsable()
{
    echo "Ingrese el número de empleado del responsable a eliminar: ";
    $numEmpleado = trim(fgets(STDIN));

    $responsable = new ResponsableV();
    if ($responsable->buscar($numEmpleado)) {
        echo "Responsable encontrado:\n";
        echo $responsable;

        echo "¿Está seguro de eliminar este responsable? (s/n): ";
        $confirmacion = trim(fgets(STDIN));

        if (strtolower($confirmacion) === 's') {
            $responsable->eliminar();
            echo "Responsable eliminado exitosamente.\n";
        } else {
            echo "Operación cancelada. El responsable no ha sido eliminado.\n";
        }
    } else {
        echo "No se encontró un responsable con el número de empleado proporcionado.\n";
    }
}

function cargarPasajero()
{
    $pasajero = new Pasajero();
    echo "Ingrese el documento del pasajero: ";
    $documento = trim(fgets(STDIN));

    // Verificar si el pasajero ya existe
    if ($pasajero->buscar($documento)) {
        echo "El pasajero ya existe. No se puede cargar nuevamente.\n";
        return;
    }

    echo "Ingrese el nombre del pasajero: ";
    $nombre = trim(fgets(STDIN));
    echo "Ingrese el apellido del pasajero: ";
    $apellido = trim(fgets(STDIN));
    echo "Ingrese el teléfono del pasajero: ";
    $telefono = trim(fgets(STDIN));

    $viaje = new Viaje();
    echo "Ingrese el ID del viaje al que pertenece el pasajero: ";
    $idViaje = trim(fgets(STDIN));
    $viaje->buscar($idViaje);

    $pasajero->cargarDatos($documento, $nombre, $apellido, $telefono, $viaje);
    $pasajero->insertar();

    echo "Pasajero cargado exitosamente.\n";
}



function modificarPasajero()
{

    $pasajero = new Pasajero();
    echo $pasajero->verPasajeros();
    echo "Ingrese el documento del pasajero a modificar: ";
    $documento = trim(fgets(STDIN));

    
    if ($pasajero->buscar($documento)) {
        echo "Pasajero encontrado:\n";
        echo $pasajero;

        echo "Ingrese el nuevo nombre del pasajero: ";
        $nombre = trim(fgets(STDIN));
        echo "Ingrese el nuevo apellido del pasajero: ";
        $apellido = trim(fgets(STDIN));
        echo "Ingrese el nuevo teléfono del pasajero: ";
        $telefono = trim(fgets(STDIN));
        echo "Ingrese el nuevo ID del viaje al que pertenece el pasajero: ";
        $idViaje = trim(fgets(STDIN));

        $pasajero->setPnombre($nombre);
        $pasajero->setPapellido($apellido);
        $pasajero->setPtelefono($telefono);
        $objViaje= new Viaje();
        $objViaje->buscar($idViaje);
        $pasajero->setObjViaje($objViaje);
        $pasajero->modificar();

        echo "Pasajero modificado exitosamente.\n";
    } else {
        echo "No se encontró un pasajero con el documento proporcionado.\n";
    }
}

function eliminarPasajero()
{
    echo "Ingrese el documento del pasajero a eliminar: ";
    $documento = trim(fgets(STDIN));

    $pasajero = new Pasajero();
    if ($pasajero->buscar($documento)) {
        echo "Pasajero encontrado:\n";
        echo $pasajero;

        echo "¿Está seguro de eliminar este pasajero? (s/n): ";
        $confirmacion = trim(fgets(STDIN));

        if (strtolower($confirmacion) === 's') {
            $pasajero->eliminar();

            echo "Pasajero eliminado exitosamente.\n";
        } else {
            echo "Operación cancelada. El pasajero no ha sido eliminado.\n";
        }
    } else {
        echo "No se encontró un pasajero con el documento proporcionado.\n";
    }
}

// Llamada al menú principal
menuPrincipal();

?>
