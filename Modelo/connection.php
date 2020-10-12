<?php


class Connection
{
    static  $HOST = 'localhost';

    static  $USERNAME = 'root';

    static  $PASSWORD = '';

    static  $DATABASENAME = 'supertex_lehm';

    public static function connect()
    {
        $conn = FALSE;
        try {
            $dsn = 'mysql:host=' . self::$HOST . ';dbname=' . self::$DATABASENAME;
            $conn = new \PDO($dsn, self::$USERNAME, self::$PASSWORD);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            exit("PDO Connect Error: " . $e->getMessage());
        }
        return $conn;
    }
}
function printError($code, $message)
{
    $httpMessage = array(
        'message' => $message
    );
    http_response_code($code);
    print_r(json_encode($httpMessage));
}
