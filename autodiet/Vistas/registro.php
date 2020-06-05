
<?php
//en esta pagina los usuarios se pueden registrar a nuestra web
require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";
require_once CONTROLLER_PATH."ControladorAlumno.php";
require_once CONTROLLER_PATH."ControladorImagen.php";
require_once UTILITY_PATH."funciones.php";
require_once CONTROLLER_PATH."ControladorBD.php";
require_once MODEL_PATH."alumno.php";


    

     $nombre =$apellido = $email = $password = $admin = $telefono  = $fecha = $imagen ="";

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

        
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

    /*----------------------------------------------COMPROBACION APELLIDO-----------------------------------------------------------------*/

    $apellidoerr = 0;
    if(empty($apellido)){
        alerta("El apellido que introdujo esta en blanco.");
        $apellidoerr = $apellidoerr+1; 
    } 

    $formatoapellido=preg_match('/([^\s][A-zÀ-ž\s]+$)/', $apellido);
    if ($formatoapellido==0) {
        $apellidoerr = $apellidoerr+1; 
        alerta("El apellido que introdujo no cumple con el formato requerido.");
        
    }
/*----------------------------------------------COMPROBACION EMAIL-----------------------------------------------------------------*/

$emailerr = 0;
if(empty($email)){
    alerta("El nombre que introdujo esta en blanco.");
    $emailerr = $emailerr+1; 
} 

$controlador = ControladorAlumno::getControlador();
$item = $controlador->buscarDuplicado($email);
if(isset($item)){
   alerta("El e-mail que introdujo ya existe.");
   $emailerr = $emailerr+1;
}

/*----------------------------------------------COMPROBACION PASSWORD-----------------------------------------------------------------*/
$passwordErr = 0;
$password = filtrado($_POST["password"]);
if(empty($password) || strlen($password)<5){
    $passwordErr = $passwordErr+1;
    alerta("Por favor introduzca password válido y que sea mayor que 5 caracteres.");
} else{
    $password= hash('sha256',$password);
}


/*----------------------------------------------COMPROBACION Telefono-----------------------------------------------------------------*/

$telefonoerr = 0;
if(empty($telefono)){
    alerta("El nombre que introdujo esta en blanco.");
    $telefonoerr = $telefonoerr+1; 
} 

$controlador = ControladorAlumno::getControlador();
$item = $controlador->buscarDuplicadoTel($telefono);
if(isset($item)){
   alerta("El telefono que introdujo ya existe.");
   $telefonoerr = $telefonoerr+1;
}

$formatotelefono=preg_match('/([0-9]{3}-[0-9]{3}-[0-9])/', $telefono);
if ($formatotelefono==0) {
    $telefonoerr = $telefonoerr+1; 
    alerta("El telefono que introdujo no cumple con el formato requerido.");
    
}
                       
/*----------------------------------------------COMPROBACION FECHA-----------------------------------------------------------------*/

$fecha = date("d-m-Y", strtotime(filtrado($_POST["fecha"])));
$hoy =date("d-m-Y",time());
$fechaerr = 0;
$fecha_mat = new Datetime($fecha);
$fecha_hoy = new Datetime($hoy);
$intervalo = $fecha_hoy->diff($fecha_mat);
if($intervalo->format('%R%a dias')>0){
    $fechaerr = $fechaerr+1;
    alerta("La fecha no puede ser superior a la fecha actual");
}

  
/*----------------------------------------------COMPROBACION IMAGEN-----------------------------------------------------------------*/

      // Procesamos la foto
      $propiedades = explode("/", $_FILES['imagen']['type']);
      $extension = $propiedades[1];
      $tam_max = 500000; // 50 KBytes
      $tam = $_FILES['imagen']['size'];
      $imagenerr = 0;
      //print_r ($propiedades);
      //print_r ($tam);
      // Si no coicide la extensión
      if($extension != "jpg" && $extension != "jpeg"){
          alerta("Formato debe ser jpg/jpeg");
          $imagenerr = $imagenerr+1;
      }
      // si no tiene el tamaño
      if($tam>$tam_max){
          alerta("Tamaño superior al limite de: ". ($tam_max/1000). " KBytes");
          $imagenerr = $imagenerr+1;
          
      }
  
      // Si todo es correcto, mod = true
      if($imagenerr == 0){
          // salvamos la imagen
          $imagen = md5($_FILES['imagen']['tmp_name'] . $_FILES['imagen']['name'].time()) . "." . $extension;
          $controlador = ControladorImagen::getControlador();
          if(!$controlador->salvarImagen($imagen)){
              alerta( "Error al procesar la imagen y subirla al servidor");
              $imagenerr = $imagenerr+1;
              echo "salvar imagen entro";
          }
      }
                    
