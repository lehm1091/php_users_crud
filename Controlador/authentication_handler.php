<?php
const ERROR_URL = "../Vista/401.html";
session_start();
if (!isset($_SESSION["email"])) {
    redirectToErrorPage();
}

function redirectToErrorPage()
{
    header("Location:" . ERROR_URL);
}


function getEmail()
{
    return $_SESSION["email"];
}

function getLastSeen()
{
    return  $_SESSION["last_seen"];
}

function getUserId()
{
    return  $_SESSION["user_id"];
}
