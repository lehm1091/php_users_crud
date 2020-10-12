<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authorization_handler.php';
//mark this view as users only
permitUsers();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuarios</title>

    <!-- Bootstrap -->


    <link rel="stylesheet" type="text/css" href="../Controlador/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="../Controlador/assets/css/dataTables.bootstrap.min.css" />
    <link href="../Controlador/assets/css/font-awesome.min.css" type="text/css" rel="stylesheet" />


</head>

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
            <div class="well well-sm">
                <a class="text-primary" onclick="editarMiInformacion()" title="Editar mi informacion">

                    Editar mi informacion <i class="fa fa-lg fa-pencil-square" style="margin-left: 5px;" aria-hidden="true"></i>
                </a>
                <a id="nuevoUsuario" type="button" class="text-primary" style="margin-left:15px" onclick="openUserModal()" title="Nuevo usuario">
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
        if (<?php echo (isAdmin()  and !isSuperAdmin()) ? 1 : 0 ?>) {
            $("#superGroup").remove();
        }
        if (<?php echo (isUser()  and !isAdmin() and !isSuperAdmin()) ? 1 : 0 ?>) {
            $("#adminGroup").remove();
            $("#superGroup").remove();
            $("#nuevoUsuario").remove();

        }

        function editarMiInformacion() {
            resetUserForm();
            $(".modal-title").html("Actualizar mi informacion");


            $(".form-check-input").prop("checked", false);
            let roles;
            $.ajax({
                url: '../Controlador/users_controller.php?method=findOne',
                type: 'POST',
                data: {
                    id: <?php echo getUserId() ?>
                },
                beforeSend: () => {

                },

                success: function(response) {
                    $("#email").val(getJsonResponse(response).data.email);
                    $("#id").val(getJsonResponse(response).data.user_id);
                    $("#name").val(getJsonResponse(response).data.first_name);
                    $("#lastname").val(getJsonResponse(response).data.last_name);
                    $("#telnumber").val(getJsonResponse(response).data.tel_number);
                    roles = getJsonResponse(response).data.roles;
                    for (role of roles) {
                        $('#' + role.name).prop("checked", true);
                    }
                },
                error: error => {
                    console.log(error);

                }
            });


            $("#userFormModal").modal();

        }

        function openUserModal() {
            $("#userFormModal").modal();
            $(".modal-title").html("Nuevo Usuario");
            resetUserForm();
        }

        function resetUserForm() {
            $("#email").val("");
            $("#id").val(null);
            $("#name").val("");
            $("#lastname").val("");
            $("#telnumber").val("");
            $("#password").val("");
            $(".form-check-input").prop("checked", false);


        }

        function editUser(id) {

            $(".modal-title").html("Actualizar Usuario");
            $(".form-check-input").prop("checked", false);
            let roles;
            $.ajax({
                url: '../Controlador/users_controller.php?method=findOne',
                type: 'POST',
                data: {
                    id: id
                },
                beforeSend: () => {

                },

                success: function(response) {
                    $("#email").val(getJsonResponse(response).data.email);
                    $("#id").val(getJsonResponse(response).data.user_id);
                    $("#name").val(getJsonResponse(response).data.first_name);
                    $("#lastname").val(getJsonResponse(response).data.last_name);
                    $("#telnumber").val(getJsonResponse(response).data.tel_number);
                    roles = getJsonResponse(response).data.roles;
                    for (role of roles) {
                        $('#' + role.name).prop("checked", true);

                    }
                },
                error: error => {
                    console.log(error);

                }
            });


            $("#userFormModal").modal();

        }



        function deleteUser(id) {

            var r = confirm("Borrar el usario");
            if (r == true) {
                $.ajax({
                    url: '../Controlador/users_controller.php?method=deleteOne',
                    type: 'POST',
                    data: {
                        id: id
                    },
                    beforeSend: () => {},
                    success: function(response) {
                        console.log(response);
                        showSucessAlert(getJsonResponse(response).message);
                        userTable.ajax.reload();
                    },
                    error: error => {
                        console.log(error);
                        showDangerAlert(getJsonResponse(error.responseText).message);

                    }
                });
            }

        }


        //Data table

        let userTable = $('#usersTable').DataTable({
            dom: 'Bfrtip',
            responsive: true,
            "processing": true,
            "serverSide": true,
            "oLanguage": {
                "sSearch": "Buscar"
            },
            "ajax": "../Controlador/user_table_controller.php",
            "columns": [{
                    "data": "0"
                },
                {
                    "data": "1"
                },
                {
                    "data": "2"
                },
                {
                    "data": "3"
                },
                {
                    "data": 4,
                    render: function(data, type, row) {
                        if (type === "sort" || type === "type") {
                            return data;
                        }
                        return converMySqlDate(data);
                    }


                },

                {
                    "data": 5,
                    render: function(data, type, row) {
                        if (type === "sort" || type === "type") {
                            return data;
                        }
                        if (data === null) {
                            return data;
                        }
                        return converMySqlDateTime(data);
                    }
                },

                {
                    data: 0, ///pass id of user from data
                    render: function(data, type, row) {
                        if (type === "sort" || type === "type") {
                            return data;
                        }

                        let edit = `<a class='text-primary editLink' href="#" style="margin-right:20px" onclick="editUser(${data})" ><i class="fa fa-lg  fa-pencil"></i></a>`;
                        let del = `<a class="text-danger deleteLink" id="delete${data}" href="#" onclick="deleteUser(${data})"><i class="fa fa-lg  fa-trash"></i></a>`;
                        if (<?php echo (isAdmin()  and !isSuperAdmin()) ? 1 : 0 ?>) {
                            return `${edit}`;
                        } else if (<?php echo (isSuperAdmin()) ? 1 : 0 ?>) {
                            return `${edit}${del}`;
                        } else {
                            return "Denegado";
                        }

                    }
                }

            ]
        });



        ///// user form

        $(".alert-danger").hide();
        $(".alert-success").hide();
        $("#email").keyup(function() {
            check_email();
        });
        $("#name").keyup(function() {
            check_name();
        });

        $("#lastname").keyup(function() {
            check_lastn();
        });
        $("#telnumber").keyup(function() {
            check_telnumber();
        });

        $('#userForm').submit(
            function(event) {
                const INSERT_URL = '../Controlador/users_controller.php?method=saveOne';
                const UPDATE_URL = '../Controlador/users_controller.php?method=updateOne';
                event.preventDefault();
                const id = $("#id").val();
                $("#email").val($("#email").val().trim());
                $("#name").val($("#name").val().trim());
                $("#lastname").val($("#lastname").val().trim());
                $("#password").val($("#password").val().trim());
                $("#telnumber").val($("#telnumber").val().trim());

                if (check_email() &&
                    check_password() &&
                    check_name() &&
                    check_lastn() &&
                    check_telnumber()) {
                    $.ajax({
                        url: id > 0 ? UPDATE_URL : INSERT_URL, ///update or save taking id as flag
                        type: 'POST',
                        data: $("#userForm").serialize(),
                        beforeSend: () => {
                            $("#userForm .btn").html('<span class="">Cargando...</span>');
                        },

                        success: function(response) {
                            $("#userForm .btn").html('<i class="fa fa-check"></i>');
                            console.log(response);
                            showSucessAlert(getJsonResponse(response).message);
                            userTable.ajax.reload();
                            resetUserForm();

                            setTimeout(function() {
                                $("#userFormModal").modal('hide');
                            }, 500);


                        },
                        error: error => {

                            console.log(error);
                            $("#userForm .btn").html('Login');
                            showDangerAlert(getJsonResponse(error.responseText).message);
                            setTimeout(function() {
                                $("#userFormModal").modal('hide');
                            }, 500);


                        }
                    });
                } else {
                    console.log("form is invalid")
                }


            }
        );

        function check_email() {


            var pattern = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/);
            if (pattern.test($("#email").val())) {
                if ($("#email").val() > 0) {
                    $.ajax({
                        url: "../Controlador/users_controller.php?method=emailExits", ///update or save taking id as flag
                        type: 'POST',
                        data: {
                            email: $("#email").val()
                        },
                        beforeSend: () => {

                        },

                        success: function(response) {
                            console.log(response);
                            showSuccess();
                            return true;

                        },
                        error: error => {
                            console.log(error.responseText.message);
                            showErrors("El email ya existe")
                            return false;
                        }
                    });


                } else {
                    showSuccess();
                    return true;
                }


            } else {

                showErrors("Direccion de correo electronica invalida");
                return false;

            }


            function showErrors(msg) {
                $(".email_error_text").html(msg);
                $(".email_error_text").show();
                $("#emailFormGroup").addClass("has-error");
            }

            function showSuccess() {
                $(".email_error_text").hide();
                $("#emailFormGroup").addClass("has-success has-feedback");
                $("#emailFormGroup").removeClass("has-error");
            }

        }

        function check_name() {
            var name_length = $("#name").val().length;
            if (name_length < 3) {
                $(".name_error_text").html("El nombre debe tener almenos 3 caracteres");
                $(".name_error_text").show();
                $("#nameFormGroup").addClass("has-error has-feedback");

                return false;
            } else {
                $("#nameFormGroup").removeClass("has-error");
                $("#nameFormGroup").addClass("has-success");
                $(".name_error_text").hide();
                return true;
            }
        }

        function check_lastn() {

            var name_length = $("#lastname").val().length;
            if (name_length < 3) {
                $(".lastname_error_text").html("El Apellido debe tener almenos 3 caracteres");
                $(".lastname_error_text").show();
                $("#lastnameFormGroup").addClass("has-error has-feedback");

                return false;
            } else {
                $("#lastnameFormGroup").removeClass("has-error");
                $("#lastnameFormGroup").addClass("has-success");
                $(".lastname_error_text").hide();

                return true;
            }
        }


        function check_telnumber() {

            var pattern = new RegExp(/(\d{4}-\d{4})/);
            if (!pattern.test($("#telnumber").val())) {
                $(".telnumber_error_text").html("Formato incorrecto ");
                $(".telnumber_error_text").show();
                $("#telnumberFormGroup").addClass("has-error has-feedback");
                return false;
            } else {
                $("#telnumberFormGroup").removeClass("has-error");
                $("#telnumberFormGroup").addClass("has-success");
                $(".telnumber_error_text").hide();

                return true;
            }
        }


        function check_password() {
            var password_length = $("#password").val().length;
            var id = $("#id").val();
            if (id != "" && password_length == 0) {
                return true;
            } else {

                if (password_length < 4) {
                    $(".password_error_text").html("La Contraseña debe tener almenos 5 caracteres");
                    $(".password_error_text").show();
                    $("#passwordFormGroup").addClass("has-error has-feedback");

                    return false;
                } else {
                    $("#passwordFormGroup").removeClass("has-error");
                    $("#passwordFormGroup").addClass("has-success");
                    $(".password_error_text").hide();
                    return true;
                }
            }


        }



        function showDangerAlert(message) {
            $(".alert-danger").removeClass("hide");
            $(".alert-danger").html(message).fadeIn();

        }

        function showSucessAlert(message) {
            $(".alert-success").removeClass("hide");
            $(".alert-success").html(message).fadeIn();
            setTimeout(function() {
                $(".alert-success").html(message).fadeOut();
            }, 1500);
        }

        function getJsonResponse(data) {
            return JSON.parse(data);
        }
    </script>
</BODY>

</HTML>