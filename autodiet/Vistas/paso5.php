
<?php require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! ?>
<?php require_once VIEW_PATH."header.php"; ?>
<?php require_once UTILITY_PATH."funciones.php"; ?>
<?php



session_start();


if ($_SESSION['paso1'] != "completada"  || $_SESSION['paso2'] != "completada" || $_SESSION['paso3'] != "completada" || $_SESSION['paso4'] != "completada") {
    header("location: paso1.php");
}




if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){
    

    $Desayunos=$_POST["Desayunos"];
    $_SESSION['Desayunos']= $Desayunos;

    $Tentempies=$_POST["tentempies"];
    $_SESSION['Tentempies']= $Tentempies;

    $almuerzos=$_POST["almuerzos"];
    $_SESSION['Almuerzos']= $almuerzos;

    $meriendas=$_POST["meriendas"];
    $_SESSION['Meriendas']= $meriendas;

    $cenas=$_POST["cenas"];
    $_SESSION['Cenas']= $cenas;

    
        if (!empty($Desayunos)) {
            $check_desayuno = "ok";
        }else {
            if ($_SESSION['Desayuno'] == "no") {
                $check_desayuno = "ok";
            }
        }

        if (!empty($Tentempies)) {
            $check_Tentempies = "ok";
        }else {
            
            if ($_SESSION['Tentempie'] == "no") {
                $check_Tentempies = "ok";
                
            }
        }

        if (!empty($almuerzos)) {
            $check_almuerzos = "ok";
        }else {
            if ($_SESSION['Comida'] == "no") {
                $check_almuerzos = "ok";
            }
        }

        if (!empty($meriendas)) {
            $check_meriendas = "ok";
        }else {
            if ($_SESSION['Merienda'] == "no") {
                $check_meriendas = "ok";
            }
        }

        if (!empty($cenas)) {
            $check_cenas = "ok";
        }else {
            if ($_SESSION['Cena'] == "no") {
                $check_cenas = "ok";
            }
        }

        $_SESSION['paso5'] == "completada";


if ($check_desayuno == "ok" && $check_Tentempies == "ok" && $check_almuerzos == "ok" && $check_meriendas == "ok" && $check_cenas == "ok") {
    
    header("location: paso6.php");
}else {
    alerta("Debe elegir almenos 1 plato en cada una de las comidas.");
}


    

}
echo '<h1 style="text-align:center;margin-top:50px; margin-bottom:25px;">Elija los platos que prefiera</h1>';
echo '<div id="mesa" class="shadow-lg p-3 mb-5 bg-white rounded" style="width:1300px;border:2px solid lightgray;margin:auto;padding:25px;margin-top:50px;">';
echo '<div style="margin: auto;width:500px;">';
echo '<h5 style="text-align:center;;">Creacion de dieta paso 5 de 5</h5>';
echo '<div class="progress">';
    echo '<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 80%"></div>';
