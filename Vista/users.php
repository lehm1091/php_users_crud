<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authorization_handler.php';
//mark this view as users only
permitUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>

    <!-- Bootstrap -->


    <link rel="stylesheet" type="text/css" href="../Controlador/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../Controlador/assets/css/dataTables.bootstrap.min.css" />
    <link href="../Controlador/assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />


</head>

<body>


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
            <div class="well well-sm">
                <a class="text-primary" id="loggedUserEditLink" title="Editar mi informacion">

                    Editar mi informacion <i class="fa fa-lg fa-pencil-square" style="margin-left: 5px;" aria-hidden="true"></i>
                </a>
                <a id="nuevoUsuario" type="button" class="text-primary" style="margin-left:15px" onclick="openModalForNewUser()" title="Nuevo usuario">
                    Nuevo usuario
                    <i class="fa fa-lg  fa-plus" style="margin-left: 5px;" aria-hidden="true"></i>
                </a>
            </div>


        </div>


        <div class="row">

            <table id="usersTable" class="table table-striped " style="width:100%">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de creacion</th>
                        <th>Ultimo inicio de sesion</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Codigo</th>
                        <th>Email</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Fecha de creacion</th>
                        <th>Ultimo inicio de sesion</th>
                        <th>Acciones</th>

                    </tr>
                </tfoot>
            </table>


        </div>


    </div>




    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Vista/userFormModal.php'; ?>

    <script src="../Controlador/assets/js/jquery-3.5.1.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/dataTables.responsive.min.js" type="text/javascript"></script>
    <script src="../Controlador/assets/js/script.js" type="text/javascript"></script>

    <script>
        ///if role is only admin_role cant change super_role
        if (<?php echo (isAdmin()  and !isSuperAdmin()) ? 1 : 0 ?>) {
            $(".super-check-form-group").remove();
        }

        ///if role is role_user can change only user_role
        if (<?php echo (isUser()  and !isAdmin() and !isSuperAdmin()) ? 1 : 0 ?>) {
            $(".admin-check-form-group").remove();
            $(".super-check-form-group").remove();
            $("#nuevoUsuario").remove();
        }
        ///edit logged user info by id stored in session
        $("#loggedUserEditLink").click(function() {
            editLoggedUserInfo(<?php echo getUserId() ?>);
        });

        //roles are being getting fron the session
        let usersTable = initUserDatatable(
            "usersTable",
            <?php echo (isSuperAdmin()) ? 1 : 0 ?>,
            <?php echo (isAdmin()) ? 1 : 0 ?>);


        $("#email").keyup(function() {
            checkEmail("email");
        });
        $("#name").keyup(function() {
            checkName("name");
        });

        $("#lastname").keyup(function() {
            checkLastName("lastname");
        });
        $("#telnumber").keyup(function() {
            checkTelNumber("telnumber");
        });
    </script>
</body>

</html>