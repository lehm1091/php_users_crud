<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/user.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/user_repository.php';

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

function getUserRepository()
{
    return new UserRepository();
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
