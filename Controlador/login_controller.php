<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/user_repository.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/role_repository.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/util.php';

session_start();

const INDEX_URL = "../index.html";
if (isset($_REQUEST['method'])) {


    if ($_REQUEST['method'] === 'login') {
        if (isset($_REQUEST['email']) and isset($_REQUEST['password'])) {
            echo loginMember();
        } else {
            return false;
        }

        //     header("Location:" . INDEX_URL);

    } else if ($_REQUEST['method'] === 'register') {
        if (!getUserRepository()->userEmailExist($_REQUEST['email'])) {
            $user = mapUser();
            $id = getUserRepository()->saveUser($user);
            if (!$id) {
                responseMessage(500, "Algo salio mal", "");
            } else {
                //add roles to new user 
                addRolesToUser($id);
                loginMember();
            }
        } else {
            responseMessage(500, "Este email ya esta siendo utilizado por otra persona", "");
        }
    }
}


function loginMember()
{
    try {
        if (getUserRepository()->userHasAccess($_POST["password"], $_POST["email"])) {
            $memberRecord = getUserRepository()->findUserByEmail($_POST["email"]);
            getUserRepository()->updateUserLastSeen($memberRecord->user_id);
            $memberRecord = getUserRepository()->findUserByEmail($_POST["email"]);
            $_SESSION["last_seen"] = $memberRecord->last_seen;
            $_SESSION["email"] = $memberRecord->email;
            $_SESSION["user_id"] = $memberRecord->user_id;
            if ($memberRecord->roles !== null) {
                for ($i = 0; $i < count($memberRecord->roles); $i++) {
                    $_SESSION[$memberRecord->roles[$i]->name] = true;
                }
            }


            session_write_close();
            return responseMessage(200, "Inicio de sesion correcto", $memberRecord);
        } else {
            return responseMessage(404, "Email o password incorrectos", "");
        }
    } catch (Exception $e) {
        return responseMessage(500, $e->getMessage(), "");
    }
}
