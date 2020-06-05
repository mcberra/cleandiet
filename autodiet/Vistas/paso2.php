<?php require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! ?>
<?php require_once VIEW_PATH."header.php"; ?>
<?php require_once UTILITY_PATH."funciones.php"; ?>
<?php
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if ($_SESSION['paso1'] != "completada") {
    header("location: paso1.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

    $tipo_dieta=filtrado($_POST["tipo_dieta"]);

    $_SESSION['tipo_dieta']=$tipo_dieta;

    if (isset($_SESSION['tipo_dieta'])) {
        $_SESSION['paso2'] = "completada";
    }

    if ($_SESSION['paso2'] == "completada") {
        header("location: paso3.php");
    }
}
?>
<style>
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

<style>


h1.tipo{
       text-align:center;
       font-size:bolder;
       margin-bottom:65px;
   }

div#box2 {
  display: inline-block;
}

.prog{
    width:500;
    margin: auto;
    text-align:center;
   
}
    
</style> 
<h1 class="tipo">Elige el tipo de dieta</h1>


<div class='all' style="margin-left:330px;">
    <div class="card" style="width: 24%;margin-left:20px;margin-right:20px;height:" id='box2'>
        <img src="/autodiet/imagenes/real_food.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><b>Dieta real food</b></h5>
            <p class="card-text">Se trata de la ‘Real Food’ (comida real) y se basa en un principio muy sencillo: comer alimentos lo menos procesados posibles. Es decir, alimentos “reales”. La comida real incluye todos los alimentos frescos, cuyo procesamiento ha sido mínimo (lavado, cortado o congelado).</p>
            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type=hidden name="tipo_dieta" value="real_food">
                <p style="text-align:center;margin-top:45px;">
                <input type="submit" name="Enviar" value="Elegir y continuar" class="btn btn-success">
                </p>
            </form>
        </div>
    </div>

    <div class="card" style="width: 24%;margin-left:20px;margin-right:20px;" id='box2'>
        <img src="/autodiet/imagenes/flexible2.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><b>Dieta flexible</b></h5>
            <p class="card-text">Propone perder peso basándose en la siguiente teoría: no hacen falta menús estrictos ni desterrar ningún alimento, sino que puedes adaptar tu alimentación a tus gustos siempre que encaje en los macronutrientes (alorías, proteínas, hidratos, grasas, fibra).</p>
            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type=hidden name="tipo_dieta" value="flexible">
                <p style="text-align:center;margin-top:45px;">
                <input type="submit" name="Enviar" value="Elegir y continuar" class="btn btn-success">
                </p>
            </form>
        </div>
    </div>

    <div class="card" style="width: 24%;margin-left:20px;margin-right:20px;" id='box2'>
        <img src="/autodiet/imagenes/vegetariana.jpg" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><b>Dieta vegetariana</b></h5>
            <p class="card-text">El vegetarianismo es una forma de alimentarse que excluye los alimentos de origen animal. Las dietas vegetarianas se caracterizan por ser ricas en vegetales, cereales integrales y legumbres, y en ellas destaca el consumo de semillas, germinados, soja y sus derivados.</p>
            <form role="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <input type=hidden name="tipo_dieta" value="vegetariana">
                <p style="text-align:center;margin-top:45px;">
                <input type="submit" name="Enviar" value="Elegir y continuar" class="btn btn-success">
                </p>
            </form>
        </div>
    </div>
</div>

<div class="prog">
    
    <h5>Creacion de dieta paso 2 de 5</h5>

    <div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 20%"></div>
    </div>

</div>

<p style="text-align:center">
    <button type="button" class="btn btn-lg btn-info" data-toggle="popover" title="Explicacion del paso 2" data-content="En este paso
     debe indicar el tipo de dieta que quiere seguir.">Instrucciones</button>
</p>

<p style="text-align:center;margin-top:45px;">
<a href="/autodiet/Vistas/Paso1.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>
</p>

<script src="http://code.jquery.com/jquery-latest.js"></script>
</script>
<script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover()
})
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
