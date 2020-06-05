
<?php

require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! 
require_once VIEW_PATH."header.php"; 
require_once CONTROLLER_PATH."ControladorBD.php";
require_once CONTROLLER_PATH."ControladorDiet.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once UTILITY_PATH."funciones.php"; 

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if ($_SESSION['paso1'] != "completada"  || $_SESSION['paso2'] != "completada" || $_SESSION['paso3'] != "completada" || $_SESSION['paso4'] != "completada") {
    header("location: paso1.php");
}

if (!empty($_SESSION['Desayunos'])) {
    $desayunos_semanales = 0;
}else {
    $desayunos_semanales = 8;
}

if (!empty($_SESSION['Tentempies'])) {
    $Tentempie_semanales = 0;
}else {
    $Tentempie_semanales = 8;
}

if (!empty($_SESSION['Almuerzos'])) {
    $almuerzos_semanales = 0;
}else {
    $almuerzos_semanales = 8;
}

if (!empty($_SESSION['Meriendas'])) {
    $Meriendas_semanales = 0;
}else {
    $Meriendas_semanales = 8;
}

if (!empty($_SESSION['Cenas'])) {
    $Cena_semanales = 0;
}else {
    $Cena_semanales = 8;
}

$glucidos_desayuno= [];
$glucidos_tentempie= [];
$glucidos_almuerzo= [];
$glucidos_merienda= [];
$glucidos_cena= [];
$proteinas_desayuno = [];
$proteinas_tentempie = [];
$proteinas_almuerzo = [];
$proteinas_merienda = [];
$proteinas_cena = [];
$grasas_desayuno = [];
$grasas_tentempie = [];
$grasas_almuerzo = [];
$grasas_merienda = [];
$grasas_cena = [];
$calorias_totales_dia  = [];


$_SESSION['array_d_pdf'] = [];
$_SESSION['array_t_pdf'] = [];
$_SESSION['array_a_pdf'] = [];
$_SESSION['array_m_pdf'] = [];
$_SESSION['array_c_pdf'] = [];



echo '<h1 style="text-align:center;margin-top:50px;margin-bottom:25px;font-size:60px;">Dieta semanal</h1>';

echo '<div style="margin: auto;width:500px;">';
    echo '<h5 style="text-align:center;;">Pasos completados con exito!</h5>';
    echo '<div class="progress">';
        echo '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>';
    echo '</div>';
echo '</div>';

echo '<p style="text-align:center">';
    echo '<a href="/autodiet/utilidades/descargar.php?opcion=PDF" target="_blank" style="text-decoration:none" class="btn btn-danger" > Imprimir en PDF</a>';
    echo '<a href="/autodiet/Vistas/paso5.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>';
echo '</p>';

echo '<div class="tabla">';
echo '<table >';
echo '<thead>';
echo '<tr class="head">';
    echo '<th>Lunes</th>';
    echo '<th>Martes</th>';
    echo '<th>Miercoles</th>';
    echo '<th>Jueves</th>';
    echo '<th>Viernes</th>';
    echo '<th>Sabado</th>';
    echo '<th>Domingo</th>';
