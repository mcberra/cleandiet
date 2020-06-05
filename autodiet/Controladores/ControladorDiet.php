<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControladorAlumno
 *
 * @author link
 */

require_once MODEL_PATH."plato.php";
require_once MODEL_PATH."producto.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once UTILITY_PATH."funciones.php";

class ControladorDiet {

     // Variable instancia para Singleton
    static private $instancia = null;
    
    // constructor--> Private por el patrón Singleton
    private function __construct() {
        //echo "Conector creado";
    }
    
    /**
     * Patrón Singleton. Ontiene una instancia del Manejador de la BD
     * @return instancia de conexion
     */
    public static function getControlador() {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDiet();
        }
        return self::$instancia;
    }
    
    /**
     * Lista el alumnado según el nombre 
     * @param type $nombre
     * 
     */
    
    
    

    public function buscarPlato($nombre){ //buscamos todos los datos de un usuario
        $bd = ControladorBD::getControlador();
        $bd->abrirBD();
        $consulta = "SELECT * FROM platos  WHERE nombre = :nombre";
        $parametros = array(':nombre' => $nombre);
        $filas = $bd->consultarBD($consulta, $parametros);
        $res = $bd->consultarBD($consulta,$parametros);
        $filas=$res->fetchAll(PDO::FETCH_OBJ);
        if (count($filas) > 0) {
            foreach ($filas as $a) {
                $plato = new plato($a->nombre, $a->ingredientes, $a->calorias, $a->glucidos, $a->proteinas, $a->grasas,  $a->porcentaje,$a->tipo,
                 $a->calorias2, $a->glucidos2, $a->proteinas2, $a->grasas2,  $a->porcentaje2,$a->tipo2, $a->id, $a->ing1, $a->ing2 );
                // Lo añadimos
            }
            $bd->cerrarBD();
            return $plato;
        }else{
            return null;
        }    
    }


}