/*-----------------------------------------------------------------------------------------------------------------------------*/           

            
      
        if (   $nombreerr == 0 && $mod = true && $emailerr == 0 && $passwordErr == 0  && $fechaerr == 0
        && $imagenerr == 0 && $telefonoerr == 0 && $apellidoerr == 0) {
        $controlador = ControladorAlumno::getControlador();
        $estado = $controlador->almacenarAlumno( $nombre, $apellido, $email, $password, $admin, $telefono, $fecha, $imagen);
        if($estado){
            //El registro se ha lamacenado corectamente
            //alerta("Alumno/a creado con éxito");
            header("location: /autodiet/indexAD.php");
            exit();
        }else{
            header("location: error.php");
            exit();
        }
    }

}else{
    $admin="no";
    $fecha = date("Y-m-d");
}

        
//pattern="([^\s][A-zÀ-ž\s]+)"
        
 

  

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

    <h1  style="text-align:center"><b>Formulario de resgistro</b></h1>
            <br><br><br>
               
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                       
                        
    <div class="container contact">
        <div class="row">
            <div class="col-md-3">
                <div class="contact-info">


                </div>
            </div>
            
            <div class="col-md-9">
                <div class="contact-form">
                    <div class="form-group">
                    <label class="control-label col-sm-2" for="fname">Nombre:</label>
                        <div class="col-sm-10">          
                            <input type="text" required name="nombre"  class="w3-input" value="<?php echo $nombre; ?>" 
                            title="El nombre no puede contener números" minlength="1"><br>
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="lname">Apellidos</label>
                        <div class="col-sm-10">          
                            <input type="text" required name="apellido"  class="w3-input" value="<?php echo $apellido; ?>" 
                            title="Los apellido no puede contener números" minlength="1"><br>
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="email">E-Mail:</label>
                        <div class="col-sm-10">
                                    <input type="email" required name="email"  class="w3-input" value="<?php echo $email; ?>"><br>
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Password:</label>
                        <div class="col-sm-10">
                            <input type="password" required name="password"  class="w3-input" value="<?php //echo $password; ?>" minlength="5" ><br>
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Telefono:</label>
                        <div class="col-sm-10">
                            <input type="tel" required name="telefono"  class="w3-input" value="<?php echo $telefono; ?>"><br>
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Fecha de Alta:</label>
                        <div class="col-sm-10">
                            <input   input type="date" required disabled name="fecha" value="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));?>"></input><br><br>
                        </div>
                    </div>

                    <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Fotografía:</label>
                        <div class="col-sm-10">
                            <input type="file" required name="imagen" class="form-control-file" id="imagen" accept="image/jpeg"><br> 
                        </div>
                    </div>

                    <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <p style="text-align:center">
                            <button type="button" class="btn btn-lg btn-info" data-toggle="popover" title="Informacion" data-content=" La imagen debe ser jpg. ">Informacion</button>
                        </p>
                        <p style="text-align:center">
                            <input type="submit" name="Enviar" value="Calcular" class="btn btn-success" >
                            <a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>
                        </p>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="admin" checked class="w3-radio" value="no" <?php echo (strstr($admin, 'no')) ? 'checked' : ''; ?>>

</form>




                    

            

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
