<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authorization_handler.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio</title>
    <!-- Bootstrap -->
    <link href="../Controlador/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../Controlador/assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />

</head>

<style>
    .tab {
        margin-left: 20px;
    }
</style>

<BODY>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Vista/navBar.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="alert alert-danger alert-dismissible hide">

                </div>
                <div class="alert alert-success alert-dismissible hide">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h1 class="text-center">Bienvenido</h1>
                <h3>Resumen de su informacion</h3>
                <p class="text-success "> Sesion iniciada el <strong id="last_seen"> <?php echo getLastSeen() ?></strong>
                    <script></script>
                </p>
                <div class="well">
                    <label class=" control-label">Email</label>
                    <p class="tab" id="email"></p>
                    <label>Roles</label>
                    <p class="tab" id="roles"></p>
                    <label>Nombre</label>
                    <p class="tab" id="name"></p>
                    <label for="lastname">Apellido</label>
                    <p class="tab" id="lastname"></p>
                    <label>Telefono</label>
                    <p class="tab" id="telnumber"></p>
                </div>

            </div>

        </div>
    </div>


    <script src="../Controlador/assets/js/jquery-3.5.1.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/script.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            fillLoggedUserInfo(<?php echo getUserId() ?>);
        });
    </script>
</BODY>

</HTML>