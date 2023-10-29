<?php

namespace App;

use PDO;

class DBconnection
{

    // This static function returns a PDO object
    public static function getPDO(): PDO
    {
        $dbHost = "";
        $dbName = "";
        $dbUser = "";
        $dbPassword = "";

        return new PDO('mysql:dbname=' . $dbName . ';host=' . $dbHost, $dbUser, $dbPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
