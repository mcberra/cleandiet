<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Alumno
 *
 * @author link
 */
class plato {
    //put your code here
    
    private $nombre;
    private $ingredientes;
    private $calorias;
    private $glucidos;
    private $proteinas;
    private $grasas;
    private $porcentaje;
    private $tipo;
    private $calorias2;
    private $glucidos2;
    private $proteinas2;
    private $grasas2;
    private $porcentaje2;
    private $tipo2;
    private $id;
    private $ing1;
    private $ing2;


    
    // Constructor
    public function __construct($nombre, $ingredientes, $calorias, 
    $glucidos,$proteinas, $grasas, $porcentaje,$tipo, $calorias2, $glucidos2 ,$proteinas2, $grasas2, $porcentaje2, $tipo2, $id, $ing1, 
    $ing2) {

        
        $this->nombre = $nombre;
        $this->ingredientes = $ingredientes;
        $this->calorias = $calorias;
        $this->glucidos = $glucidos;
        $this->proteinas = $proteinas;
        $this->grasas = $grasas;
        $this->porcentaje = $porcentaje;
        $this->tipo = $tipo;
        $this->calorias2 = $calorias2;
        $this->glucidos2 = $glucidos2;
        $this->proteinas2 = $proteinas2;
        $this->grasas2 = $grasas2;
        $this->porcentaje2 = $porcentaje2;
        $this->tipo2 = $tipo2;
        $this->id = $id;
        $this->ing1 = $ing1;
        $this->ing2 = $ing2;


    }
    
    // **** GETS 

    function getingredientes() {
        return $this->ingredientes;
    }

    
    function getcalorias() {
        return $this->calorias;
    }

    function getglucidos() {
        return $this->glucidos;
    }

    function getproteinas() {
        return $this->proteinas;
    }

    function getgrasas() {
        return $this->grasas;
    }

    function gettipo() {
        return $this->tipo;
    }


    function getcalorias2() {
        return $this->calorias2;
    }

    function getglucidos2() {
        return $this->glucidos2;
    }


    function getproteinas2() {
        return $this->proteinas2;
    }

    
    function getgrasas2() {
        return $this->grasas2;
    }

    function getporcentaje2() {
        return $this->porcentaje2;
    }

    function gettipo2() {
        return $this->tipo2;
    }

    function getId() {
        return $this->id;
    }

    function geting1() {
        return $this->ing1;
    }

    function geting2() {
        return $this->ing2;
    }
    

// **** SETS

    function setingredientes($ingredientes) {
        $this->ingredientes = $ingredientes;
    }

    function setcalorias($calorias) {
        $this->calorias = $calorias;
    }
    
    function setglucidos($glucidos) {
        $this->glucidos =$glucidos;
    } 

    function setproteinas($proteinas) {
        $this->proteinas= $proteinas;
    } 

    function setgrasas($grasas) {
        $this->grasas= $grasas;
    } 

    function settipo($tipo) {
        $this->tipo= $tipo;
    } 


    function setcalorias2($calorias2) {
        $this->calorias2= $calorias2;
    } 

    function setglucidos2($glucidos2) {
        $this->glucidos2 = $glucidos2;
    }


    function setproteinas2($proteinas2) {
        $this->proteinas2 = $proteinas2;
    }

    function setgrasas2($grasas2) {
        $this->grasas2 = $grasas2;
    }
    
    function setporcentaje2($porcentaje2) {
        $this->porcentaje2 =$porcentaje2;
    } 

    function settipo2($tipo2) {
        $this->tipo2= $tipo2;
    } 

   
    function setId($id) {
        $this->id = $id;
    }

    function seting1($ing1) {
        $this->ing1 = $ing1;
    }

    function seting2($ing2) {
        $this->ing2 = $ing2;
    }
 
}
