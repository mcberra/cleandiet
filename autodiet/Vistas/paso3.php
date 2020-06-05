<?php require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! ?>
<?php require_once VIEW_PATH."header.php"; ?>
<?php require_once UTILITY_PATH."funciones.php"; ?>
<?php
    session_start();
    error_reporting(E_ERROR | E_WARNING | E_PARSE);

    if ($_SESSION['paso1'] != "completada"  || $_SESSION['paso2'] != "completada") {
        header("location: paso1.php");
    }

    if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["Enviar"]){

        $comidas=$_POST["comidas"];
        $_SESSION['comidas']= $comidas;

        
        

        if (!empty($_SESSION['comidas'])) {
            $_SESSION['paso3'] = "completada";
            header("location: paso4.php");
        }else{
            alerta("No ha elegido ninguna comida.");
        }

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
		background-image:url("/autodiet/imagenes/fondo14.jpg");
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
        height: 900px;
        margin-bottom:100px;
        
    }
    
    </style>
<h1 style="text-align:center;">Elija las comidas que va a realizar al dia</h1>


    <form style="text-align:center;" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?> " method="post" enctype="multipart/form-data">
    <br><br>
    <div class="container contact">
	<div class="row">
		<div class="col-md-3">
			<div class="contact-info">


			</div>
		</div>
		<div class="col-md-9">
			<div class="contact-form">
				<div class="form-group">
				  <label class="control-label col-sm-2" for="fname">Opciones:</label>
				  <div class="col-sm-10">          
                  
                        <input type="checkbox" name="comidas[]" value="Desayuno">Desayuno<br>
                        <input type="checkbox" name="comidas[]" value="Tentempie">Tentempie<br>
                        <input type="checkbox" name="comidas[]" value="Comida">Comida<br>
                        <input type="checkbox" name="comidas[]" value="Merienda">Merienda<br>
                        <input type="checkbox" name="comidas[]" value="Cena">Cena<br><br><br>
				  </div>
				</div>

				

				<div class="form-group">        
				  <div class="col-sm-offset-2 col-sm-10">
                    <p style="text-align:center">
                        <button type="button" class="btn btn-lg btn-info" data-toggle="popover" title="Explicacion del paso 3" data-content="En este paso
                        debe indicar las comidas que va a realizar a lo largo del dia,como requisito debe indicar almenos una comida.">Instrucciones</button>
                    </p>

                    <p style="text-align:center">
                        <input type="submit" name="Enviar" value="Continuar" class="btn btn-success" >
                        <a href="/autodiet/Vistas/paso2.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>
                    </p>

				  </div>
				</div>
			</div>
            
		    </div>
                <div style="margin: auto;width:500px">
                    <h5 style="text-align:center;;">Creacion de dieta paso 3 de 5</h5>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 40%"></div>
                    </div><br>
                </div>
	</div>    
</div>


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