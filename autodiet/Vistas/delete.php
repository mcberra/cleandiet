<?php
//en esta pagina podemos borrar a los usuarios de la BBDD
        require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";
        require_once CONTROLLER_PATH."ControladorAlumno.php";
        require_once CONTROLLER_PATH."ControladorImagen.php";
        require_once UTILITY_PATH."funciones.php";
        require_once CONTROLLER_PATH."ControladorBD.php";
        require_once MODEL_PATH."alumno.php";

        error_reporting(E_ERROR | E_WARNING | E_PARSE);

        session_start();//seguro de la pagina
        if (!isset($_SESSION['USUARIO']['email'])) {
          header("location: /autodiet/Vistas/Login.php");
        }
        if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='no'){
          header("location: /autodiet/Vistas/Login.php");
        } 

       /**************************seguro************************************************************** */
        
        // Obtenemos los datos del alumno que nos vienen de la página anterior
        if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
            // Cargamos el controlador de alumnos
            $id = decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $usuario = $controlador->buscarAlumno($id);
            if (is_null($usuario)) {
                // hay un error
                header("location: /autodiet/Vistas/Login.php");
                exit();
            }
        }
        
        
        // Los datos del formulario al procesar el sí.
        if (isset($_POST["id"]) && !empty($_POST["id"])) {
            $controlador = ControladorAlumno::getControlador();
            $usuario = $controlador->buscarAlumno($_POST["id"]);

            if ($controlador->borrarAlumno($_POST["id"])) {
                $borra = true;
               // Debemos borrar la foto del alumno
               $controlador = ControladorImagen::getControlador();
               if($controlador->eliminarImagen($usuario->getImagen())){
                    
                    header("location: /autodiet/indexAD.php");
                   
               }else{
                header("location: /autodiet/Vistas/Login.php");
                    
                }
            } else {
                header("location: /autodiet/Vistas/Login.php");
                
            }
        } 
        
        
        if($borra == true){
                //echo $usuario->getEmail();
               $email = $usuario->getEmail();
               $bd = ControladorBD::getControlador();
               $bd->abrirBD();
               $consulta = "DELETE  FROM sesion WHERE email = :email";
               $parametros = array(':email' => $email);
               $estado = $bd->actualizarBD($consulta,$parametros);
               echo $email;
               $bd->cerrarBD();
        }
?>

<?php require_once VIEW_PATH."header.php"; ?>
<style>
	#centrar
	{
        margin: 0 auto;
        padding:50px;
	}
</style>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div class="w3-card-4" style='width:35%;margin-top:25px' id="centrar"  >
<img  src='<?php echo "../imagenes/" . $usuario->getImagen() ?>' alt="Alps" style="width:50%;float:right">
            
    
                           
                               
                        <label><b>Nombre</b></label>
                        <p class="form-control-static"><?php echo $usuario->getNombre(); ?></p>

                        <label><b>Apellido</b></label>
                        <p class="form-control-static"><?php echo $usuario->getApellido(); ?></p>
                              
  

                        <label><b>Email</b></label>
                            <p class="form-control-static"><?php echo $usuario->getEmail(); ?></p>
                
                        <label><b>Contraseña</b></label>
                        <p class="form-control-static"><?php echo str_repeat("*",strlen($usuario->getPassword())); ?></p>
            
                        <label><b>Admin</b></label>
                            <p class="form-control-static"><?php echo $usuario->getAdmin(); ?></p>
                  
                        <label><b>Telefono</b></label>
                            <p class="form-control-static"><?php echo $usuario->getTelefono(); ?></p>
               
               
                        <label><b>Fecha</b></label>
                            <p class="form-control-static"><?php echo $usuario->getFecha(); ?></p>
                  
                <!-- Me llamo a mi mismo pero pasando GET -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="w3-panel w3-pale-red w3-border">
                        <input type="hidden" name="id" value="<?php echo trim($id); ?>"/>
                        <p>¿Está seguro que desea borrar este alumno/a?</p><br>
                        <p>
                            <button type="submit" class="w3-btn w3-red w3-border  w3-round-large">   Borrar</button>
                            <a href="/autodiet/indexAD.php" style="text-decoration:none" class="w3-btn w3-blue w3-border  w3-round-large"> Volver</a>
                        </p>
                    </div>
                </form>
</div>
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