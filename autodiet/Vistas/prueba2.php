<?php require_once $_SERVER['DOCUMENT_ROOT']."/autodiet/Paths.php";//necesario para visualizar el header dentro de /Vistas!!!! ?>
<?php require_once VIEW_PATH."header.php"; ?>
<?php require_once UTILITY_PATH."funciones.php"; ?>
<?php

?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
body{
    background: -webkit-linear-gradient(left, #0072ff, #00c6ff);
}
.contact-form{
    background: #fff;
    margin-top: 10%;
    margin-bottom: 5%;
    width: 70%;
}
.contact-form .form-control{
    border-radius:1rem;
}
.contact-image{
    text-align: center;
}
.contact-image img{
    border-radius: 6rem;
    width: 11%;
    margin-top: -3%;
    transform: rotate(29deg);
}
.contact-form form{
    padding: 14%;
}
.contact-form form .row{
    margin-bottom: -7%;
}
.contact-form h3{
    margin-bottom: 8%;
    margin-top: -10%;
    text-align: center;
    color: #0062cc;
}
.contact-form .btnContact {
    width: 50%;
    border: none;
    border-radius: 1rem;
    padding: 1.5%;
    background: #dc3545;
    font-weight: 600;
    color: #fff;
    cursor: pointer;
}
.btnContactSubmit
{
    width: 50%;
    border-radius: 1rem;
    padding: 1.5%;
    color: #fff;
    background-color: #0062cc;
    border: none;
    cursor: pointer;
}
</style>
<div class="container contact-form">
            <div class="contact-image">
                <img src="/autodiet/imagenes/calc.png" alt="rocket_contact"/>
            </div>
            <form method="post">
                <h3>Calculadora de grasa corporal</h3>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" name="txtName" class="form-control" placeholder="Indique su peso en Kilogramos (Kg) *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtName" class="form-control" placeholder="Indique su estatura en Centimetros (Cm) *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtName" class="form-control" placeholder="Indique la medida de su cuello (cm) *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtEmail" class="form-control" placeholder="Indique la medida de su cintura (cm) *" value="" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="txtPhone" class="form-control" placeholder="Indique la medida de su cadera en (cm), solo si es mujer *" value="" />
                        </div>

                    </div>
                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <label><b>Sexo</b></label><br>
                            <input type="radio" name="sex" class="w3-radio" value="H"   checked >Hombre</input><br>
                            <input type="radio" name="sex" class="w3-radio" value="M" >Mujer</input><br><br>
                        </div>
                        
                        <div class="form-group">
                            <p style="text-align:center">
                                <input type="submit" name="Enviar" value="Calcular" class="btn btn-success" > 
                                <a href="/autodiet/indexAD.php" style="text-decoration:none" class="btn btn-primary" > Volver</a>
                            </p>
                        </div>

                    </div>
                </div>
            </form>
</div>