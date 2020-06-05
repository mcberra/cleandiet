<?php

// Incluimos los ficheros que ncesitamos
require_once $_SERVER['DOCUMENT_ROOT'] . "/autodiet/Paths.php";
require_once CONTROLLER_PATH . "ControladorAlumno.php";
require_once MODEL_PATH . "alumno.php";

require_once MODEL_PATH . "producto.php";
require_once VENDOR_PATH . "autoload.php";
use Spipu\Html2Pdf\HTML2PDF;


/**
 * Controlador de descargas
 */
class ControladorDescarga
{

    // Configuración del servidor
    private $fichero;

    // Variable instancia para Singleton
    static private $instancia = null;

    // constructor--> Private por el patrón Singleton
    private function __construct()
    {
        //echo "Conector creado";
    }

    /**
     * Patrón Singleton. Ontiene una instancia del Controlador de Descargas
     * @return instancia de conexion
     */
    public static function getControlador()
    {
        if (self::$instancia == null) {
            self::$instancia = new ControladorDescarga();
        }
        return self::$instancia;
    }

    // public function descargarTXT()
    // {
    //     $this->fichero = "item.txt";
    //     header("Content-Type: application/octet-stream");
    //     header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

    //     $controlador = Controladoritem::getControlador();
    //     $lista = $controlador->listaritems("", "");

    //     // Si hay filas (no nulo), pues mostramos la tabla
    //     if (!is_null($lista) && count($lista) > 0) {
    //         foreach ($lista as &$item) {
    //             echo "Marca: " . $item->getmarca() . " -- Modelo: " . $item->getmodelo() . "  -- Tipo: " . $item->getTipo() .
    //                 " -- Disponible: " . $item->getdisponible() . " -- Precio: " . $item->getprecio() . "\r\n";
    //         }
    //     } else {
    //         echo "No se ha encontrado datos de items";
    //     }
    // }

    // public function descargarJSON()
    // {
    //     $this->fichero = "items.json";
    //     header("Content-Type: application/octet-stream");
    //     header('Content-type: application/json');
    //     //header("Content-Disposition: attachment; filename=" . $this->fichero . ""); //archivo de salida

    //     $controlador = Controladoritem::getControlador();
    //     $lista = $controlador->listaritems("", "");
    //     $sal = [];
    //     foreach ($lista as $al) {
    //         $sal[] = $this->json_encode_private($al);
    //     }
    //     echo json_encode($sal);
    // }

    // private function json_encode_private($object)
    // {
    //     $public = [];
    //     $reflection = new ReflectionClass($object);
    //     foreach ($reflection->getProperties() as $property) {
    //         $property->setAccessible(true);
    //         $public[$property->getName()] = $property->getValue($object);
    //     }
    //     return json_encode($public);
    // }

