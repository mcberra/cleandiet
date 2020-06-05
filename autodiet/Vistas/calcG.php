<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
body{
    background: -webkit-linear-gradient(left, #0072ff, #00c6ff);
}
.contact-form{
    background: #fff;
    margin-top: 10%;
    margin-bottom: 5%;
    width: 70%;
}
.contact-form .form-control{
    border-radius:1rem;
}
.contact-image{
    text-align: center;
}
.contact-image img{
    border-radius: 6rem;
    width: 11%;
    margin-top: -3%;
    transform: rotate(29deg);
}
.contact-form form{
    padding: 14%;
}
.contact-form form .row{
    margin-bottom: -7%;
}
.contact-form h3{
    margin-bottom: 8%;
    margin-top: -10%;
    text-align: center;
    color: #0062cc;
}
.contact-form .btnContact {
    width: 50%;
    border: none;
    border-radius: 1rem;
    padding: 1.5%;
    background: #dc3545;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
}
.btnContactSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    color: #fff;
    background-color: #0062cc;
    border: none;
    cursor: pointer;
}
</style>
<?php

require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!!
require_once UTILITY_PATH."funciones.php";
require_once VIEW_PATH."header.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

    $peso=filtrado($_POST["peso"]);
    $altura=filtrado($_POST["altura"]);
    $cuello=filtrado($_POST["cuello"]);
    $cintura=filtrado($_POST["cintura"]);
    $caderas=filtrado($_POST["caderas"]);
    $sex=filtrado($_POST["sex"]);

