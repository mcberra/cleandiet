<?php require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! ?>
<?php require_once VIEW_PATH."header.php"; ?>
<?php require_once UTILITY_PATH."funciones.php"; ?>

<?php

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

    $peso=filtrado($_POST["peso"]);
    $altura=filtrado($_POST["altura"]);
    $edad=filtrado($_POST["edad"]);
    $sex=filtrado($_POST["sex"]);
    $actividad_diaria=filtrado($_POST["actividad_diaria"]);

    switch ($actividad_diaria) {
        case '1':
            $actividad_diaria=1.2;
            break;

        case '2':
            $actividad_diaria=1.375;
            break;

        case '3':
            $actividad_diaria=1.55;
            break;

        case '4':
            $actividad_diaria=1.72;
            break;

        case '5':
            $actividad_diaria=1.9;
            break;
        
        default:
            echo "ERROR";
            break;
    }

    if ($sex == "H") {

        $TMB=66 + (13.7 * $peso) + (5 * $altura) - (6.75 * $edad);
        $_SESSION['calorias_diarias']=($TMB * $actividad_diaria)-75;
        $bajar_05k=$_SESSION['calorias_diarias']-500;
        $bajar_1k=$_SESSION['calorias_diarias']-1000;
        $subir_05k=$_SESSION['calorias_diarias']+500;
        $subir_1k=$_SESSION['calorias_diarias']+1000;
        

        echo '<div style="width:800px;border:2px solid lightgray;margin:auto;padding:35px;background-color:DAF3FB">';
        echo'<h1 style="text-align:center;">Calculadora de calorias</h1>';
        echo '<br>';
        echo '<br>';
            echo '<p>Necesita <b>'.$_SESSION['calorias_diarias'].'</b> kilo calorias (kcal) diarias para mantener el peso.</p>';
            echo '<p><b>'.$bajar_05k.'</b> kilo calorias (kcal) al día hay que consumir para bajar de peso 0.5 kg. a la semana.</p>';
            echo '<p><b>'.$bajar_1k.'</b> kilo calorias (kcal) al día hay que consumir para bajar de peso 1 kg. a la semana.</p>';
            echo '<p><b>'.$subir_05k.'</b> kilo calorias (kcal) diarias para ganar 0.5 kg. a la semana.</p>';
            echo '<p><b>'.$subir_1k.'</b> kilo calorias (kcal) diarias para ganar 1 kg. a la semana.</p>';
            echo '<p style="text-align: center;"><a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary"  > Volver</a></p>';    
        echo '</div>';

    }else{

        $TMB=655 + (9.6 * $peso) + (1.8 * $altura) - (4.7 * $edad);
        $_SESSION['calorias_diarias']=($TMB * $actividad_diaria)-75;
        $bajar_05k=$_SESSION['calorias_diarias']-500;
        $bajar_1k=$_SESSION['calorias_diarias']-1000;
        $subir_05k=$_SESSION['calorias_diarias']+500;
        $subir_1k=$_SESSION['calorias_diarias']+1000;
        
        
        echo '<div style="width:800px;border:2px solid lightgray;margin:auto;padding:35px;background-color:#DAF3FB">';
        echo'<h1 style="text-align:center;">Calculadora de calorias</h1>';
        echo '<br>';
        echo '<br>';
            echo '<p>Necesita <b>'.$_SESSION['calorias_diarias'].'</b> kilo calorias (kcal) diarias para mantener el peso.</p>';
            echo '<p><b>'.$bajar_05k.'</b> kilo calorias (kcal) al día hay que consumir para bajar de peso 0.5 kg. a la semana.</p>';
            echo '<p><b>'.$bajar_1k.'</b> kilo calorias (kcal) al día hay que consumir para bajar de peso 1 kg. a la semana.</p>';
            echo '<p><b>'.$subir_05k.'</b> kilo calorias (kcal) diarias para ganar 0.5 kg. a la semana.</p>';
            echo '<p><b>'.$subir_1k.'</b> kilo calorias (kcal) diarias para ganar 1 kg. a la semana.</p>';
            echo '<p style="text-align: center;"><a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary"  > Volver</a></p>';
        echo '</div>';
    }

}else {
    
    echo '<form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post" enctype="multipart/form-data">';

        echo '<div class="shadow-lg p-3 mb-5 bg-white rounded" style="width:400px;border:2px solid lightgray;margin:auto;padding:25px;margin-top:50px;">';

            echo'<h1 style="text-align:center;">Calculadora de calorias</h1>';
            echo '<br>';
            echo '<br>';
            echo '<label><b>Sexo</b></label><br>';
            echo '<input type="radio" name="sex" class="w3-radio" value="H"   checked >Hombre</input><br>';
            echo '<input type="radio" name="sex" class="w3-radio" value="M" >Mujer</input><br><br>';

            echo '<label><b>Introduzca su peso en Kilogramos</b></label><br>';
            echo '<input type="number" name="peso" required class="form-control" step="0.01"><br>';

            echo '<label><b>Introduzca su altura en Centimetros</b></label><br>';
            echo '<input type="number" name="altura" required class="form-control"><br>';

            echo '<label><b>Introduzca su edad</b></label><br>';
            echo '<input type="number" name="edad" required class="form-control"><br>';

            echo '<label for="plazo"><b>¿Cual es su actividad diaria?</b></label><br>';

            echo '<select name="actividad_diaria" class="form-control">';
                echo '<option value="1">Poco o ningún ejercicio</option>';
                echo '<option value="2"> Ejercicio ligero (1 a 3 días a la semana)</option>';
                echo '<option value="3">Ejercicio moderado (3 a 5 días a la semana)</option>';
                echo '<option value="4"> Deportista (6 -7 días a la semana)</option>';
                echo '<option value="5">Atleta (Entrenamientos mañana y tarde)</option>';
            echo '</select><br>';

            echo '<p style="text-align:center">';
                echo '<input type="submit" name="Enviar" value="Enviar" class="btn btn-success" >'; 
                echo '<a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>';
            echo '</p>';

        echo '</div>';

    echo '</form>';

}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