echo '</div>';
echo '</div>';
    echo '<div class="pad">';
        echo '<form action="'. htmlspecialchars($_SERVER["PHP_SELF"]) .'" method="post" enctype="multipart/form-data">';

        echo '<p style="text-align:center">';
        echo'<button type="button" class="btn btn-lg btn-info" data-toggle="popover" title="Explicacion detallada del paso 5" data-content="En este paso seleccione los platos que
         quiere agregar a su listado de platos para cada comida.">Instrucciones</button>';
        echo '</p>';

        echo '<p style="text-align:center">';
        echo '<input type="submit" name="Enviar" value="Continuar" class="btn btn-success" >';
        echo '<a href="/autodiet/Vistas/paso4.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>';
        echo '</p>';

            if ($_SESSION['Desayuno'] == "Desayuno") {
                echo '<div class="inline">';
                    echo '<label>Elija los platos que desea incluir en sus desayunos</label><br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Avena con leche">Avena con leche<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Tostadas con salmon">Tostadas con salmon<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Tostadas con jamon de pavo">Tostadas con jamon de pavo<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Tostadas con aguacate">Tostadas con aguacate<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Huevos cocidos con tostadas">Huevos cocidos con tostadas<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Huevos fritos con tostadas">Huevos fritos con tostadas<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Tortilla francesa con acelgas">Tortilla francesa con acelgas<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Tortilla francesa con espinacas">Tortilla francesa con espinacas<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Tortilla francesa con esparragos">Tortilla francesa con esparragos<br>';
                        echo '<input type="checkbox" name="Desayunos[]" value="Tortilla francesa con jamon de pavo">Tortilla francesa con jamon de pavo<br>';
                echo '</div>';
            }

            if ($_SESSION['Tentempie'] == "Tentempie") {
                echo '<div class="inline">';
                    echo '<label>Elija los platos que desea incluir en sus Tentempies</label><br>';
                        echo '<input type="checkbox" name="tentempies[]" value="Avena con leche">Avena con leche<br>';
                        echo '<input type="checkbox" name="tentempies[]" value="platano">Platano<br>';
                        echo '<input type="checkbox" name="tentempies[]" value="Yogurt proteico">Yogurt proteico<br>';
                        echo '<input type="checkbox" name="tentempies[]" value="Almendras">Almendras<br>';
                        echo '<input type="checkbox" name="tentempies[]" value="Pistachos">Pistachos<br>';
                        echo '<input type="checkbox" name="tentempies[]" value="Chocolate negro">Chocolate negro 80% cacao<br>';
                echo '</div>';
            }

            if ($_SESSION['Comida'] == "Comida") {
                echo '<div class="inline">';
                    echo '<label>Elija los platos que desea incluir en sus Comidas</label><br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Pollo a la plancha con patatas asadas">Pollo a la plancha con patatas asadas<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Pollo a la plancha con esparragos">Pollo a la plancha con esparragos<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Pollo a la plancha con brocoli">Pollo a la plancha con brocoli<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Salmon a la plancha con patatas asadas">Salmon a la plancha con patatas asadas<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Salmon a la plancha con esparragos">Salmon a la plancha con esparragos<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Salmon a la plancha con brocoli">Salmon a la plancha con brocoli<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Espaguetis con brocoli">Espaguetis con brocoli<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Espaguetis con atun">Espaguetis con atun<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Espaguetis con salsa de tomate">Espaguetis/macarrones con salsa de tomate<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Arroz blanco con pollo">Arroz blanco con pollo<br>';
                        echo '<input type="checkbox" name="almuerzos[]" value="Arroz blanco con solomillo">Arroz blanco con solomillo<br>';
                echo '</div>';
            }

            if ($_SESSION['Merienda'] == "Merienda") {
                echo '<div class="inline">';
                    echo '<label>Elija los platos que desea incluir en sus Meriendas</label><br>';
                        echo '<input type="checkbox" name="meriendas[]" value="Almendras">Almendras<br>';
                        echo '<input type="checkbox" name="meriendas[]" value="Yogurt proteico">Yogurt proteico<br>';
                        echo '<input type="checkbox" name="meriendas[]" value="Pistachos">Pistachos<br>';
                        echo '<input type="checkbox" name="meriendas[]" value="Chocolate negro">Chocolate negro 80% cacao<br>';
                        echo '<input type="checkbox" name="meriendas[]" value="platano">Platano<br>';
                echo '</div>';    
                    
            }

            if ($_SESSION['Cena'] == "Cena") {
                echo '<div class="inline">';
                    echo '<label>Elija los platos que desea incluir en sus Cenas</label><br>';
                    echo '<input type="checkbox" name="cenas[]" value="Espaguetis con brocoli">Espaguetis con brocoli<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Espaguetis con atun">Espaguetis con atun<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Espaguetis con salsa de tomate">Espaguetis/macarrones con salsa de tomate<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Pure de patatas con salmon">Pure de patatas con salmon<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Pure de patatas con atun">Pure de patatas con atun<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Pure de patatas con merluza">Pure de patatas con merluza<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Judias verdes con atun">Judias verdes con atun<br>';
                    echo '<input type="checkbox" name="cenas[]" value="brocoli con atun">brocoli con atun<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Esparragos con solomillo">Esparragos con solomillo<br>';
                    echo '<input type="checkbox" name="cenas[]" value="Acelgas con solomillo">Acelgas con solomillo<br>';
                echo '</div>';
            }




        echo '</form>';
        echo '</div>';

    echo '</div>';
 

?>
<style>
.pad{
    padding:50px;
    min-height:450px;
    
}
.inline {
  /* float:left; */
  width:35%;
  
  border: solid 5px lightblue;
  margin:auto;
  padding:30px;
}
h1{
   
    
}
#mesa{
    background-image:url("/autodiet/imagenes/mesa.jpg");
    color:white;
    font-size:19px;
    font-weight:bolder;
}
</style> 



<script src="http://code.jquery.com/jquery-latest.js"></script>
</script>
<script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>