    public function descargarXML()
    {
        $this->fichero = "Usuarios.xml";
        $lista = $controlador = ControladorAlumno::getControlador();
        $lista = $controlador->listarAlumnos("", "");
        $doc = new DOMDocument('1.0', 'UTF-8');
        $productos = $doc->createElement('usuarios');

        foreach ($lista as $a) {
            // Creamos el nodo
            $producto = $doc->createElement('item');
            // Añadimos elementos
            $producto->appendChild($doc->createElement('nombre', $a->getNombre()));
            $producto->appendChild($doc->createElement('apellido', $a->getTipo()));
            $producto->appendChild($doc->createElement('email', $a->getDistribuidor()));
            $producto->appendChild($doc->createElement('telefono', $a->getPrecio()));
            $producto->appendChild($doc->createElement('fecha', $a->getDescuento()));
            $producto->appendChild($doc->createElement('fecha', $a->getStock()));
            $producto->appendChild($doc->createElement('imagen', $a->getImagen()));

            //Insertamos
            $productos->appendChild($producto);
        }

        $doc->appendChild($productos);
        header('Content-type: application/xml');
        header("Content-Disposition: attachment; filename='Usuarios.xml'"); //archivo de salida
        echo $doc->saveXML();

        exit;
    }

    
    public function descargarPDF(){//funcion para imprimir la factura
 
        session_start();

        $sal='<div >';   
            $sal.='<h1 style="text-align:center">A U T O D I E T</h1>';
            $sal.='<h5 style="text-align:center">Dieta semanal</h5>';
            $sal.="<table border='1'>";
                $sal.="<tr>";
                    $sal.="<td><b>Lunes</b></td>";
                    $sal.="<td><b>Martes</b></td>";
                    $sal.="<td><b>Miercoles</b></td>";
                    $sal.="<td><b>Jueves</b></td>";
                    $sal.="<td><b>Viernes</b></td>";
                    $sal.="<td><b>Sabado</b></td>";
                    $sal.="<td><b>Domingo</b></td>";
                $sal.="</tr>";

                $sal.="<tr>";
                if ($_SESSION['Desayuno'] == "Desayuno") {
                    foreach ($_SESSION['array_d_pdf'] as $a ) {

                            $sal.="<td style='width:140px;'>";
                                $sal.="<b>Desayuno: </b>".$a[0]."<br><br>";
                                $sal.="Contiene <b>". $a[1] ."kc</b> de ".$a[2]." y <b>". $a[3] . "kc</b> de ".$a[4].".";
                                $sal.='<br><br>';
                                $sal.="Debe agregar <b>".$a[5]."".$a[6]."</b> de ".$a[7]." y <b>" .$a[8]."".$a[9]."</b> de ".$a[10]." a su plato.";
                                $sal.='<br><br>';
                                $sal.='<b>Macronutrientes</b><br>';
                                $sal.="Glucidos: <b>".$a[11]."</b><br>";
                                $sal.="Proteinas: <b>".$a[12]."</b><br>";
                                $sal.="Grasas: <b>".$a[13]."</b><br>";
                                $sal.="Total kc: <b>".$a[14]."</b>";
                            $sal.="</td>";

                    }
                }
                $sal.="</tr>";

                $sal.="<tr>";
                    if ($_SESSION['Tentempie'] == "Tentempie") {
                        foreach ($_SESSION['array_t_pdf'] as $a ) {
                            switch ($a[15]) {

                                    case $a[15] = 1:
                                        
                                            $sal.="<td style='width:140px;'>";
                                                $sal.="<b>Tentempie: </b>".$a[0]."<br><br>";
                                                
                                                $sal.="Contiene <b>".$a[1]."kc</b> de ".$a[2].".";//calorias del plato
                                                $sal.='<br><br>';
                                                $sal.="Debe agregar  <b>".$a[5]."".$a[6]."</b> de ".$a[2]." a su merienda.";//gramos del plato
                                                $sal.='<br><br>';
                                                $sal.='<b>Macronutrientes</b><br>';
                                                $sal.="Glucidos: <b>".$a[11]."</b><br>";
                                                $sal.= "Proteinas <b>".$a[12]."</b><br>";
                                                $sal.= "Grasas <b>".$a[13]."</b><br>";
                                                $sal.= "Total kc: <b>".$a[14]."</b>";
                                            $sal.="</td>";
                                        
                                        break;
                                    
                                    case $a[15] = 2:
                                            
                                                $sal.="<td style='width:140px;'>";
                                                    $sal.="<b>Tentempie: </b>".$a[0]."<br><br>";
                                                    $sal.="Contiene <b>". $a[1] ."kc</b> de ".$a[2]." y <b>". $a[3] . "kc</b> de ".$a[4].".";
                                                    $sal.='<br><br>';
                                                    $sal.="Debe agregar <b>".$a[5]."".$a[6]."</b> de ".$a[7]." y <b>" .$a[8]."".$a[9]."</b> de ".$a[10]." a su plato.";
                                                    $sal.='<br><br>';
                                                    $sal.='<b>Macronutrientes</b><br>';
                                                    $sal.="Glucidos: <b>".$a[11]."</b><br>";
                                                    $sal.="Proteinas: <b>".$a[12]."</b><br>";
                                                    $sal.="Grasas: <b>".$a[13]."</b><br>";
                                                    $sal.="Total kc: <b>".$a[14]."</b>";
                                                $sal.="</td>";
                                            
                                        break;
                                    
                                    default:
                                        # code...
                                        break;
                                        
                            }
                        }
                    }
                $sal.="</tr>";

                $sal.="<tr>";
                if ($_SESSION['Comida'] == "Comida") {
                    foreach ($_SESSION['array_a_pdf'] as $a ) {

                            $sal.="<td style='width:140px;'>";
                                $sal.="<b>Almuerzo: </b>".$a[0]."<br><br>";
                                $sal.="Contiene <b>". $a[1] ."kc</b> de ".$a[2]." y <b>". $a[3] . "kc</b> de ".$a[4].".";
                                $sal.='<br><br>';
                                $sal.="Debe agregar <b>".$a[5]."".$a[6]."</b> de ".$a[7]." y <b>" .$a[8]."".$a[9]."</b> de ".$a[10]." a su plato.";
                                $sal.='<br><br>';
                                $sal.='<b>Macronutrientes</b><br>';
                                $sal.="Glucidos: <b>".$a[11]."</b><br>";
                                $sal.="Proteinas: <b>".$a[12]."</b><br>";
                                $sal.="Grasas: <b>".$a[13]."</b><br>";
                                $sal.="Total kc: <b>".$a[14]."</b>";
                            $sal.="</td>";

                    }
                }
                $sal.="</tr>";

                $sal.="<tr>";
                if ($_SESSION['Merienda'] == "Merienda") {
                    foreach ($_SESSION['array_m_pdf'] as $a ) {
                        switch ($a[15]) {

                                case $a[15] = 1:
                                    
                                        $sal.="<td style='width:140px;'>";
                                            $sal.="<b>Merienda: </b>".$a[0]."<br><br>";
                                            
                                            $sal.="Contiene <b>".$a[1]."kc</b> de ".$a[2].".";//calorias del plato
                                            $sal.='<br><br>';
                                            $sal.="Debe agregar  <b>".$a[5]."".$a[6]."</b> de ".$a[2]." a su merienda.";//gramos del plato
                                            $sal.='<br><br>';
                                            $sal.='<b>Macronutrientes</b><br>';
                                            $sal.="Glucidos: <b>".$a[11]."</b><br>";
                                            $sal.= "Proteinas <b>".$a[12]."</b><br>";
                                            $sal.= "Grasas <b>".$a[13]."</b><br>";
                                            $sal.= "Total kc: <b>".$a[14]."</b>";
                                        $sal.="</td>";
                                    
                                    break;
                                
                                case $a[15] = 2:
                                        
                                            $sal.="<td style='width:140px;'>";
                                                $sal.="<b>Merienda: </b>".$a[0]."<br><br>";
                                                $sal.="Contiene <b>". $a[1] ."kc</b> de ".$a[2]." y <b>". $a[3] . "kc</b> de ".$a[4].".";
                                                $sal.='<br><br>';
                                                $sal.="Debe agregar <b>".$a[5]."".$a[6]."</b> de ".$a[7]." y <b>" .$a[8]."".$a[9]."</b> de ".$a[10]." a su plato.";
                                                $sal.='<br><br>';
                                                $sal.='<b>Macronutrientes</b><br>';
                                                $sal.="Glucidos: <b>".$a[11]."</b><br>";
                                                $sal.="Proteinas: <b>".$a[12]."</b><br>";
                                                $sal.="Grasas: <b>".$a[13]."</b><br>";
                                                $sal.="Total kc: <b>".$a[14]."</b>";
                                            $sal.="</td>";
                                        
                                    break;
                                
                                default:
                                    # code...
                                    break;
                                    
                        }
                    }
                }
                $sal.="</tr>";

                $sal.="<tr>";
                if ($_SESSION['Cena'] == "Cena") {
                    foreach ($_SESSION['array_c_pdf'] as $a ) {

                            $sal.="<td style='width:140px;'>";
                                $sal.="<b>Cena: </b>".$a[0]."<br><br>";
                                $sal.="Contiene <b>". $a[1] ."kc</b> de ".$a[2]." y <b>". $a[3] . "kc</b> de ".$a[4].".";
                                $sal.='<br><br>';
                                $sal.="Debe agregar <b>".$a[5]."".$a[6]."</b> de ".$a[7]." y <b>" .$a[8]."".$a[9]."</b> de ".$a[10]." a su plato.";
                                $sal.='<br><br>';
                                $sal.='<b>Macronutrientes</b><br>';
                                $sal.="Glucidos: <b>".$a[11]."</b><br>";
                                $sal.="Proteinas: <b>".$a[12]."</b><br>";
                                $sal.="Grasas: <b>".$a[13]."</b><br>";
                                $sal.="Total kc: <b>".$a[14]."</b>";
                            $sal.="</td>";

                    }
                }
                $sal.="</tr>";

                $sal.="<tr>";
                    foreach ($_SESSION['totales_semana'] as $a ) {

                            $sal.="<td style='width:140px;'>";

                                $sal.='<b>Totales Diarios</b><br><br>';
                                $sal.='Glucidos: <b>'.$a[0].'</b><br>';
                                $sal.='Proteinas: <b>'.$a[1].'</b><br>';
                                $sal.='Grasas: <b>'.$a[2].'</b><br>';
                                $sal.='Calorias: <b>'.$a[3].'</b><br>';

                            $sal.="</td>";

                    }
                $sal.="</tr>";

            $sal.="</table>";
        $sal.='</div>';
        
        //https://github.com/spipu/html2pdf/blob/master/doc/basic.md
        $pdf=new HTML2PDF('L','A4','es','true','UTF-8');
        $pdf->writeHTML($sal);
        $pdf->output('listado.pdf');

    }

    
}


