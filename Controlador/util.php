<?php 

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
