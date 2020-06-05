<?php
// Incluimos el controlador a los objetos a usar
require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";

error_reporting(E_ERROR | E_WARNING | E_PARSE);

session_start();
if (!isset($_SESSION['USUARIO']['email'])) {
  header("location: /autodiet/Vistas/Login.php");
}

$id_pasado = decode($_GET["id"]);
$controlador = ControladorAlumno::getControlador();
$usuario = $controlador->buscarAlumno($id_pasado);
if (!is_null($usuario)) {
    $nombre = $usuario->getNombre();
    $apellido = $usuario->getApellido();
    $email = $usuario->getEmail();
    $pass_actual = $usuario->getPassword();
    $admin = $usuario->getAdmin();
    $telefono = $usuario->getTelefono();
    $fecha = $usuario->getFecha();
    $imagen = $usuario->getImagen();
    $imagenAnterior = $imagen;
}


    
/*********************************************************seguro************************************************************** */

$nombre = $apellido = $email = $password = $admin = $telefono  = $fecha = $imagen ="";
$imagenAnterior = "";

// Procesamos la información obtenida por el get
    if(isset($_POST["id"]) && !empty($_POST["id"])){

            $id = $_POST["id"];
            $nombre=filtrado($_POST["nombre"]);
            $apellido=filtrado($_POST["apellido"]);
            $email=filtrado($_POST["email"]);
            $admin=filtrado($_POST["admin"]);
            $telefono=filtrado($_POST["telefono"]);
            $password=filtrado($_POST["password"]);


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
foreach ($temp_usu as $a) {
    $a = array_shift($temp_usu);

    array_push($array_usu,$a);
}


if (isset($usuario) && $array_usu[0] != $_SESSION['USUARIO']['email'][2]) {//no permite que se añadan emails que existan, solo si es el del propio usario.
    
        alerta("El e-mail que introdujo ya existe.");
        $emailerr = $emailerr+1;
    
}


/*----------------------------------------------COMPROBACION PASSWORD-----------------------------------------------------------------*/

$passwordErr = 0;

if(!empty($password)){
    $password=filtrado($_POST["password"]);
    $password= hash('sha256',$password);
} else{
    $password = $pass_actual;
}
//si la password enviada es distinta a la de la BBDD, que la cambie y le aplique cifrado sha256
                       
/*----------------------------------------------COMPROBACION FECHA-----------------------------------------------------------------*/


$fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
$hoy = date("d-m-Y",time());
$fechaerr = 0;
$fecha_mat = new Datetime($fecha);
$fecha_hoy = new Datetime($hoy);
$intervalo = $fecha_hoy->diff($fecha_mat);
if($intervalo->format('%R%a dias')>0){
    $fechaerr = $fechaerr+1;
    alerta("La fecha no puede ser superior a la fecha actual");
}


  
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
            header("location: /autodiet/indexAD.php");
            exit();
        }else{
            //header("location: /games/Vistas/error.php");
            alerta( "Error no act");
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
            //header("location: /games/Vistas/error.php");
            alerta( "Error get 1");
            exit();
    }
}else{
alerta( "Error get 2");                   
//header("location:/games/Vistas/error.php");
exit();
}

if ($id != $_SESSION['USUARIO']['email'][2] ) {
    header("location: /autodiet/Vistas/login.php");
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
		background-image:url("/autodiet/imagenes/fondo16.jpg");
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


<?php require_once VIEW_PATH."header.php"; ?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<div  class="form">
    <div class="w3-card-4" style='width:32%;background-color:white' id="centrar">
    <h1 style="text-align:center" class='w3-btn w3-white w3-border w3-border-grey w3-round-large'><b>Configuracion de perfil</b></h1><br><br><br><br>
        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" enctype="multipart/form-data">
            <table>
                <tr>
                    <td class="col-xs-11" class="align-top">
                        <!-- DNI-->
                        
                    <!-- Nombre-->
                    <label class="w3-animate-zoom"><b>Nombre</b></label><br>
                    <input type="text" name="nombre" class="w3-input" value="<?php echo $nombre; ?>"><br><br>

                    <!-- APELLIDO-->
                    <label class="w3-animate-zoom"><b>Apellido</b></label><br>
                    <input type="text" name="apellido" class="w3-input" value="<?php echo $apellido; ?>"><br><br>
                            
                    
                    </td>
                    <!-- Fotogrsfía -->
                    <td class="align-left">
                        <label class="w3-animate-zoom"><b>Fotografía</b></label><br>
                        <img src='<?php echo "/games/admin/usuario/imagenes/" . $usuario->getImagen() ?>' class='rounded w3-animate-zoom' class='img-thumbnail' width='48' height='auto'>
                    </td>
                </tr>
            </table>

                

                <!-- Email -->
    
                    <label class="w3-animate-zoom"><b>E-Mail</b></label><br>
                    <input type="email" required name="email" class="w3-input" value="<?php echo $email; ?>"><br>
                    

                    <label class="w3-animate-zoom"><b>Password</b></label>
                    <p style="color:red">*Solo introduzca una contraseña si desea cambiarla*</p>
                    <input type="password" name="password"  class="w3-input"  placeholder="Solo introduzca una contraseña si desea cambiarla"
                        ><br>
                
            <label><b>Administrador</b></label><br>
            <!-- no permitimos que se auto configure el tipo de usuario a menos que sea admin -->
                <?php if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='si') {   ?>
            
            <input type="radio" name="admin" class="w3-radio" value="si" <?php echo (strstr($admin, 'si')) ? 'checked' : ''; ?>>si</input>
            <input type="radio" name="admin" class="w3-radio" value="no" <?php echo (strstr($admin, 'no')) ? 'checked' : ''; ?>>no</input><br> 

                <?php }else{?>  
            <input type="radio" name="admin" class="w3-radio" value="no" <?php echo (strstr($admin, 'no')) ? 'checked' : ''; ?>>no</input><br>
            <?php }?> 
                <!-- Matrícula -->
                
                <label class="w3-animate-zoom"><b>Telefono</b></label><br>
                    <input type="tel" required name="telefono"  class="w3-input" value="<?php echo $telefono; ?>"><br>
                
        
                <!-- Fecha-->
    
                <label class="w3-animate-zoom"><b>Fecha de Matriculación</b></label><br>
                    <input type="date" disabled name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"></input><br><br>
                
            
                <!-- Foto-->
                
                <label class="w3-animate-zoom"><b>Fotografía</b></label><br>
                <!-- Solo acepto imagenes jpg -->
                <input type="file" name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"> <br>
                
            
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <input type="hidden" name="imagenAnterior" value="<?php echo $imagenAnterior; ?>"/>
                <button type="submit" value="Enviar" class="w3-btn w3-white w3-border w3-border-green w3-round-large"> </span>  Modificar</button>
                <a href="/autodiet/indexAD.php" class="w3-btn w3-white w3-border w3-border-green w3-round-large" style="text-decoration:none"></span> Volver</a>
         </form><br>
     </div>
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