echo '</tr>';
echo '</thead>';
echo '<tr >';
while ($desayunos_semanales < 7) {
    $items_array = count($_SESSION['Desayunos']);
    $items_array = $items_array - 1;
    echo '<td>';
    //print_r($_SESSION['Desayunos'][rand(0,$items_array )]);//nombre del plato

    $nombre = $_SESSION['Desayunos'][rand(0,$items_array )];
    
    

    
    
    
    $controlador = ControladorDiet::getControlador();
    $plato = $controlador->buscarPlato($nombre);//usamos esta funcion para buscar en la BBDD el producto y sus datos

    //print_r($plato);

    if (!is_array($plato )) { //este if es necesario para que no intente convertir un objeto en un array en cada vuelta del bucle,despues de la primera iteracion ya es un array.
        $temp_plato = objectToArray ( $plato );
        //echo "es un array";
    }else {
        $temp_plato =   $plato;
        //echo "no es un array";
    }

     //print_r($temp_plato);

    $datos_alimentos = [];
    foreach ($temp_plato as $a) {//aunque el array ya no es un objeto, es un array asociativo con nombres extensos, con esto lo convierto en un array de indice numerico.
        $a = array_shift($temp_plato);
    
        array_push($datos_alimentos,$a);

    }
    // print_r($datos_alimentos);
    print_r("<b>Desayuno: </b>".$datos_alimentos[0]."</b>");

    // $datos_alimentos = array(1,389,66.3,16.9,6.9,100,"g");
    //$datos_alimentos = array(2,389,66.3,16.9,6.9,90,"g",42,4.7,3.1,3.8,10,"ml");

    switch ($datos_alimentos[1]) {
        case $datos_alimentos[1] = 1 :

            $calorias_desayuno = $_SESSION['porcentaje_Desayuno'] * $_SESSION['calorias_diarias']/100;

            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $vueltas= 0;
        
            while ($calorias_1gramo < $calorias_desayuno ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;

            $gl=$glucidos;
            $p=$proteinas;
            $gr=$grasas;

            
            echo '<br>';
            print_r("calorias aproximadas: ".$calorias_1gramo);//calorias del plato
            echo '<br>';
            print_r("Gramos necesarios ".$gramo);//gramos del plato
            echo '<br>';
            echo 'Macronutrientes<br>';
            echo "Carbohidratos ".$gl."<br>";
            echo "Proteinas ".$p."<br>";
            echo "Grasas ".$gr."<br>";
            echo '<br><br>';
            $comidas_semanales=$comidas_semanales + 1;

            break;

        case $datos_alimentos[1] = 2 :
            
            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Desayuno'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_1 = $calorias_desayuno*$datos_alimentos[6]/100;
            $vueltas= 0;

            while ($calorias_1gramo < $calorias_desayuno_1 ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;


            $calorias_1gramo1 = $datos_alimentos[8]/1000;
            $gramo1 = 0.10;
            $valor_1gramo_calorias1 = $datos_alimentos[8]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Desayuno'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_2 = $calorias_desayuno*$datos_alimentos[12]/100;
            $vueltas1= 0;

            while ($calorias_1gramo1 < $calorias_desayuno_2 ) {
                $calorias_1gramo1 = $calorias_1gramo1 + $valor_1gramo_calorias1;
                $gramo1 = $gramo1 + $valor_1gramo;
                $vueltas1= $vueltas1 + 1;
            }
            
            $glucidos1 = $datos_alimentos[9]/1000*$vueltas1;
            $proteinas1 = $datos_alimentos[10]/1000*$vueltas1;
            $grasas1 = $datos_alimentos[11]/1000*$vueltas1;

            $gl=$glucidos + $glucidos1;
            $p=$proteinas + $proteinas1;
            $gr=$grasas + $grasas1;

            array_push($glucidos_desayuno, $gl);
            array_push($proteinas_desayuno, $p);
            array_push($grasas_desayuno, $gr);

            

            echo '<br><br>';
            echo "Contiene ". round($calorias_1gramo) ."kc de ".$datos_alimentos[15]." y ". round($calorias_1gramo1) . "kc de ".$datos_alimentos[16]."." ;
            echo '<br>';
            echo "Debe agregar ".round($gramo,0)."".$datos_alimentos[7]." de ".$datos_alimentos[15]." y " .round($gramo1,0)."".$datos_alimentos[13]." de ".$datos_alimentos[16]." a su plato.";
            echo '<br><br>';
            echo '<b>Macronutrientes</b><br>';
            echo "Glucidos: <span class='badge badge-primary'>".round($gl,1)."</span><br>";
            echo "Proteinas: <span class='badge badge-primary'>".round($p,1)."</span><br>";
            echo "Grasas: <span class='badge badge-primary'>".round($gr,1)."</span><br>";
            echo "Total kc: <span class='badge badge-success'>".round($calorias_desayuno,1)."</span>";
            
            

            

            $_SESSION['num_d'] = $datos_alimentos[1];
            

            $desayunos_semanales=$desayunos_semanales + 1;
            break;
        
        default:
            # code...
            break;
    }
    echo '</td>';
    $_SESSION['Desayunos_pdf'] = [];
    array_push($_SESSION['Desayunos_pdf'],$nombre);
    array_push($_SESSION['Desayunos_pdf'],round($calorias_1gramo));
    array_push($_SESSION['Desayunos_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['Desayunos_pdf'],round($calorias_1gramo1));
    array_push($_SESSION['Desayunos_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['Desayunos_pdf'],round($gramo,0));
    array_push($_SESSION['Desayunos_pdf'],$datos_alimentos[7]);
    array_push($_SESSION['Desayunos_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['Desayunos_pdf'],round($gramo1,0));
    array_push($_SESSION['Desayunos_pdf'],$datos_alimentos[13]);
    array_push($_SESSION['Desayunos_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['Desayunos_pdf'],round($gl,1));
    array_push($_SESSION['Desayunos_pdf'],round($p,1));
    array_push($_SESSION['Desayunos_pdf'],round($gr,1));
    array_push($_SESSION['Desayunos_pdf'],round($calorias_desayuno,1));
    array_push($_SESSION['Desayunos_pdf'],$_SESSION['num_d']);
    array_push($_SESSION['array_d_pdf'],$_SESSION['Desayunos_pdf']);
    
    
    
}

// print_r($_SESSION['array_d_pdf']);

echo '</tr>';


echo '<tr >';
while ($Tentempie_semanales < 7) {
    $items_array = count($_SESSION['Tentempies']);
    $items_array = $items_array - 1;
    echo '<td>';
    //print_r($_SESSION['Desayunos'][rand(0,$items_array )]);//nombre del plato

    $nombre = $_SESSION['Tentempies'][rand(0,$items_array )];
    
    $controlador = ControladorDiet::getControlador();
    $plato = $controlador->buscarPlato($nombre);//usamos esta funcion para buscar en la BBDD el producto y sus datos

    //print_r($plato);

    if (!is_array($plato )) { //este if es necesario para que no intente convertir un objeto en un array en cada vuelta del bucle,despues de la primera iteracion ya es un array.
        $temp_plato = objectToArray ( $plato );
        //echo "es un array";
    }else {
        $temp_plato =   $plato;
        //echo "no es un array";
    }

     //print_r($temp_stock);

    $datos_alimentos = [];
    foreach ($temp_plato as $a) {//aunque el array ya no es un objeto, es un array asociativo con nombres extensos, con esto lo convierto en un array de indice numerico.
        $a = array_shift($temp_plato);
    
        array_push($datos_alimentos,$a);
    }

    print_r("<b>Tentempie: </br>".$datos_alimentos[0]."</>");

    // $datos_alimentos = array(1,389,66.3,16.9,6.9,100,"g");
    //$datos_alimentos = array(2,389,66.3,16.9,6.9,90,"g",42,4.7,3.1,3.8,10,"ml");

    switch ($datos_alimentos[1]) {
        case $datos_alimentos[1] = 1 :

            $calorias_desayuno = $_SESSION['porcentaje_Tentempie'] * $_SESSION['calorias_diarias']/100;

            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $vueltas= 0;
        
            while ($calorias_1gramo < $calorias_desayuno ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;

            $gl=$glucidos;
            $p=$proteinas;
            $gr=$grasas;

            array_push($glucidos_tentempie, $gl);
            array_push($proteinas_tentempie, $p);
            array_push($grasas_tentempie, $gr);

            
            echo '<br><br>';
            print_r("Contiene ".round($calorias_1gramo,1)."kc de ".$datos_alimentos[15].".");//calorias del plato
            echo '<br>';
            print_r("Debe agregar  ".round($gramo,1)."".$datos_alimentos[7]." de ".$datos_alimentos[15]." a su merienda.");//gramos del plato
            echo '<br><br>';
            echo '<b>Macronutrientes</b><br>';
            echo "Glucidos: <span class='badge badge-primary'>".round($gl,1)."</span><br>";
            echo "Proteinas <span class='badge badge-primary'>".round($p,1)."</span><br>";
            echo "Grasas <span class='badge badge-primary'>".round($gr,1)."</span><br>";
            echo "Total kc: <span class='badge badge-success'>".round($calorias_desayuno,1)."</span>";

            $Tentempie_semanales=$Tentempie_semanales + 1;
            $_SESSION['num_t'] = $datos_alimentos[1];

            break;

        case $datos_alimentos[1] = 2 :
            
            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Tentempie'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_1 = $calorias_desayuno*$datos_alimentos[6]/100;
            $vueltas= 0;

            while ($calorias_1gramo < $calorias_desayuno_1 ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;


            $calorias_1gramo1 = $datos_alimentos[8]/1000;
            $gramo1 = 0.10;
            $valor_1gramo_calorias1 = $datos_alimentos[8]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Tentempie'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_2 = $calorias_desayuno*$datos_alimentos[12]/100;
            $vueltas1= 0;

            while ($calorias_1gramo1 < $calorias_desayuno_2 ) {
                $calorias_1gramo1 = $calorias_1gramo1 + $valor_1gramo_calorias1;
                $gramo1 = $gramo1 + $valor_1gramo;
                $vueltas1= $vueltas1 + 1;
            }
            
            $glucidos1 = $datos_alimentos[9]/1000*$vueltas1;
            $proteinas1 = $datos_alimentos[10]/1000*$vueltas1;
            $grasas1 = $datos_alimentos[11]/1000*$vueltas1;

            $gl=$glucidos + $glucidos1;
            $p=$proteinas + $proteinas1;
            $gr=$grasas + $grasas1;

            array_push($glucidos_tentempie, $gl);
            array_push($proteinas_tentempie, $p);
            array_push($grasas_tentempie, $gr);

            

            echo '<br><br>';
            echo "Contiene ". round($calorias_1gramo) ."kc de ".$datos_alimentos[15]." y ". round($calorias_1gramo1) . "kc de ".$datos_alimentos[16]."." ;
            echo '<br>';
            echo "Debe agregar ".round($gramo,0)."".$datos_alimentos[7]." de ".$datos_alimentos[15]." y " .round($gramo1,0)."".$datos_alimentos[13]." de ".$datos_alimentos[16]." a su plato.";
            echo '<br><br>';
            echo '<b>Macronutrientes</b><br>';
            echo "Glucidos: <span class='badge badge-primary'>".round($gl,1)."</span><br>";
            echo "Proteinas: <span class='badge badge-primary'>".round($p,1)."</span><br>";
            echo "Grasas: <span class='badge badge-primary'>".round($gr,1)."</span><br>";
            echo "Total kc: <span class='badge badge-success'>".round($calorias_desayuno,1)."</span>";
            

            
            


            $Tentempie_semanales=$Tentempie_semanales + 1;
            $_SESSION['num_t'] = $datos_alimentos[1];
            break;
        
        default:
            # code...
            break;
    }
    echo '</td>';

    $_SESSION['tentempies_pdf'] = [];
    array_push($_SESSION['tentempies_pdf'],$nombre);
    array_push($_SESSION['tentempies_pdf'],round($calorias_1gramo));
    array_push($_SESSION['tentempies_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['tentempies_pdf'],round($calorias_1gramo1));
    array_push($_SESSION['tentempies_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['tentempies_pdf'],round($gramo,0));
    array_push($_SESSION['tentempies_pdf'],$datos_alimentos[7]);
    array_push($_SESSION['tentempies_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['tentempies_pdf'],round($gramo1,0));
    array_push($_SESSION['tentempies_pdf'],$datos_alimentos[13]);
    array_push($_SESSION['tentempies_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['tentempies_pdf'],round($gl,1));
    array_push($_SESSION['tentempies_pdf'],round($p,1));
    array_push($_SESSION['tentempies_pdf'],round($gr,1));
    array_push($_SESSION['tentempies_pdf'],round($calorias_desayuno,1));
    array_push($_SESSION['tentempies_pdf'],$_SESSION['num_t']);
    array_push($_SESSION['array_t_pdf'],$_SESSION['tentempies_pdf']);

}
// print_r($_SESSION['array_t_pdf']);
echo '</tr>';

echo '<tr >';
while ($almuerzos_semanales < 7) {
    $items_array = count($_SESSION['Almuerzos']);
    $items_array = $items_array - 1;
    echo '<td>';
    //print_r($_SESSION['Desayunos'][rand(0,$items_array )]);//nombre del plato

    $nombre = $_SESSION['Almuerzos'][rand(0,$items_array )];
    
    $controlador = ControladorDiet::getControlador();
    $plato = $controlador->buscarPlato($nombre);//usamos esta funcion para buscar en la BBDD el producto y sus datos

    //print_r($plato);

    if (!is_array($plato )) { //este if es necesario para que no intente convertir un objeto en un array en cada vuelta del bucle,despues de la primera iteracion ya es un array.
        $temp_plato = objectToArray ( $plato );
        //echo "es un array";
    }else {
        $temp_plato =   $plato;
        //echo "no es un array";
    }

     //print_r($temp_stock);

    $datos_alimentos = [];
    foreach ($temp_plato as $a) {//aunque el array ya no es un objeto, es un array asociativo con nombres extensos, con esto lo convierto en un array de indice numerico.
        $a = array_shift($temp_plato);
    
        array_push($datos_alimentos,$a);
    }

    print_r("<b>Almuerzo: </b>".$datos_alimentos[0]."");

    // $datos_alimentos = array(1,389,66.3,16.9,6.9,100,"g");
    //$datos_alimentos = array(2,389,66.3,16.9,6.9,90,"g",42,4.7,3.1,3.8,10,"ml");

    switch ($datos_alimentos[1]) {
        case $datos_alimentos[1] = 1 :

            $calorias_desayuno = $_SESSION['porcentaje_Comida'] * $_SESSION['calorias_diarias']/100;

            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $vueltas= 0;
        
            while ($calorias_1gramo < $calorias_desayuno ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;

            $gl=$glucidos;
            $p=$proteinas;
            $gr=$grasas;

            
            echo '<br>';
            print_r("calorias aproximadas: ".$calorias_1gramo);//calorias del plato
            echo '<br>';
            print_r("Gramos necesarios ".$gramo);//gramos del plato
            echo '<br>';
            echo 'Macronutrientes<br>';
            echo "Carbohidratos ".$gl."<br>";
            echo "Proteinas ".$p."<br>";
            echo "Grasas ".$gr."<br>";
            echo '<br><br>';
            $comidas_semanales=$comidas_semanales + 1;

            break;

        case $datos_alimentos[1] = 2 :
            
            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Comida'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_1 = $calorias_desayuno*$datos_alimentos[6]/100;
            $vueltas= 0;

            while ($calorias_1gramo < $calorias_desayuno_1 ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;


            $calorias_1gramo1 = $datos_alimentos[8]/1000;
            $gramo1 = 0.10;
            $valor_1gramo_calorias1 = $datos_alimentos[8]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Comida'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_2 = $calorias_desayuno*$datos_alimentos[12]/100;
            $vueltas1= 0;

            while ($calorias_1gramo1 < $calorias_desayuno_2 ) {
                $calorias_1gramo1 = $calorias_1gramo1 + $valor_1gramo_calorias1;
                $gramo1 = $gramo1 + $valor_1gramo;
                $vueltas1= $vueltas1 + 1;
            }
            
            $glucidos1 = $datos_alimentos[9]/1000*$vueltas1;
            $proteinas1 = $datos_alimentos[10]/1000*$vueltas1;
            $grasas1 = $datos_alimentos[11]/1000*$vueltas1;

            $gl=$glucidos + $glucidos1;
            $p=$proteinas + $proteinas1;
            $gr=$grasas + $grasas1;

            array_push($glucidos_almuerzo, $gl);
            array_push($proteinas_almuerzo, $p);
            array_push($grasas_almuerzo, $gr);

            echo '<br><br>';
            echo "Contiene ". round($calorias_1gramo) ."kc de ".$datos_alimentos[15]." y ". round($calorias_1gramo1) . "kc de ".$datos_alimentos[16]."." ;
            echo '<br>';
            echo "Debe agregar ".round($gramo,0)."".$datos_alimentos[7]." de ".$datos_alimentos[15]." y " .round($gramo1,0)."".$datos_alimentos[13]." de ".$datos_alimentos[16]." a su plato.";
            echo '<br><br>';
            echo '<b>Macronutrientes</b><br>';
            echo "Glucidos: <span class='badge badge-primary'>".round($gl,1)."</span><br>";
            echo "Proteinas: <span class='badge badge-primary'>".round($p,1)."</span><br>";
            echo "Grasas: <span class='badge badge-primary'>".round($gr,1)."</span><br>";
            echo "Total kc: <span class='badge badge-success'>".round($calorias_desayuno,1)."</span>";
            



            $almuerzos_semanales=$almuerzos_semanales + 1;
            $_SESSION['num_a'] = $datos_alimentos[1];
            break;
        
        default:
            # code...
            break;
    }
    echo '</td>';

    $_SESSION['almuerzos_pdf'] = [];
    array_push($_SESSION['almuerzos_pdf'],$nombre);
    array_push($_SESSION['almuerzos_pdf'],round($calorias_1gramo));
    array_push($_SESSION['almuerzos_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['almuerzos_pdf'],round($calorias_1gramo1));
    array_push($_SESSION['almuerzos_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['almuerzos_pdf'],round($gramo,0));
    array_push($_SESSION['almuerzos_pdf'],$datos_alimentos[7]);
    array_push($_SESSION['almuerzos_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['almuerzos_pdf'],round($gramo1,0));
    array_push($_SESSION['almuerzos_pdf'],$datos_alimentos[13]);
    array_push($_SESSION['almuerzos_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['almuerzos_pdf'],round($gl,1));
    array_push($_SESSION['almuerzos_pdf'],round($p,1));
    array_push($_SESSION['almuerzos_pdf'],round($gr,1));
    array_push($_SESSION['almuerzos_pdf'],round($calorias_desayuno,1));
    array_push($_SESSION['almuerzos_pdf'],$_SESSION['num_a']);
    array_push($_SESSION['array_a_pdf'],$_SESSION['almuerzos_pdf']);

}
echo '</tr>';

echo '<tr >';
if (!empty($_SESSION['Meriendas'])) {
    

    while ($Meriendas_semanales < 7) {
        $items_array = count($_SESSION['Meriendas']);
        $items_array = $items_array - 1;
        echo '<td>';
        //print_r($_SESSION['Desayunos'][rand(0,$items_array )]);//nombre del plato

        $nombre = $_SESSION['Meriendas'][rand(0,$items_array )];
        
        $controlador = ControladorDiet::getControlador();
        $plato = $controlador->buscarPlato($nombre);//usamos esta funcion para buscar en la BBDD el producto y sus datos

        //print_r($plato);

        if (!is_array($plato )) { //este if es necesario para que no intente convertir un objeto en un array en cada vuelta del bucle,despues de la primera iteracion ya es un array.
            $temp_plato = objectToArray ( $plato );
            //echo "es un array";
        }else {
            $temp_plato =   $plato;
            //echo "no es un array";
        }

        //print_r($temp_stock);

        $datos_alimentos = [];
        foreach ($temp_plato as $a) {//aunque el array ya no es un objeto, es un array asociativo con nombres extensos, con esto lo convierto en un array de indice numerico.
            $a = array_shift($temp_plato);
        
            array_push($datos_alimentos,$a);
        }

        print_r("<b>Merienda:</b> ".$datos_alimentos[0]."");

        // $datos_alimentos = array(1,389,66.3,16.9,6.9,100,"g");
        //$datos_alimentos = array(2,389,66.3,16.9,6.9,90,"g",42,4.7,3.1,3.8,10,"ml");

        switch ($datos_alimentos[1]) {
            case $datos_alimentos[1] = 1 :

                $calorias_desayuno = $_SESSION['porcentaje_Merienda'] * $_SESSION['calorias_diarias']/100;

                $calorias_1gramo = $datos_alimentos[2]/1000;
                $gramo = 0.10;
                $valor_1gramo_calorias = $datos_alimentos[2]/1000;
                $valor_1gramo = 0.10;
                $vueltas= 0;
            
                while ($calorias_1gramo < $calorias_desayuno ) {
                    $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                    $gramo = $gramo + $valor_1gramo;
                    $vueltas= $vueltas + 1;
                }
            
                $glucidos = $datos_alimentos[3]/1000*$vueltas;
                $proteinas = $datos_alimentos[4]/1000*$vueltas;
                $grasas = $datos_alimentos[5]/1000*$vueltas;

                $gl=$glucidos;
                $p=$proteinas;
                $gr=$grasas;

                array_push($glucidos_merienda, $gl);
                array_push($proteinas_merienda, $p);
                array_push($grasas_merienda, $gr);

                
                echo '<br><br>';
                print_r("Contiene ".round($calorias_1gramo,1)."kc de ".$datos_alimentos[15].".");//calorias del plato
                echo '<br>';
                print_r("Debe agregar  ".round($gramo,1)."".$datos_alimentos[7]." de ".$datos_alimentos[15]." a su merienda.");//gramos del plato
                echo '<br><br>';
                echo '<b>Macronutrientes</b><br>';
                echo "Glucidos: <span class='badge badge-primary'>".round($gl,1)."</span><br>";
                echo "Proteinas <span class='badge badge-primary'>".round($p,1)."</span><br>";
                echo "Grasas <span class='badge badge-primary'>".round($gr,1)."</span><br>";
                echo "Total kc: <span class='badge badge-success'>".round($calorias_desayuno,1)."</span>";

                $Meriendas_semanales = $Meriendas_semanales + 1;
                $_SESSION['num_m'] = $datos_alimentos[1];
                break;

            case $datos_alimentos[1] = 2 :
                
                $calorias_1gramo = $datos_alimentos[2]/1000;
                $gramo = 0.10;
                $valor_1gramo_calorias = $datos_alimentos[2]/1000;
                $valor_1gramo = 0.10;
                $calorias_desayuno = $_SESSION['porcentaje_Merienda'] * $_SESSION['calorias_diarias']/100;
                $calorias_desayuno_1 = $calorias_desayuno*$datos_alimentos[6]/100;
                $vueltas= 0;

                while ($calorias_1gramo < $calorias_desayuno_1 ) {
                    $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                    $gramo = $gramo + $valor_1gramo;
                    $vueltas= $vueltas + 1;
                }
            
                $glucidos = $datos_alimentos[3]/1000*$vueltas;
                $proteinas = $datos_alimentos[4]/1000*$vueltas;
                $grasas = $datos_alimentos[5]/1000*$vueltas;


                $calorias_1gramo1 = $datos_alimentos[8]/1000;
                $gramo1 = 0.10;
                $valor_1gramo_calorias1 = $datos_alimentos[8]/1000;
                $valor_1gramo = 0.10;
                $calorias_desayuno = $_SESSION['porcentaje_Merienda'] * $_SESSION['calorias_diarias']/100;
                $calorias_desayuno_2 = $calorias_desayuno*$datos_alimentos[12]/100;
                $vueltas1= 0;

                while ($calorias_1gramo1 < $calorias_desayuno_2 ) {
                    $calorias_1gramo1 = $calorias_1gramo1 + $valor_1gramo_calorias1;
                    $gramo1 = $gramo1 + $valor_1gramo;
                    $vueltas1= $vueltas1 + 1;
                }
                
                $glucidos1 = $datos_alimentos[9]/1000*$vueltas1;
                $proteinas1 = $datos_alimentos[10]/1000*$vueltas1;
                $grasas1 = $datos_alimentos[11]/1000*$vueltas1;

                $gl=$glucidos + $glucidos1;
                $p=$proteinas + $proteinas1;
                $gr=$grasas + $grasas1;

                echo '<br><br>';
                echo "Contiene ". round($calorias_1gramo) ."kc de ".$datos_alimentos[15]." y ". round($calorias_1gramo1) . "kc de ".$datos_alimentos[16]."." ;
                echo '<br>';
                echo "Debe agregar ".round($gramo,0)."".$datos_alimentos[7]." de ".$datos_alimentos[15]." y " .round($gramo1,0)."".$datos_alimentos[13]." de ".$datos_alimentos[16]." a su plato.";
                echo '<br><br>';
                echo '<b>Macronutrientes</b><br>';
                echo "Glucidos: <span class='badge badge-primary'>".round($gl,1)."</span><br>";
                echo "Proteinas: <span class='badge badge-primary'>".round($p,1)."</span><br>";
                echo "Grasas: <span class='badge badge-primary'>".round($gr,1)."</span><br>";
                echo "<b>Calorias totales del plato: </b><span class='badge badge-success'>".round($calorias_desayuno,1)."</span>";

                $Meriendas_semanales=$Meriendas_semanales + 1;
                $_SESSION['num_m'] = $datos_alimentos[1];

                break;
            
            default:
                # code...
                break;
        }
        echo '</td>';

        $_SESSION['meriendas_pdf'] = [];
        array_push($_SESSION['meriendas_pdf'],$nombre);
        array_push($_SESSION['meriendas_pdf'],round($calorias_1gramo));
        array_push($_SESSION['meriendas_pdf'],$datos_alimentos[15]);
        array_push($_SESSION['meriendas_pdf'],round($calorias_1gramo1));
        array_push($_SESSION['meriendas_pdf'],$datos_alimentos[16]);
        array_push($_SESSION['meriendas_pdf'],round($gramo,0));
        array_push($_SESSION['meriendas_pdf'],$datos_alimentos[7]);
        array_push($_SESSION['meriendas_pdf'],$datos_alimentos[15]);
        array_push($_SESSION['meriendas_pdf'],round($gramo1,0));
        array_push($_SESSION['meriendas_pdf'],$datos_alimentos[13]);
        array_push($_SESSION['meriendas_pdf'],$datos_alimentos[16]);
        array_push($_SESSION['meriendas_pdf'],round($gl,1));
        array_push($_SESSION['meriendas_pdf'],round($p,1));
        array_push($_SESSION['meriendas_pdf'],round($gr,1));
        array_push($_SESSION['meriendas_pdf'],round($calorias_desayuno,1));
        array_push($_SESSION['meriendas_pdf'],$_SESSION['num_m']);
        array_push($_SESSION['array_m_pdf'],$_SESSION['meriendas_pdf']);
    }
}
// print_r($_SESSION['array_m_pdf']);
echo '</tr>';


echo '<tr >';
while ($Cena_semanales < 7) {
    $items_array = count($_SESSION['Cenas']);
    $items_array = $items_array - 1;
    echo '<td>';
    //print_r($_SESSION['Desayunos'][rand(0,$items_array )]);//nombre del plato

    $nombre = $_SESSION['Cenas'][rand(0,$items_array )];
    
    $controlador = ControladorDiet::getControlador();
    $plato = $controlador->buscarPlato($nombre);//usamos esta funcion para buscar en la BBDD el producto y sus datos

    //print_r($plato);

    if (!is_array($plato )) { //este if es necesario para que no intente convertir un objeto en un array en cada vuelta del bucle,despues de la primera iteracion ya es un array.
        $temp_plato = objectToArray ( $plato );
        //echo "es un array";
    }else {
        $temp_plato =   $plato;
        //echo "no es un array";
    }

     //print_r($temp_stock);

    $datos_alimentos = [];
    foreach ($temp_plato as $a) {//aunque el array ya no es un objeto, es un array asociativo con nombres extensos, con esto lo convierto en un array de indice numerico.
        $a = array_shift($temp_plato);
    
        array_push($datos_alimentos,$a);
    }

    print_r("<b>Cena: </b>".$datos_alimentos[0]."");

    // $datos_alimentos = array(1,389,66.3,16.9,6.9,100,"g");
    //$datos_alimentos = array(2,389,66.3,16.9,6.9,90,"g",42,4.7,3.1,3.8,10,"ml");

    switch ($datos_alimentos[1]) {
        case $datos_alimentos[1] = 1 :

            $calorias_desayuno = $_SESSION['porcentaje_Cena'] * $_SESSION['calorias_diarias']/100;

            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $vueltas= 0;
        
            while ($calorias_1gramo < $calorias_desayuno ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;

            $gl=$glucidos;
            $p=$proteinas;
            $gr=$grasas;

            
            echo '<br>';
            print_r("calorias aproximadas: ".$calorias_1gramo);//calorias del plato
            echo '<br>';
            print_r("Gramos necesarios ".$gramo);//gramos del plato
            echo '<br>';
            echo 'Macronutrientes<br>';
            echo "Carbohidratos ".$gl."<br>";
            echo "Proteinas ".$p."<br>";
            echo "Grasas ".$gr."<br>";
            echo '<br><br>';
            $Cena_semanales=$Cena_semanales + 1;

            break;

        case $datos_alimentos[1] = 2 :
            
            $calorias_1gramo = $datos_alimentos[2]/1000;
            $gramo = 0.10;
            $valor_1gramo_calorias = $datos_alimentos[2]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Cena'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_1 = $calorias_desayuno*$datos_alimentos[6]/100;
            $vueltas= 0;

            while ($calorias_1gramo < $calorias_desayuno_1 ) {
                $calorias_1gramo = $calorias_1gramo + $valor_1gramo_calorias;
                $gramo = $gramo + $valor_1gramo;
                $vueltas= $vueltas + 1;
            }
        
            $glucidos = $datos_alimentos[3]/1000*$vueltas;
            $proteinas = $datos_alimentos[4]/1000*$vueltas;
            $grasas = $datos_alimentos[5]/1000*$vueltas;


            $calorias_1gramo1 = $datos_alimentos[8]/1000;
            $gramo1 = 0.10;
            $valor_1gramo_calorias1 = $datos_alimentos[8]/1000;
            $valor_1gramo = 0.10;
            $calorias_desayuno = $_SESSION['porcentaje_Cena'] * $_SESSION['calorias_diarias']/100;
            $calorias_desayuno_2 = $calorias_desayuno*$datos_alimentos[12]/100;
            $vueltas1= 0;

            while ($calorias_1gramo1 < $calorias_desayuno_2 ) {
                $calorias_1gramo1 = $calorias_1gramo1 + $valor_1gramo_calorias1;
                $gramo1 = $gramo1 + $valor_1gramo;
                $vueltas1= $vueltas1 + 1;
            }
            
            $glucidos1 = $datos_alimentos[9]/1000*$vueltas1;
            $proteinas1 = $datos_alimentos[10]/1000*$vueltas1;
            $grasas1 = $datos_alimentos[11]/1000*$vueltas1;

            $gl=$glucidos + $glucidos1;
            $p=$proteinas + $proteinas1;
            $gr=$grasas + $grasas1;

            array_push($glucidos_cena, $gl);
            array_push($proteinas_cena, $p);
            array_push($grasas_cena, $gr);

            echo '<br><br>';
            echo "Contiene ". round($calorias_1gramo) ."kc de ".$datos_alimentos[15]." y ". round($calorias_1gramo1) . "kc de ".$datos_alimentos[16]."." ;
            echo '<br>';
            echo "Debe agregar ".round($gramo,0)."".$datos_alimentos[7]." de ".$datos_alimentos[15]." y " .round($gramo1,0)."".$datos_alimentos[13]." de ".$datos_alimentos[16]." a su plato.";
            echo '<br><br>';
            echo '<b>Macronutrientes</b><br>';
            echo "Glucidos: <span class='badge badge-primary'>".round($gl,1)."</span><br>";
            echo "Proteinas: <span class='badge badge-primary'>".round($p,1)."</span><br>";
            echo "Grasas: <span class='badge badge-primary'>".round($gr,1)."</span><br>";
            echo "Total kc: <span class='badge badge-success'>".round($calorias_desayuno,1)."</span>";

            



            $Cena_semanales=$Cena_semanales + 1;
            $_SESSION['num_c'] = $datos_alimentos[1];
            break;
        
        default:
            # code...
            break;
    }
    echo '</td>';

    $_SESSION['cenas_pdf'] = [];
    array_push($_SESSION['cenas_pdf'],$nombre);
    array_push($_SESSION['cenas_pdf'],round($calorias_1gramo));
    array_push($_SESSION['cenas_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['cenas_pdf'],round($calorias_1gramo1));
    array_push($_SESSION['cenas_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['cenas_pdf'],round($gramo,0));
    array_push($_SESSION['cenas_pdf'],$datos_alimentos[7]);
    array_push($_SESSION['cenas_pdf'],$datos_alimentos[15]);
    array_push($_SESSION['cenas_pdf'],round($gramo1,0));
    array_push($_SESSION['cenas_pdf'],$datos_alimentos[13]);
    array_push($_SESSION['cenas_pdf'],$datos_alimentos[16]);
    array_push($_SESSION['cenas_pdf'],round($gl,1));
    array_push($_SESSION['cenas_pdf'],round($p,1));
    array_push($_SESSION['cenas_pdf'],round($gr,1));
    array_push($_SESSION['cenas_pdf'],round($calorias_desayuno,1));
    array_push($_SESSION['cenas_pdf'],$_SESSION['num_c']);
    array_push($_SESSION['array_c_pdf'],$_SESSION['cenas_pdf']);

}
echo '</tr>';

error_reporting(E_ERROR | E_WARNING | E_PARSE);

$glucidos_totales_dia = $glucidos_desayuno[0]+$glucidos_tentempie[0]+$glucidos_almuerzo[0]+$glucidos_merienda[0]+$glucidos_cena[0];
$proteinas_totales_dia = $proteinas_desayuno[0]+$proteinas_tentempie[0]+$proteinas_almuerzo[0]+$proteinas_merienda[0]+$proteinas_cena[0];
$grasas_totales_dia = $grasas_desayuno[0]+$grasas_tentempie[0]+$grasas_almuerzo[0]+$grasas_merienda[0]+$grasas_cena[0];

$glucidos_totales_dia1 = $glucidos_desayuno[1]+$glucidos_tentempie[1]+$glucidos_almuerzo[1]+$glucidos_merienda[1]+$glucidos_cena[1];
$proteinas_totales_dia1 = $proteinas_desayuno[1]+$proteinas_tentempie[1]+$proteinas_almuerzo[1]+$proteinas_merienda[1]+$proteinas_cena[1];
$grasas_totales_dia1 = $grasas_desayuno[1]+$grasas_tentempie[1]+$grasas_almuerzo[1]+$grasas_merienda[1]+$grasas_cena[1];

$glucidos_totales_dia2 = $glucidos_desayuno[2]+$glucidos_tentempie[2]+$glucidos_almuerzo[2]+$glucidos_merienda[2]+$glucidos_cena[2];
$proteinas_totales_dia2 = $proteinas_desayuno[2]+$proteinas_tentempie[2]+$proteinas_almuerzo[2]+$proteinas_merienda[2]+$proteinas_cena[2];
$grasas_totales_dia2 = $grasas_desayuno[2]+$grasas_tentempie[2]+$grasas_almuerzo[2]+$grasas_merienda[2]+$grasas_cena[2];

$glucidos_totales_dia3 = $glucidos_desayuno[3]+$glucidos_tentempie[3]+$glucidos_almuerzo[3]+$glucidos_merienda[3]+$glucidos_cena[3];
$proteinas_totales_dia3 = $proteinas_desayuno[3]+$proteinas_tentempie[3]+$proteinas_almuerzo[3]+$proteinas_merienda[3]+$proteinas_cena[3];
$grasas_totales_dia3 = $grasas_desayuno[3]+$grasas_tentempie[3]+$grasas_almuerzo[3]+$grasas_merienda[3]+$grasas_cena[3];

$glucidos_totales_dia4 = $glucidos_desayuno[4]+$glucidos_tentempie[4]+$glucidos_almuerzo[4]+$glucidos_merienda[4]+$glucidos_cena[4];
$proteinas_totales_dia4 = $proteinas_desayuno[4]+$proteinas_tentempie[4]+$proteinas_almuerzo[4]+$proteinas_merienda[4]+$proteinas_cena[4];
$grasas_totales_dia4 = $grasas_desayuno[4]+$grasas_tentempie[4]+$grasas_almuerzo[4]+$grasas_merienda[4]+$grasas_cena[4];

$glucidos_totales_dia5 = $glucidos_desayuno[5]+$glucidos_tentempie[5]+$glucidos_almuerzo[5]+$glucidos_merienda[5]+$glucidos_cena[5];
$proteinas_totales_dia5 = $proteinas_desayuno[5]+$proteinas_tentempie[5]+$proteinas_almuerzo[5]+$proteinas_merienda[5]+$proteinas_cena[5];
$grasas_totales_dia5 = $grasas_desayuno[5]+$grasas_tentempie[5]+$grasas_almuerzo[5]+$grasas_merienda[5]+$grasas_cena[5];

$glucidos_totales_dia6 = $glucidos_desayuno[6]+$glucidos_tentempie[6]+$glucidos_almuerzo[6]+$glucidos_merienda[6]+$glucidos_cena[6];
$proteinas_totales_dia6 = $proteinas_desayuno[6]+$proteinas_tentempie[6]+$proteinas_almuerzo[6]+$proteinas_merienda[6]+$proteinas_cena[6];
$grasas_totales_dia6 = $grasas_desayuno[6]+$grasas_tentempie[6]+$grasas_almuerzo[6]+$grasas_merienda[6]+$grasas_cena[6];

echo '<tr>';
echo '<td>';
echo '<b>Totales Diarios</b><br><br>';
echo 'Glucidos: <span class="badge badge-warning">'.round($glucidos_totales_dia,1).'</span><br>';
echo 'Proteinas: <span class="badge badge-warning">'.round($proteinas_totales_dia,1).'</span><br>';
echo 'Grasas: <span class="badge badge-warning">'.round($grasas_totales_dia,1).'</span><br>';
echo 'Calorias: <span class="badge badge-warning">'.round($_SESSION['calorias_diarias'],1).'</span><br>';
echo '</td>';
echo '<td>';
echo '<b>Totales Diarios</b><br><br>';
echo 'Glucidos: <span class="badge badge-warning">'.round($glucidos_totales_dia1,1).'</span><br>';
echo 'Proteinas: <span class="badge badge-warning">'.round($proteinas_totales_dia1,1).'</span><br>';
echo 'Grasas: <span class="badge badge-warning">'.round($grasas_totales_dia1,1).'</span><br>';
echo 'Calorias: <span class="badge badge-warning">'.round($_SESSION['calorias_diarias'],1).'</span><br>';
echo '</td>';
echo '<td>';
echo '<b>Totales Diarios</b><br><br>';
echo 'Glucidos: <span class="badge badge-warning">'.round($glucidos_totales_dia2,1).'</span><br>';
echo 'Proteinas: <span class="badge badge-warning">'.round($proteinas_totales_dia2,1).'</span><br>';
echo 'Grasas: <span class="badge badge-warning">'.round($grasas_totales_dia2,1).'</span><br>';
echo 'Calorias: <span class="badge badge-warning">'.round($_SESSION['calorias_diarias'],1).'</span><br>';
echo '</td>';
echo '<td>';
echo '<b>Totales Diarios</b><br><br>';
echo 'Glucidos: <span class="badge badge-warning">'.round($glucidos_totales_dia3,1).'</span><br>';
echo 'Proteinas: <span class="badge badge-warning">'.round($proteinas_totales_dia3,1).'</span><br>';
echo 'Grasas: <span class="badge badge-warning">'.round($grasas_totales_dia3,1).'</span><br>';
echo 'Calorias: <span class="badge badge-warning">'.round($_SESSION['calorias_diarias'],1).'</span><br>';
echo '</td>';
echo '<td>';
echo '<b>Totales Diarios</b><br><br>';
echo 'Glucidos: <span class="badge badge-warning">'.round($glucidos_totales_dia4,1).'</span><br>';
echo 'Proteinas: <span class="badge badge-warning">'.round($proteinas_totales_dia4,1).'</span><br>';
echo 'Grasas: <span class="badge badge-warning">'.round($grasas_totales_dia4,1).'</span><br>';
echo 'Calorias: <span class="badge badge-warning">'.round($_SESSION['calorias_diarias'],1).'</span><br>';
echo '</td>';
echo '<td>';
echo '<b>Totales Diarios</b><br><br>';
echo 'Glucidos: <span class="badge badge-warning">'.round($glucidos_totales_dia5,1).'</span><br>';
echo 'Proteinas: <span class="badge badge-warning">'.round($proteinas_totales_dia5,1).'</span><br>';
echo 'Grasas: <span class="badge badge-warning">'.round($grasas_totales_dia5,1).'</span><br>';
echo 'Calorias: <span class="badge badge-warning">'.round($_SESSION['calorias_diarias'],1).'</span><br>';
echo '</td>';
echo '<td>';
echo '<b>Totales Diarios</b><br><br>';
echo 'Glucidos: <span class="badge badge-warning">'.round($glucidos_totales_dia6,1).'</span><br>';
echo 'Proteinas: <span class="badge badge-warning">'.round($proteinas_totales_dia6,1).'</span><br>';
echo 'Grasas: <span class="badge badge-warning">'.round($grasas_totales_dia6,1).'</span><br>';
echo 'Calorias: <span class="badge badge-warning">'.round($_SESSION['calorias_diarias'],1).'</span><br>';
echo '</td>';
echo '</tr>';

echo '</table>';

echo '</div>';

$_SESSION['total_lunes'] = [];
array_push($_SESSION['total_lunes'],round($glucidos_totales_dia,1));
array_push($_SESSION['total_lunes'],round($proteinas_totales_dia,1));
array_push($_SESSION['total_lunes'],round($grasas_totales_dia,1));
array_push($_SESSION['total_lunes'],round($_SESSION['calorias_diarias'],1));

$_SESSION['total_martes'] = [];
array_push($_SESSION['total_martes'],round($glucidos_totales_dia1,1));
array_push($_SESSION['total_martes'],round($proteinas_totales_dia1,1));
array_push($_SESSION['total_martes'],round($grasas_totales_dia1,1));
array_push($_SESSION['total_martes'],round($_SESSION['calorias_diarias'],1));

$_SESSION['total_miercoles'] = [];
array_push($_SESSION['total_miercoles'],round($glucidos_totales_dia2,1));
array_push($_SESSION['total_miercoles'],round($proteinas_totales_dia2,1));
array_push($_SESSION['total_miercoles'],round($grasas_totales_dia2,1));
array_push($_SESSION['total_miercoles'],round($_SESSION['calorias_diarias'],1));

$_SESSION['total_jueves'] = [];
array_push($_SESSION['total_jueves'],round($glucidos_totales_dia3,1));
array_push($_SESSION['total_jueves'],round($proteinas_totales_dia3,1));
array_push($_SESSION['total_jueves'],round($grasas_totales_dia3,1));
array_push($_SESSION['total_jueves'],round($_SESSION['calorias_diarias'],1));

$_SESSION['total_viernes'] = [];
array_push($_SESSION['total_viernes'],round($glucidos_totales_dia4,1));
array_push($_SESSION['total_viernes'],round($proteinas_totales_dia4,1));
array_push($_SESSION['total_viernes'],round($grasas_totales_dia4,1));
array_push($_SESSION['total_viernes'],round($_SESSION['calorias_diarias'],1));

$_SESSION['total_sabado'] = [];
array_push($_SESSION['total_sabado'],round($glucidos_totales_dia5,1));
array_push($_SESSION['total_sabado'],round($proteinas_totales_dia5,1));
array_push($_SESSION['total_sabado'],round($grasas_totales_dia5,1));
array_push($_SESSION['total_sabado'],round($_SESSION['calorias_diarias'],1));

$_SESSION['total_domingo'] = [];
array_push($_SESSION['total_domingo'],round($glucidos_totales_dia6,1));
array_push($_SESSION['total_domingo'],round($proteinas_totales_dia6,1));
array_push($_SESSION['total_domingo'],round($grasas_totales_dia6,1));
array_push($_SESSION['total_domingo'],round($_SESSION['calorias_diarias'],1));

$_SESSION['totales_semana'] = [];
array_push($_SESSION['totales_semana'],$_SESSION['total_lunes']);
array_push($_SESSION['totales_semana'],$_SESSION['total_martes']);
array_push($_SESSION['totales_semana'],$_SESSION['total_miercoles']);
array_push($_SESSION['totales_semana'],$_SESSION['total_jueves']);
array_push($_SESSION['totales_semana'],$_SESSION['total_viernes']);
array_push($_SESSION['totales_semana'],$_SESSION['total_sabado']);
array_push($_SESSION['totales_semana'],$_SESSION['total_domingo']);

// print_r($_SESSION['totales_semana']);





?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<style>
div.tabla{
    margin-top:100px;
    margin-left:7.5%;
    margin-right:7.5%;

}
.head{
    /* background-color:#034f84; */
}
table{
    
    background-image:url("/autodiet/imagenes/azulo.jpg");
    color:white;
    font-size:19px;
    /* font-weight:bolder; */
    margin-bottom:100px;
    
}
td{
    width:12%;
    border:solid 3px lightgray;
}
th{
    text-align:center;
}
</style>