if ($sex == "H") {

    $log10cc = $cintura - $cuello;
    
    

    switch ($log10cc) {
        case $log10cc >= 0 && $log10cc <= 9:

           $logcc = 0;
           $aproximador = 0.1;
           while ($aproximador < $log10cc*99.5/100) {
            $aproximador = $aproximador * 1.005;
            $logcc = $logcc + 0.002200000;
           }

            break;
        
        case $log10cc >= 10 && $log10cc <= 99:
            $logcc = 1;
            $aproximador = 10;
            while ($aproximador < $log10cc*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $logcc = $logcc + 0.002200000;
            }

            break;

        case $log10cc >= 100 && $log10cc <= 999:
            $logcc = 2;
            $aproximador = 100;
            while ($aproximador < $log10cc*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $logcc = $logcc + 0.002200000;
            }

            break;
        

        
        default:
            # code...
            break;
    }
    
    $log10a = $altura;

    switch ($log10a) {
        case $log10a >= 0 && $log10a <= 9:

           $loga = 0;
           $aproximador = 0.1;
           while ($aproximador < $log10a*99.5/100) {
            $aproximador = $aproximador * 1.005;
            $loga = $loga + 0.002200000;
           }

            break;
        
        case $log10a >= 10 && $log10a <= 99:
            $loga = 1;
            $aproximador = 10;
            while ($aproximador < $log10a*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $loga = $loga + 0.002200000;
            }

            break;

        case $log10a >= 100 && $log10a <= 999:
            $loga = 2;
            $aproximador = 100;
            while ($aproximador < $log10a*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $loga = $loga + 0.002200000;
            }

            break;
        

        
        default:
            # code...
            break;
    }

     $gc=495 / (1.0324 - .19077 * $logcc + 0.15456 * $loga) - 450;
     

     
     echo '<div class="container contact-form">';

     echo '<div class="contact-image">';
         echo '<img src="/autodiet/imagenes/calc.png" alt="rocket_contact"/>';
     echo '</div>';

        echo'<h1 style="text-align:center;">Calculadora de grasa corporal</h1>';
        echo '<br>';
        echo '<br>';
        echo 'Su Porcentaje de grasa corporal es: <span class="badge badge-info">'. round($gc,3) . '%.</span>';
        echo '<br>';
        switch ($gc) {
            case $gc < 6:
                echo 'Usted se encuentra en el grupo: <span class="badge badge-info">Grasa esencial. </span>';
                echo '<br>';
                break;

            case $gc > 6 && $gc < 14:
                echo 'Usted se encuentra en el grupo: <span class="badge badge-info"> Atletas. </span>';
                echo '<br>';
                break;

            case $gc >= 14 && $gc < 18:
                echo 'Usted se encuentra en el grupo: <span class="badge badge-info"> Estado fisico. </span>';
                echo '<br>';
                break;

            case $gc >= 18 && $gc < 25:
                echo 'Usted se encuentra en el grupo: <span class="badge badge-info"> Promedio. </span>';
                echo '<br>';
                break;

            case $gc > 25:
                echo 'Usted se encuentra en el grupo: <span class="badge badge-info"> Obesidad. </span>';
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
                    echo '<th>Porcentaje grasa corporal</th>';
                    echo '<th>Mujer</th>';
                    echo '<th>Hombre</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<td>Grasa esencial</td>';
                    echo '<td>10-13%</td>';
                    echo '<td>2-5%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Porcentaje de grasa para atletas</td>';
                    echo '<td>14-20%</td>';
                    echo '<td>6-13%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Estado fisico</td>';
                    echo '<td>21-24%</td>';
                    echo '<td>14-17%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Nivel promedio</td>';
                    echo '<td>25-31%</td>';
                    echo '<td>18-24%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Obesidad</td>';
                    echo '<td>32% y superior</td>';
                    echo '<td>25% y superior</td>';
                echo '</tr>';
            echo '</tbody>';
        echo '</table>';
        echo '<p style="text-align: center;"><a href="/autodiet/Vistas/calcG.php" style="text-decoration:none" class="btn btn-primary"  > Volver</a></p>';
    echo '</div>';


}else {

    $log10cc = $cintura + $caderas - $cuello;
    
    

    switch ($log10cc) {
        case $log10cc >= 0 && $log10cc <= 9:

           $logcc = 0;
           $aproximador = 0.1;
           while ($aproximador < $log10cc*99.5/100) {
            $aproximador = $aproximador * 1.005;
            $logcc = $logcc + 0.002200000;
           }

            break;
        
        case $log10cc >= 10 && $log10cc <= 99:
            $logcc = 1;
            $aproximador = 10;
            while ($aproximador < $log10cc*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $logcc = $logcc + 0.002200000;
            }

            break;

        case $log10cc >= 100 && $log10cc <= 999:
            $logcc = 2;
            $aproximador = 100;
            while ($aproximador < $log10cc*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $logcc = $logcc + 0.002200000;
            }

            break;
        

        
        default:
            # code...
            break;
    }
    
    $log10a = $altura;

    switch ($log10a) {
        case $log10a >= 0 && $log10a <= 9:

           $loga = 0;
           $aproximador = 0.1;
           while ($aproximador < $log10a*99.5/100) {
            $aproximador = $aproximador * 1.005;
            $loga = $loga + 0.002200000;
           }

            break;
        
        case $log10a >= 10 && $log10a <= 99:
            $loga = 1;
            $aproximador = 10;
            while ($aproximador < $log10a*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $loga = $loga + 0.002200000;
            }

            break;

        case $log10a >= 100 && $log10a <= 999:
            $loga = 2;
            $aproximador = 100;
            while ($aproximador < $log10a*99.5/100) {
             $aproximador = $aproximador * 1.005;
             $loga = $loga + 0.002200000;
            }

            break;
        

        
        default:
            # code...
            break;
    }

    $gc=495 / (1.29579 - 0.35004 * $logcc  + 0.22100 * $loga) - 450;
    
    echo '<div class="container contact-form">';

        echo '<div class="contact-image">';
            echo '<img src="/autodiet/imagenes/calc.png" alt="rocket_contact"/>';
        echo '</div>';

        echo'<h1 style="text-align:center;">Calculadora de grasa corporal</h1>';
        echo '<br>';
        echo '<br>';
        echo 'Su Porcentaje de grasa corporal es: <b>'. round($gc,3) . '%</b>.';
        echo '<br>';
        switch ($gc) {
            case $gc <= 13:
                echo 'Usted se encuentra en el grupo: <b> Grasa esencial. </b>';
                echo '<br>';
                break;

            case $gc > 13 && $gc < 20:
                echo 'Usted se encuentra en el grupo: <b> Atletas. </b>';
                echo '<br>';
                break;

            case $gc > 20 && $gc < 25:
                echo 'Usted se encuentra en el grupo: <b> Estado fisico. </b>';
                echo '<br>';
                break;

            case $gc >= 25 && $gc < 32:
                echo 'Usted se encuentra en el grupo: <b> Promedio. </b>';
                echo '<br>';
                break;

            case $gc > 32:
                echo 'Usted se encuentra en el grupo: <b> Obesidad. </b>';
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
                    echo '<th>Porcentaje grasa corporal</th>';
                    echo '<th>Mujer</th>';
                    echo '<th>Hombre</th>';
                echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
                echo '<tr>';
                    echo '<td>Grasa esencial</td>';
                    echo '<td>10-13%</td>';
                    echo '<td>2-5%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Porcentaje de grasa para atletas</td>';
                    echo '<td>14-20%</td>';
                    echo '<td>6-13%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Estado fisico</td>';
                    echo '<td>21-24%</td>';
                    echo '<td>14-17%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Nivel promedio</td>';
                    echo '<td>25-31%</td>';
                    echo '<td>18-24%</td>';
                echo '</tr>';
                echo '<tr>';
                    echo '<td>Obesidad</td>';
                    echo '<td>32% y superior</td>';
                    echo '<td>25% y superior</td>';
                echo '</tr>';
            echo '</tbody>';
        echo '</table>';
        echo '<p style="text-align: center;"><a href="/autodiet/Vistas/calcG.php" style="text-decoration:none" class="btn btn-primary"  > Volver</a></p>';
    echo '</div>';
}

}else{

    echo '<div class="container contact-form">';

        echo '<div class="contact-image">';
            echo '<img src="/autodiet/imagenes/calc.png" alt="rocket_contact"/>';
        echo '</div>';

    echo '<form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post" enctype="multipart/form-data">';



                echo'<h1 style="text-align:center;">Calculadora de grasa corporal</h1><br><br><br><br>';

                echo'<div class="row">';

                    echo'<div class="col-md-6">';

                        echo'<div class="form-group">';
                            echo '<input type="number" required name="peso"  class="form-control" placeholder="Indique su peso en Kilogramos (Kg) *" step="0.01"><br><br>';
                        echo '</div>';

                        echo'<div class="form-group">';
                            echo '<input type="number" required name="altura"  class="form-control" placeholder="Indique su estatura en Centimetros (Cm) *"  step="0.01" ><br><br>';
                        echo '</div>';

                        echo'<div class="form-group">';
                            echo '<input type="number" required name="cuello"  class="form-control" placeholder="Indique la medida de su cuello (cm) *" step="0.01" ><br><br>';
                        echo '</div>';

                        echo'<div class="form-group">';
                            echo '<input type="number" required name="cintura"  class="form-control" placeholder="Indique la medida de su cintura (cm) *" step="0.01" ><br><br>';
                        echo '</div>';

                        echo'<div class="form-group">';
                            echo '<input type="number"  name="caderas"  class="form-control" placeholder="Indique la medida de su cadera en (cm), solo si es mujer " step="any" ><br><br>';
                        echo '</div>';

                    echo '</div>';

                    echo '<div class="col-md-6">';

                        echo'<div class="form-group">';
                            echo '<label><b>Sexo</b></label><br>';
                            echo '<input type="radio" name="sex" class="w3-radio" value="H"   checked >Hombre</input><br>';
                            echo '<input type="radio" name="sex" class="w3-radio" value="M" >Mujer</input><br><br><br><br><br><br>';
                        echo '</div>';

                        echo'<div class="form-group">';
                            echo '<p style="text-align:center">';
                                echo '<button type="button" class="btn btn-lg btn-info" data-toggle="popover" title="Informacion" data-content=" La imagen debe ser jpg. ">Informacion</button>';
                            echo '</p>';
                            echo '<p style="text-align:center">';
                                echo '<input type="submit" name="Enviar" value="Calcular" class="btn btn-success" > ';
                                echo '<a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>';
                            echo '</p>';
                        echo '</div>';

                    echo '</div>';

                echo '</div>';

    echo '</form>';
echo '</div>';
}

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

<script src="http://code.jquery.com/jquery-latest.js"></script>
</script>
<script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>