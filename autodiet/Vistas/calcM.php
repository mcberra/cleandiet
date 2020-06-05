<?php

require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!!
require_once UTILITY_PATH."funciones.php";
require_once VIEW_PATH."header.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

    $peso=filtrado($_POST["peso"]);
    $altura=filtrado($_POST["altura"]);

    $imc=$peso/($altura*$altura);

    echo '<div style="width:600px;border:2px solid lightgray;margin:auto;padding:35px">';
        echo'<h1 style="text-align:center;">Calculadora de masa corporal</h1>';
        echo '<br>';
        echo '<br>';
        echo 'Su IMC es: <b>'. round($imc,2) . '</b>.';
        echo '<br>';
        switch ($imc) {
            case $imc < 18.5:
                echo 'Usted se encuentra en el grupo: <b> Peso insuficiente. </b>';
                echo '<br>';
                break;

            case $imc > 18.5 && $imc < 24.9:
                echo 'Usted se encuentra en el grupo: <b> Normopeso. </b>';
                echo '<br>';
                break;

            case $imc > 25 && $imc < 26.9:
                echo 'Usted se encuentra en el grupo: <b> Sobrepeso grado I. </b>';
                echo '<br>';
                break;

            case $imc > 27 && $imc < 29.9:
                echo 'Usted se encuentra en el grupo: <b> Sobrepeso grado II (preobesidad). </b>';
                echo '<br>';
                break;

            case $imc > 30 && $imc < 34.9:
                echo 'Usted se encuentra en el grupo: <b> Obesidad de tipo I. </b>';
                echo '<br>';
                break;

            case $imc > 35 && $imc < 39.9:
                echo 'Usted se encuentra en el grupo: <b> Obesidad de tipo II. </b>';
                echo '<br>';
                break;

            case $imc > 40 && $imc < 49.9:
                echo 'Usted se encuentra en el grupo: <b> Obesidad de tipo III (mórbida). </b>';
                echo '<br>';
                break;

            case $imc > 50 :
                echo 'Usted se encuentra en el grupo: <b> Obesidad de tipo IV (extrema). </b>';
                echo '<br>';
                break;
            
            default:
                # code...
                break;
        }
        echo '<br>';
        echo '<table class="table table-striped table-dark">';
            echo '<thead>';
                echo '<tr>';
                    echo '<th>IMC</th>';
                    echo '<th>Clasificación</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<td>Menos de 18.5</td>';
                    echo '<td>Peso insuficiente</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>18,5-24,9</td>';
                    echo '<td>Normopeso</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>25-26,9</td>';
                    echo '<td>Sobrepeso grado I</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>27-29,9</td>';
                    echo '<td>Sobrepeso grado II</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>30-34,9</td>';
                    echo '<td>Obesidad de tipo I</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>35-39,9</td>';
                    echo '<td>Obesidad de tipo II</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>40-49,9</td>';
                    echo '<td>Obesidad de tipo III (mórbida)</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Mas de 50</td>';
                    echo '<td>Obesidad de tipo IV (extrema)</td>';
                echo '</tr>';
            echo '</tbody>';
        echo '</table>';
        echo '<p style="text-align: center;"><a href="/autodiet/Vistas/calcM.php" style="text-decoration:none" class="btn btn-primary"  > Volver</a></p>';
    echo '</div>';
    
}else{

    echo '<form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post" enctype="multipart/form-data">';

        echo '<div class="shadow-lg p-3 mb-5 bg-white rounded" style="width:600px;border:2px solid lightgray;margin:auto;padding:25px;margin-top:50px;">';

            echo'<h1 style="text-align:center;">Calculadora de masa corporal</h1>';
            echo '<br>';
            echo '<br>';
            echo '<label><b>Indique su peso en Kilogramos (Kg)</b></label><br>';
            echo '<input type="number" required name="peso"  class="form-control"  ><br><br>';

            echo '<label><b>Indique su estatura en Metros (Mt)</b></label><br>';
            echo '<input type="number" required name="altura"  class="form-control" step="any" ><br><br>';

            echo '<p style="text-align:center">';
            echo '<input type="submit" name="Enviar" value="Calcular" class="btn btn-success" > ';
            echo '<a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>';
            echo '</p>';

        echo '</div>';

    echo '</form>';

}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

