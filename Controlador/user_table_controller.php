<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/lib/ssp.class.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Modelo/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EXAMEN_SISTEMAS/Controlador/authorization_handler.php';

$table = 'users';
$primaryKey = 'user_id';
$sql_details = array(
    'user' => Connection::$USERNAME,
    'pass' => Connection::$PASSWORD,
    'db'   => Connection::$DATABASENAME,
    'host' => Connection::$HOST
);

$columns = array(
    array('db' => 'user_id', 'dt' => 0),
    array('db' => 'email',  'dt' => 1),
    array('db' => 'first_name',   'dt' => 2),
    array('db' => 'last_name',     'dt' => 3),
    array('db' => 'create_at',     'dt' => 4),
    array('db' => 'last_seen',     'dt' => 5),
);


echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);
