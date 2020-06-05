<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<?php
require_once UTILITY_PATH."funciones.php";
session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);


echo '<div style="background-color:white;color:black;height:120px;">';

  echo '<div  style="margin-left:300px;margin-top:15px;margin-bottom:15px;border-left:solid 4px lightgray;">';

    echo '<a href="/autodiet/indexAD.php" style="text-decoration:none;color:black;"><h1 style="margin-left:20px;margin-right:20px;" >A U T O D I E T</h1></a>';
                  
  echo '</div>';
                  
          

  echo '<nav class="navbar navbar-expand-lg navbar-info bg-light">';
    
    echo '<div class="collapse navbar-collapse " id="navbarNavDropdown" style="font-size:16px;margin-left:550px;">';
      echo '<ul class="navbar-nav">';

        echo '<li class="nav-item active">';
          echo '<a class="nav-link" href="/autodiet/indexAD.php" style="font-size:16.5px;"><span class="glyphicon glyphicon-home"> Inicio</span></a>';
        echo '</li>';

        echo '<li class="nav-item dropdown">';
          echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Funcionalidades</a>';

          echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
            echo '<a class="dropdown-item" href="/autodiet/Vistas/calc_calorias.php"><span class="glyphicon glyphicon-expand"> Calculadora de calorias diarias</span></a>';
            echo '<a class="dropdown-item" href="/autodiet/Vistas/calcM.php"><span class="glyphicon glyphicon-expand"> Calculadora de masa corporal</span></a>';
            echo '<a class="dropdown-item" href="/autodiet/Vistas/calcG.php"><span class="glyphicon glyphicon-expand"> Calculadora de grasa corporal</span></a>';
            echo '<a class="dropdown-item" href="/autodiet/Vistas/paso1.php"><span class="glyphicon glyphicon-expand"> Crear dieta</span></a>';
          echo '</div>';

        echo '</li>';

        echo '<li class="nav-item active">';
          echo '<a class="nav-link" href="/autodiet/Vistas/registro.php"> Registrarse</a>';
        echo '</li>';

        if (isset($_SESSION['USUARIO']['email']) && $_SESSION['USUARIO']['email'][1]=='si') {

          echo '<li class="nav-item dropdown">';
            echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Gestion </a>';

            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
              echo '<a class="dropdown-item" href="/autodiet/Vistas/registro.php"><span class="glyphicon glyphicon-user"> Crear usuario</span></a>';
              echo '<a class="dropdown-item" href="/autodiet/Vistas/lista_usuario.php"><span class="glyphicon glyphicon-list-alt"> Listado de usuarios</span></a>';
            echo '</div>';

          echo '</li>';

        }
        

        if (isset($_SESSION['USUARIO']['email'])) {

          
          echo '<li class="nav-item dropdown" style="margin-left:175px;">';
            echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"> '. $_SESSION['USUARIO']['email'][0] .'</span> </a>';

            echo '<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">';
              echo '<a class="dropdown-item" href="/autodiet/Vistas/perfil_config.php?id=' . encode($_SESSION['USUARIO']['email'][2]) . '"><span class="glyphicon glyphicon-edit"> Editar perfil</span></a>';
            echo '</div>';

          echo '</>';

          echo '<li class="nav-item active">';
            echo'<a class="nav-link" href="/autodiet/Vistas/login.php"> | Cerrar session <span class="glyphicon glyphicon-log-out"></span></a>';
          echo '</li>';
        }

        if (!isset($_SESSION['USUARIO']['email'])) {

          echo '<li class="nav-item active" style="margin-left:520px;">';
            echo '<a class="nav-link" href="/autodiet/Vistas/login.php">Log-in <span class="glyphicon glyphicon-log-in"> </span> </a>';
          echo '</li>';
          
        }

      echo '</ul>';
    echo '</div>';
  echo '</nav>';
echo '</div>';
?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

</div>