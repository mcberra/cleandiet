<?php
// Incluimos el controlador a los objetos a usar
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

/***************************************seguro******************************************************************** */

$nombre =$apellido = $email = $password = $admin = $telefono  = $fecha = $imagen ="";
$imagenAnterior = "";
 
// Procesamos la información obtenida por el get
    if(isset($_POST["id"]) && !empty($_POST["id"])){
            $id = $_POST["id"];
            
            $nombre=filtrado($_POST["nombre"]);
            $apellido=filtrado($_POST["apellido"]);
            $email=filtrado($_POST["email"]);
            $admin=filtrado($_POST["admin"]);
            $telefono=filtrado($_POST["telefono"]);
        


/*----------------------------------------------COMPROBACION NOMBRE-----------------------------------------------------------------*/

            $nombreerr = 0;
            if(empty($nombre)){
                alerta("El nombre que introdujo esta en blanco.");
                $nombreerr = $nombreerr+1; 
            } 

            $formatonombre=preg_match('/([^\s][A-zÀ-ž\s]+$)/', $nombre);
            if ($formatonombre==0) {
                $nombreerr = $nombreerr+1; 
                alerta("El nombre que introdujo no cumple con el formato requerido.");
                
            }
/*----------------------------------------------COMPROBACION EMAIL-----------------------------------------------------------------*/

$emailerr = 0;
if(empty($email)){
    alerta("El email que introdujo esta en blanco.");
    $emailerr = $emailerr+1; 
} 



/*----------------------------------------------COMPROBACION PASSWORD-----------------------------------------------------------------*/
$passwordErr = 0;
$password = $_SESSION['USUARIO']['email'][8];
if(empty($password) || strlen($password)<5){
    $passwordErr = $passwordErr+1;
    alerta("Por favor introduzca password válido y que sea mayor que 5 caracteres.");
} 


                       
/*----------------------------------------------COMPROBACION FECHA-----------------------------------------------------------------*/

$controlador = ControladorAlumno::getControlador();
$usuario = $controlador->buscarDuplicadoEmail($email);

function objectToArray2 ( $usuario ) {

    if(!is_object($usuario) && !is_array($usuario)) {

    return $usuario;

    }
    
    return array_map( 'objectToArray2', (array) $usuario );

}

$temp_usu = objectToArray2($usuario);

$array_usu = [];
foreach ($temp_usu as $a) {//obtenemos todos los datos de un usuario en base a su email
    $a = array_shift($temp_usu);

    array_push($array_usu,$a);
}

 $fecha = $array_usu[7];//obtenemos la fecha de alta directamente de la BBDD

  
/*----------------------------------------------COMPROBACION IMAGEN-----------------------------------------------------------------*/
if($_FILES['imagen']['size']>0 && count($errores)==0){
    $propiedades = explode("/", $_FILES['imagen']['type']);
    $extension = $propiedades[1];
    $tam_max = 5000000; // 50 KBytes
    $tam = $_FILES['imagen']['size'];
    $mod = true;
    // Si no coicide la extensión
    if($extension != "jpg" && $extension != "jpeg"){
        $mod = false;
        $imagenErr= "Formato debe ser jpg/jpeg";
    }
    // si no tiene el tamaño
    if($tam>$tam_max){
        $mod = false;
        $imagenErr= "Tamaño superior al limite de: ". ($tam_max/1000). " KBytes";
    }

    // Si todo es correcto, mod = true
    if($mod){
        // salvamos la imagen
        $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'].time()) . "." . $extension;
        $controlador = ControladorImagen::getControlador();
        if(!$controlador->salvarImagen($imagen)){
            $imagenErr= "Error al procesar la imagen y subirla al servidor";
        }

        // Borramos la antigua
        $imagenAnterior = trim($_POST["imagenAnterior"]);
        if($imagenAnterior!=$imagen){
            if(!$controlador->eliminarImagen($imagenAnterior)){
                $imagenErr= "Error al borrar la antigua imagen en el servidor";
            }
        }
    }else{
    // Si no la hemos modificado
        $imagen=trim($_POST["imagenAnterior"]);
    }

}else{
    $imagen=trim($_POST["imagenAnterior"]);
}
                    
/*-----------------------------------------------------------------------------------------------------------------------------*/
if (   $nombreerr == 0 && $mod = true && $emailerr == 0 && $passwordErr == 0  && $fechaerr == 0 ) {        
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->actualizarAlumno($id, $nombre, $apellido, $email, $password, $admin, $telefono, $fecha, $imagen);
        if($estado){
            header("location: /autodiet/lista_usuario.php");
            exit();
        }else{
            header("location: /autodiet/Vistas/error.php");
        exit();
        }
                        
        }
}//se cierra aqui
                        
