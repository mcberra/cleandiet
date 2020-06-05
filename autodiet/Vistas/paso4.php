<?php require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! ?>
<?php require_once VIEW_PATH."header.php"; ?>
<?php require_once UTILITY_PATH."funciones.php"; ?>
<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    if ($_SESSION['paso1'] != "completada"  || $_SESSION['paso2'] != "completada" || $_SESSION['paso3'] != "completada") {
        header("location: paso1.php");
    }

    if (in_array("Desayuno", $_SESSION['comidas'])) {
        $Desayuno = "Desayuno";
        $_SESSION['Desayuno']= $Desayuno;
        
    }else {
        $_SESSION['Desayuno'] = "no";
    }

    if (in_array("Tentempie", $_SESSION['comidas'])) {
        $Tentempie = "Tentempie";
        $_SESSION['Tentempie']= $Tentempie;
    }else {
        $_SESSION['Tentempie'] = "no";
    }

    if (in_array("Comida", $_SESSION['comidas'])) {
        $Comida = "Comida";
        $_SESSION['Comida']= $Comida;
    }else {
        $_SESSION['Comida'] = "no";
    }

    if (in_array("Merienda", $_SESSION['comidas'])) {
        $Merienda = "Merienda";
        $_SESSION['Merienda']= $Merienda;
    }else {
        $_SESSION['Merienda'] = "no";
    }

    if (in_array("Cena", $_SESSION['comidas'])) {
        $Cena = "Cena";
        $_SESSION['Cena']= $Cena;
    }else {
        $_SESSION['Cena'] = "no";
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

        $porcentaje = 0;

        if (!empty($Desayuno)) {
            $Desayuno=filtrado($_POST["Desayuno"]);
            $_SESSION['porcentaje_Desayuno'] = $Desayuno;
            $porcentaje = $porcentaje + $Desayuno;
            
        }

        if (!empty($Tentempie)) {
            $Tentempie=filtrado($_POST["Tentempie"]);
            $_SESSION['porcentaje_Tentempie'] = $Tentempie;
            $porcentaje = $porcentaje + $Tentempie;
            
        }

        if (!empty($Comida)) {
            $Comida=filtrado($_POST["Comida"]);
            $_SESSION['porcentaje_Comida'] = $Comida;
            $porcentaje = $porcentaje + $Comida;
           
        }

        if (!empty($Merienda)) {
            $Merienda=filtrado($_POST["Merienda"]);
            $_SESSION['porcentaje_Merienda'] = $Merienda;
            $porcentaje = $porcentaje + $Merienda;
            
        }

        if (!empty($Cena)) {
            $Cena=filtrado($_POST["Cena"]);
            $_SESSION['porcentaje_Cena'] = $Cena;
            $porcentaje = $porcentaje + $Cena;
            
        }

        $_SESSION['porcentaje'] = $porcentaje;
        print($_SESSION['porcentaje']);
        if ($porcentaje != 100) {
            alerta("La suma de los procetajes no es del 100%, asegurece que esta asignando los porcentajes correctamente.");
            
        }else {
            $_SESSION['paso4'] = "completada";
            header("location: paso5.php");
            exit();
        }

    }



echo '<h1 style="text-align:center;">Asigne los porcentajes a las comidas</h1>';

    

echo '<form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post" enctype="multipart/form-data" style="padding:30px;">';

    echo '<div class="container contact">';
        echo '<div class="row">';
            echo '<div class="col-md-3">';
                echo '<div class="contact-info">';
                echo '</div>';
            echo '</div>';

            echo '<div class="col-md-9">';

                echo '<div class="contact-form">';

                    if (!empty($Desayuno)) {
                        echo '<div class="form-group">';
                            echo '<label class="control-label col-sm-2" for="fname">Desayuno:</label>';
                            echo '<div class="col-sm-10">';          
                                echo '<input type="number" name="Desayuno" required class="form-control" ><br>';
                            echo '</div>';
                        echo '</div>';
                    }

                    if (!empty($Tentempie)) {
                        echo '<div class="form-group">';
                            echo '<label class="control-label col-sm-2" for="lname">Tentempie:</label>';
                            echo '<div class="col-sm-10"> ';         
                                echo '<input type="number" name="Tentempie" required class="form-control" ><br>';
                            echo '</div>';
                        echo '</div>';
                    }

                    if (!empty($Comida)) {
                        echo '<div class="form-group">';
                            echo '<label class="control-label col-sm-2" for="email">Comida:</label>';
                            echo '<div class="col-sm-10">';
                                echo '<input type="number" name="Comida" required class="form-control" ><br>';
                            echo '</div>';
                        echo '</div>';
                    }

                    if (!empty($Merienda)) {
                        echo '<div class="form-group">';
                            echo '<label class="control-label col-sm-2" for="email">Merienda:</label>';
                            echo '<div class="col-sm-10">';
                                echo '<input type="number" name="Merienda" required class="form-control" ><br>';
                            echo '</div>';
                        echo '</div>';
                    }


                    if (!empty($Cena)) {
                        echo '<div class="form-group">';
                            echo '<label class="control-label col-sm-2" for="email">Cena:</label>';
                            echo '<div class="col-sm-10">';
                                echo '<input type="number" name="Cena" required class="form-control" ><br>';
                            echo '</div>';
                        echo '</div>';
                    }

                    echo '<div class="form-group">   ';     
                        echo ' <div class="col-sm-offset-2 col-sm-10">';
                            echo '<p style="text-align:center">';
                                echo'<button type="button" class="btn btn-lg btn-info" data-toggle="popover" title="Explicacion detallada del paso 4" data-content="En este paso debe asignar un porcentaje de calorias  a cada una de las comidas que hemos seleccionado,
                                por ejemplo, si hemos seleccionado  desayuno, comida y cena podriamos asignar a desayuno 30%, comida 40%, cena 30%. El proceso da 
                                total libertad en la asignacion de porcentajes, EL UNICO REQUISITO es que el total sume 100%.">Instrucciones</button>';
                            echo '</p>';
        
                            echo '<p style="text-align:center">';
                                echo '<input type="submit" name="Enviar" value="Continuar" class="btn btn-success" >';
                                echo '<a href="/autodiet/Vistas/paso3.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>';
                            echo '</p>';
                        echo '</div>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

            echo '<div style="margin: auto;width:500px;">';
            echo '<h5 style="text-align:center;">Creacion de dieta paso 4 de 5</h5>';
            echo '<div class="progress">';
                echo '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div>';
            echo '</div>';
        echo '</div>';
                    
        echo '</div>';
    echo '</div>';

echo '</form>';




?>
<style>body{
		/* background-color: #deff8b; */
	}
	.contact{
		padding: 4%;
		
	}
	.col-md-3{
		background-image:url("/autodiet/imagenes/fondo15.jpg");
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
