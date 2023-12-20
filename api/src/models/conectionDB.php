<?php
function conectoBD($rol) {
    switch ($rol) {
        case "normal":
            $host = "localhost";
            $username = "root";
            $passwd = "";
            $dbname = "socialred";
            break;
    }

    $link = new mysqli($host, $username, $passwd, $dbname);

    if ($link->connect_error) {
        die('Error de Conexión (' . $link->connect_errno . ') ' . $link->connect_error);
    }
    return $link;
}




?>