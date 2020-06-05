<?php require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! ?>
<?php require_once VIEW_PATH."header.php"; ?>
<?php require_once UTILITY_PATH."funciones.php"; ?>

<?php

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);



if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

    $peso=filtrado($_POST["peso"]);
    $altura=filtrado($_POST["altura"]);
    $edad=filtrado($_POST["edad"]);
    $sex=filtrado($_POST["sex"]);
    $actividad_diaria=filtrado($_POST["actividad_diaria"]);
    if (isset($_POST["ds"])) {
        $ds=filtrado($_POST["ds"]);
    }else {
        $ds = "no";
    }
    
    $nds=filtrado($_POST["nds"]);

   $_SESSION['peso_paciente']= $peso;
   $_SESSION['altura_paciente']= $altura;
   $_SESSION['edad_paciente']= $edad;
   $_SESSION['sexo_paciente']=  $sex;
   

  
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

    if ($sex == "Hombre") {

        $TMB=66 + (13.7 * $peso) + (5 * $altura) - (6.75 * $edad);
        $_SESSION['calorias_diarias']=($TMB * $actividad_diaria)-75;

        if (empty($ds)) {
            $_SESSION['calorias_diarias']=$_SESSION['calorias_diarias'];
        }else {
            switch ($ds) {
                case 'D':
                    $_SESSION['calorias_diarias']=$_SESSION['calorias_diarias']-$nds;
                    $_SESSION['paso1'] = "completada";
                    break;
        
                case 'S':
                    $_SESSION['calorias_diarias']=$_SESSION['calorias_diarias']+$nds;
                    $_SESSION['paso1'] = "completada";
                    break;

                case 'no':
                        $_SESSION['paso1'] = "completada";
                        break;
                
                default:
                    echo "ERROR";
                    break;
            }
        }


        
    } else{

        $TMB=655 + (9.6 * $peso) + (1.8 * $altura) - (4.7 * $edad);
        $_SESSION['calorias_diarias']=($TMB * $actividad_diaria)-75;

        if (empty($ds)) {
            $_SESSION['calorias_diarias']=$_SESSION['calorias_diarias'];
        }else {
            switch ($ds) {
                case 'D':
                    $_SESSION['calorias_diarias']=$_SESSION['calorias_diarias']-$nds;
                    $_SESSION['paso1'] = "completada";
                    break;
        
                case 'S':
                    $_SESSION['calorias_diarias']=$_SESSION['calorias_diarias']+$nds;
                    $_SESSION['paso1'] = "completada";
                    break;

                case 'no':
                    $_SESSION['paso1'] = "completada";
                    break;
                
                default:
                    echo "ERROR";
                    break;
            }
        }

    }

    if ( $_SESSION['paso1'] == "completada" ) {
        header("location: paso2.php");
    }

}else {

    echo '<h1 style="text-align:center;">Creacion de dieta paso 1 de 5</h1>';
    
echo '<form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post" enctype="multipart/form-data">';

        
    echo '<div class="container contact">';
        echo '<div class="row">';
            echo '<div class="col-md-3">';
                echo '<div class="contact-info">';
                echo '</div>';
            echo '</div>';

            echo '<div class="col-md-9">';

                echo '<div class="contact-form">';

                    echo '<div class="form-group">';
                        echo '<label class="control-label col-sm-2" for="fname">Sexo:</label>';
                        echo '<div class="col-sm-10">';          
                            echo '<input type="radio" name="sex" class="w3-radio" value="Hombre"   checked >Hombre</input><br>';
                            echo '<input type="radio" name="sex" class="w3-radio" value="Mujer" >Mujer</input><br><br>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label class="control-label col-sm-2" for="lname">Peso (kg)</label>';
                        echo '<div class="col-sm-10"> ';         
                            echo '<input type="number" name="peso" required class="form-control" step="0.01"><br>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label class="control-label col-sm-2" for="email">Estatura (cm):</label>';
                        echo '<div class="col-sm-10">';
                            echo '<input type="number" name="altura" required class="form-control"><br>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label class="control-label col-sm-2" for="email">Edad:</label>';
                        echo '<div class="col-sm-10">';
                            echo '<input type="number" name="edad" required class="form-control"><br>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label class="control-label col-sm-2" for="email">Nivel actividad:</label>';
                        echo '<div class="col-sm-10">';
                            echo '<select name="actividad_diaria" class="form-control">';
                                echo '<option value="0"></option>';
                                echo '<option value="1">Poco o ningún ejercicio</option>';
                                echo '<option value="2"> Ejercicio ligero (1 a 3 días a la semana)</option>';
                                echo '<option value="3">Ejercicio moderado (3 a 5 días a la semana)</option>';
                                echo '<option value="4"> Deportista (6 -7 días a la semana)</option>';
                                echo ' <option value="5">Atleta (Entrenamientos mañana y tarde)</option>';
                        echo '</select><br>';
                        echo ' </div>';
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label class="control-label col-sm-2" for="email">Deficit / Superavit:</label>';
                        echo '<div class="col-sm-10">';
                        echo ' <input type="radio" name="ds" class="w3-radio" value="D"    >Deficit</input><br>';
                            echo '<input type="radio" name="ds" class="w3-radio" value="S" >Superávit</input><br><br>';
                        echo ' </div>';
                    echo '</div>';

                    echo '<div class="form-group">';
                        echo '<label class="control-label col-sm-2" for="email">Calorias:</label>';
                        echo '<div class="col-sm-10">';
                            echo '<input type="number" name="nds" step="0.01"  class="form-control"><br>';
                        echo '</div>';
                    echo '</div>';

                    echo '<div class="form-group">   ';     
                        echo ' <div class="col-sm-offset-2 col-sm-10">';
                            echo ' <p style="text-align:center">';
                                echo '  <button type="button" class="btn btn-lg btn-info" data-toggle="popover" title="Explicacion detallada del paso 1" data-content="En este paso debe rellenar
                                los campos con la informacion solicitada y las medidas deben de ser ingresadas en la unidad de medida especificada. Para añadir 
                                un deficit o superavit solo debe de seleccionar una de las dos opciones y indicar el numero de calorias en el campo indicado. Si no desea añadir ninguno
                                solo deje las casillas sin marcar y el numero de calorias en blanco. ">Instrucciones</button>';
                            echo '</p>';
                            echo '<p style="text-align:center">';
                                echo '<input type="submit" name="Enviar" value="Continuar" class="btn btn-success" >';
                                echo '<a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>';
                            echo '</p>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
    echo '</div>';

echo '</form>';

}
?>
<style>
body{
		/* background-color: #deff8b; */
	}
	.contact{
		padding: 4%;
		
	}
	.col-md-3{
		background-image:url("/autodiet/imagenes/fondo12.jpg");
		padding: 4%;
		border-top-left-radius: 0.5rem;
		border-bottom-left-radius: 0.5rem;
	}
	.contact-info{
		margin-top:10%;
	}
	.contact-info img{
		margin-bottom: 15%;
	}
	.contact-info h2{
		margin-bottom: 10%;
	}
	.col-md-9{
		background: #fff;
		padding: 3%;
		border-top-right-radius: 0.5rem;
		border-bottom-right-radius: 0.5rem;
        border:solid 1px lightgray;
	}
	.contact-form label{
		font-weight:600;
	}
	.contact-form button{
		
		color: #fff;
		font-weight: 600;
		width: 25%;
	}
	.contact-form button:focus{
		box-shadow:none;
	}
    .row{
        height: 500px;
        margin-bottom:100px;
        
    }
    
    </style>
    
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



