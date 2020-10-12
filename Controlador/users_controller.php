<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/user_repository.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/role_repository.php';

// only logged users can use this controller
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authorization_handler.php';

const INDEX_URL = "../index.html";


if (isset($_REQUEST['method'])) {
    if ($_REQUEST['method'] === 'findAll') {
        responseMessage(200, "", getUserRepository()->findAllUsers());
    } else if ($_REQUEST['method'] === 'findOne' and isset($_REQUEST['id'])) {
        responseMessage(200, "", getUserRepository()->findUserById($_REQUEST['id']));
    } else if ($_REQUEST['method'] === 'deleteOne' and isset($_REQUEST['id'])) {
        responseMessage(200, "Usuario Borrado con exito", getUserRepository()->deleteUserById($_REQUEST['id']));
    } else if ($_REQUEST['method'] === 'updateOne' and isset($_REQUEST['id'])) {
        $mappedUser = mapUser();
        $record = getUserRepository()->findUserById($_REQUEST['id']);
        if ($record) {
            if ($record->email != $mappedUser->email) {
                if (getUserRepository()->userEmailExist($_REQUEST['email'])) {
                    responseMessage(500, "Este email ya esta siendo utilizado por otra persona", "");
                    return;
                }
            }
            if ($_REQUEST['password'] == "") {
                if (!getUserRepository()->updateUser($mappedUser)) {
                    responseMessage(500, "Algo salio mal", "");
                }
            } else if (!getUserRepository()->updateUserWithPassword($mappedUser)) {
                responseMessage(500, "Algo salio mal", "");
            }
            //REMOVE ALL ROLES
            try {
                getRoleRepository()->deleteRolesByUserId($mappedUser->user_id);
                //ADD NEW ROLES
                addRolesToUser($_REQUEST['id'],);
                responseMessage(200, "Usuario actualizado", "");
            } catch (Exception $e) {
                responseMessage(500, $e->getMessage(), "");
            }
        } else {
            responseMessage(404, "Usuario no existe", "");
        }
    } else if ($_REQUEST['method'] === 'saveOne') {
        if (!getUserRepository()->userEmailExist($_REQUEST['email'])) {
            $user = mapUser();
            $id = getUserRepository()->saveUser($user);
            if (!$id) {
                responseMessage(500, "Algo salio mal", "");
            } else {
                //add roles to new user 
                addRolesToUser($id);
                responseMessage(200, "Usuario guardado con exito", "");
            }
        } else {
            responseMessage(500, "Este email ya esta siendo utilizado por otra persona", "");
        }
    } /*else if ($_REQUEST['method'] === 'saveOne') {
        $user = mapUser();
        $id = getUserRepository()->saveUser($user);
        if (!$id) {
            responseMessage(500, "Algo salio mal", "");
        } else {
            addRolesToUser($id);
            responseMessage(200, "Usuario guardado con exito", "");
        }*/ else if ($_REQUEST['method'] === 'emailExits') {
        if (!getUserRepository()->userEmailExist($_REQUEST['email'])) {
            responseMessage(200, "El email no existe", "");
        } else {
            responseMessage(500, "El email ya existe", "");
        }
    }
}

function mapUser()
{
    $user = new User();
    $user->user_id = $_REQUEST['id'];
    $user->email = $_REQUEST['email'];
    $user->password = $_REQUEST['password'];
    $user->first_name = $_REQUEST['name'];
    $user->last_name = $_REQUEST['lastname'];
    $user->tel_number = $_REQUEST['telnumber'];
    return $user;
}

function responseMessage($code, $message, $data)
{

    $httpMessage = array(
        "message" => $message,
        'data' => $data
    );

    http_response_code($code);
    print_r(json_encode($httpMessage));
}


function getUserRepository()
{
    return new UserRepository();
}

function getRoleRepository()
{
    return new roleRepository();
}


function addRolesToUser($id)
{
    if (isset($_REQUEST['role_super_admin'])) {
        getRoleRepository()->addRoleToUser($id, getRoleRepository()->findRoleByName('ROLE_SUPER_ADMIN')->role_id);
    }
    if (isset($_REQUEST['role_admin'])) {
        getRoleRepository()->addRoleToUser($id, getRoleRepository()->findRoleByName('ROLE_ADMIN')->role_id);
    }
    if (isset($_REQUEST['role_user'])) {
        getRoleRepository()->addRoleToUser($id, getRoleRepository()->findRoleByName('ROLE_USER')->role_id);
    }
}
