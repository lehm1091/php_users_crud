/**controller url */
const INSERT_URL_USERS_VIEW = '../Controlador/users_controller.php?method=saveOne';
const UPDATE_URL_USERS_VIEW = '../Controlador/users_controller.php?method=updateOne';
const DATATABLE_CONTROLLER_URL_USERS_VIEW = '../Controlador/user_table_controller.php';
const EMAIL_EXISTENCE_URL_USERS_VIEW = '../Controlador/users_controller.php?method=emailExits';
const FIND_ONE_URL_USERS_VIEW = '../Controlador/users_controller.php?method=findOne';
const DELETE_ONE_URL_USERS_VIEW = '../Controlador/users_controller.php?method=deleteOne';

$(".alert-danger").hide();
$(".alert-success").hide();

/**listeners for form */


/***form submition */
///// user form
$('#userForm').submit(

    function (event) {
        $(".alert-danger").hide();
        $(".alert-success").hide();
        event.preventDefault();
        const id = $("#id").val();
        $("#email").val($("#email").val().trim());
        $("#name").val($("#name").val().trim());
        $("#lastname").val($("#lastname").val().trim());
        $("#password").val($("#password").val().trim());
        $("#telnumber").val($("#telnumber").val().trim());

        console.log(checkPasswordCustom("password", "id"));





        if (checkEmail("email") &&
            checkPasswordCustom("password", "id") &&
            checkName("name") &&
            checkLastName("lastname") &&
            checkTelNumber("telnumber")) {
            $.ajax({
                url: id > 0 ? UPDATE_URL_USERS_VIEW : INSERT_URL_USERS_VIEW, ///update or save taking id as flag
                type: 'POST',
                data: $("#userForm").serialize(),
                beforeSend: () => {
                    $("#userForm .btn").html('<span class="">Cargando...</span>');
                },
                success: function (response) {
                    $("#userForm .btn").html('<i class="fa fa-check"></i>');
                    $("#userFormModal").modal('hide');
                    console.log(response);
                    showSucessAlert(jsonParseResponse(response).message);
                    ajaxReloadUsersDatatable("usersTable");
                    resetUserForm();


                },
                error: error => {
                    console.log(error);
                    $("#userForm .btn").html('Login');
                    showDangerAlert(jsonParseResponse(error.responseText).message);
                }
            });
        } else {
            showDangerAlert("Algo salio mal en la validacion");
        }


    }


);



/* user data table  */

function ajaxReloadUsersDatatable(tableId) {
    $(`#${tableId}`).DataTable().ajax.reload();;
}
//init data table from php controller
function initUserDatatable(tableId, isSuper, isAdmin) {
    return $(`#${tableId}`).DataTable({
        dom: 'Bfrtip',
        responsive: true,
        "processing": true,
        "serverSide": true,
        "oLanguage": {
            "sSearch": "Buscar"
        },
        "ajax": DATATABLE_CONTROLLER_URL_USERS_VIEW,
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
            render: function (data, type, row) {
                if (type === "sort" || type === "type") {
                    return data;
                }
                return converMySqlDate(data);//format creat_at datetime
            }
        },
        {
            "data": 5,
            render: function (data, type, row) {
                if (type === "sort" || type === "type") {
                    return data;
                }
                if (data === null) {
                    return data;
                }
                return converMySqlDateTime(data); //format last_seen datetime
            }
        },

        {
            data: 0, /// render action buttons if correct role is found
            render: function (data, type, row) {
                if (type === "sort" || type === "type") {
                    return data;
                }
                let edit = `<a class='text-primary editLink' href="#" style="margin-right:20px" onclick="editSelectedUserInfo(${data})" ><i class="fa fa-lg  fa-pencil"></i></a>`;
                let del = `<a class="text-primary deleteLink" id="delete${data}" href="#" onclick="deleteUser(${data})"><i class="fa fa-lg  fa-trash"></i></a>`;
                if (isAdmin && !isSuper) {
                    return `${edit}`;
                } else if (isSuper) {
                    return `${edit}${del}`;
                } else {
                    return "Denegado";
                }

            }
        }

        ]
    });

}

/**user form modal functions */

function editLoggedUserInfo(loggedUserId) {
    fillUserFormWithUserInfoFromDataBase(loggedUserId, "Actualizar mi informacion");
}


function editSelectedUserInfo(id) {
    fillUserFormWithUserInfoFromDataBase(id, "Actualizar usuario");
}

function fillUserFormWithUserInfoFromDataBase(id, modalTitle) {
    resetUserForm();
    $(".modal-title").html(modalTitle);
    //reset check boxes
    $(".form-check-input").prop("checked", false);
    $.ajax({
        url: FIND_ONE_URL_USERS_VIEW,
        type: 'POST',
        data: {
            id: id
        },
        success: function (response) {
            fillUserFormFromHTTPResponse(response);
        },
        error: error => {
            console.log(error);
            showDangerAlert(error.responseText);
        }
    });
    $("#userFormModal").modal();

}

function deleteUser(id) {
    var r = confirm("¿Borrar el usario?");
    if (r == true) {
        $.ajax({
            url: DELETE_ONE_URL_USERS_VIEW,
            type: 'POST',
            data: {
                id: id
            },
            beforeSend: () => { },
            success: function (response) {
                console.log(response);
                showSucessAlert(jsonParseResponse(response).message);
                ajaxReloadUsersDatatable("usersTable");            },
            error: error => {
                console.log(error);
                showDangerAlert(jsonParseResponse(error.responseText).message);

            }
        });
    }

}



