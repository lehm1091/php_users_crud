<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authentication_handler.php';

function isSuperAdmin()
{
    if (isset($_SESSION["ROLE_SUPER_ADMIN"])) {
        return true;
    } else {
        return false;
    }
}

function isAdmin()
{
    if (isset($_SESSION["ROLE_ADMIN"])) {
        return true;
    } else {
        return false;
    }
}

function isUser()
{
    if (isset($_SESSION["ROLE_USER"])) {
        return true;
    } else {
        return false;
    }
}

function permitSuperAdmins()
{
    if (!isSuperAdmin()) {
        redirectToErrorPage();
    }
}

function permitUsers()
{
    if (!isUser()) {
        redirectToErrorPage();
    }
}

function permitAdmins()
{
    if (!isAdmin()) {
        redirectToErrorPage();
    }
}