// Comprobamos que existe el id antes de ir más lejos
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id =  decode($_GET["id"]);
            $controlador = ControladorAlumno::getControlador();
            $usuario = $controlador->buscarAlumno($id);
            if (!is_null($usuario)) {
                $nombre = $usuario->getNombre();
                $apellido = $usuario->getApellido();
                $email = $usuario->getEmail();
                $password = $usuario->getPassword();
                $admin = $usuario->getAdmin();
                $telefono = $usuario->getTelefono();
                $fecha = $usuario->getFecha();
                $imagen = $usuario->getImagen();
                $imagenAnterior = $imagen;
        }else{
            header("location: /autodiet/Vistas/error.php");
            exit();
        }
    }else{
                            
        header("location:/autodiet/Vistas/error.php");
        exit();
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
<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
<center><img  src='<?php echo "../imagenes/" . $usuario->getImagen() ?>' alt="Alps" style="width:50%"></center>
                                <!-- DNI-->
                                
                            <!-- Nombre-->
                            <label><b>Nombre</b></label><br>
                            <input type="text" name="nombre" class="w3-input" value="<?php echo $nombre; ?>"><br><br>

                            <!-- APELLIDO-->
                            <label><b>Apellido</b></label><br>
                            <input type="text" name="apellido" class="w3-input" value="<?php echo $apellido; ?>"><br><br>
                                    


                        <!-- Email -->
              
                            <label><b>E-Mail</b></label><br>
                            <input type="email" required name="email" class="w3-input" value="<?php echo $email; ?>"><br>
                            

                            <label><b>Password</b></label><br>
                            <input type="password" required name="password" disabled class="w3-input" value="<?php echo ($password); ?>"
                                readonly><br>
                           
                      
                       
                                <label><b>Administrador</b></label><br>
                            <input type="radio" name="admin" class="w3-radio" value="si" <?php echo (strstr($admin, 'si')) ? 'checked' : ''; ?>>si</input>
                            <input type="radio" name="admin" class="w3-radio" value="no" <?php echo (strstr($admin, 'no')) ? 'checked' : ''; ?>>no</input><br>
                            
                      
                        <!-- Matrícula -->
                        
                        <label><b>Telefono</b></label><br>
                            <input type="tel" required name="telefono"  class="w3-input" value="<?php echo $telefono; ?>"><br>
                           
                   
                        <!-- Fecha-->
              
                        <label><b>Fecha de Matriculación</b></label><br>
                            <input type="date" disabled name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"></input><br><br>
                         
                    
                         <!-- Foto-->
                        
                        <label><b>Fotografía</b></label><br>
                        <!-- Solo acepto imagenes jpg -->
                        <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"> <br>
                         
                     
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                        <button type="submit" value="Enviar" class="w3-btn w3-white w3-border w3-border-green w3-round-large"> </span>  Modificar</button>
                        <a href="/autodiet/Vistas/lista_usuario.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large" style="text-decoration:none"></span> Volver</a>
                    </form>
</div>
     <br>

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