function fillUserFormFromHTTPResponse(response) {
    $("#email").val(jsonParseResponse(response).data.email);
    $("#id").val(jsonParseResponse(response).data.user_id);
    $("#name").val(jsonParseResponse(response).data.first_name);
    $("#lastname").val(jsonParseResponse(response).data.last_name);
    $("#telnumber").val(jsonParseResponse(response).data.tel_number);
    //if user has roles check role_checkboxes
    let roles = jsonParseResponse(response).data.roles;
    for (role of roles) {
        $('#' + role.name).prop("checked", true);
    }

}


function openModalForNewUser() {
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

function jsonParseResponse(data) {
    return JSON.parse(data);
}

/** validate inputs functions */

function checkName(selector) {
    var name_length = $(`#${selector}`).val().length;
    if (name_length < 3) {
        showErrorFeedback(selector, "El nombre debe tener almenos 3 caracteres");
        return false;
    } else {
        showSuccessFeedback(selector);
        return true;
    }
}

function checkLastName(selector) {

    var name_length = $(`#${selector}`).val().length;
    if (name_length < 3) {
        showErrorFeedback(selector, "El Apellido debe tener almenos 3 caracteres")
        return false;
    } else {
        showSuccessFeedback(selector);
        return true;
    }
}

function checkTelNumber(selector) {

    var pattern = new RegExp(/(\d{4}-\d{4})/);
    if (!pattern.test($(`#${selector}`).val())) {
        showErrorFeedback(selector, "Formato incorrecto")
        return false;
    } else {
        showSuccessFeedback(selector);
        return true;
    }
}


function checkPassword(selector) {
    var password_length = $(`#${selector}`).val().length;
    if (password_length < 4) {
        showErrorFeedback(selector, "La Contraseña debe tener almenos 5 caracteres")
        return false;
    } else {
        showSuccessFeedback(selector);
        return true;
    }
}


//custom check for password, when user is updating, password input can be empty
function checkPasswordCustom(selector, userIdSelector) {
    var id = $(`#${userIdSelector}`).val();
    if (id > 0) {
        showSuccessFeedback(selector);
        console.log(" el id es mayor que sero y necesita contra");
        return true;
    } else {
        return checkPassword(selector);

    }
}
//if user id is defined then check only format if not, then check duplicates
function checkEmailCustom(selector, userId) {
    var id = $(`#${userId}`).val();
    if (id > 0) {
        return checkEmail(selector);

    } else {
        checkEmailDuplicate(selector).
            done(function (data, textStatus, jqXHR) {
                console.log(textStatus);
                showSuccessFeedback(selector);

            }).fail(function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus);
                showErrorFeedback(selector, "El email ya existe");

            }).always(function (jqXHROrData, textStatus, jqXHROrErrorThrown) {
                if (textStatus == "success") {
                    return true;
                }
                return false;
            });
    }

}

function checkEmailDuplicate(selector) {
    return $.ajax({
        url: EMAIL_EXISTENCE_URL_USERS_VIEW, ///update or save taking id as flag
        type: 'POST',
        async: false,
        data: {
            email: $(`#${selector}`).val()
        },
    });


}

function checkEmail(selector) {
    var pattern = new RegExp(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/);
    if (pattern.test($(`#${selector}`).val())) {
        showSuccessFeedback(selector)
        return true;

    } else {
        showErrorFeedback(selector, "Direccion de correo electronica invalida");
        return false;

    }

}





function showDangerAlert(message) {
    $(".alert-danger").removeClass("hide");
    $(".alert-danger").html(message).fadeIn();

}

function showSucessAlert(message) {
    $(".alert-success").removeClass("hide");
    $(".alert-success").html(message).fadeIn();
    setTimeout(function () {
        $(".alert-success").html(message).fadeOut();
    }, 1500);
}

///las los nombres deben seguir este patron para funcionar
function showErrorFeedback(selector, msg) {
    $(`.${selector}-error-text`).html(msg);
    $(`.${selector}-error-text`).show();
    $(`.${selector}-form-group`).addClass("has-error");
}

function showSuccessFeedback(selector) {
    $(`.${selector}-error-text`).hide();
    $(`.${selector}-form-group`).addClass("has-success has-feedback");
    $(`.${selector}-form-group`).removeClass("has-error");
}




function converMySqlDate(dateTime) {
    if (dateTime) {
        let dateTimeParts = dateTime.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
        //dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
        //const dateObject = new Date(...dateTimeParts); // our Date object.
        const dateObject = `${dateTimeParts[2]}-${dateTimeParts[1]}-${dateTimeParts[0]} `;
        return dateObject;
    } else {
        return "";
    }
}

function converMySqlDateTime(dateTime) {
    if (dateTime) {
        let dateTimeParts = dateTime.split(/[- :]/); // regular expression split that creates array with: year, month, day, hour, minutes, seconds values
        //dateTimeParts[1]--; // monthIndex begins with 0 for January and ends with 11 for December so we need to decrement by one
        //const dateObject = new Date(...dateTimeParts); // our Date object.
        const dateObject = `${dateTimeParts[2]}-${dateTimeParts[1]}-${dateTimeParts[0]} ${dateTimeParts[3]}:${dateTimeParts[4]}`;
        return dateObject;
    } else {
        return "";
    }

}