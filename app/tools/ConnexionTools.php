<?php

namespace Pap\Gescom\Tools;

class ConnexionTools
{

    public function index()
    {
        $conn_string = "host=".SQL_HOST." port=".SQL_PORT." dbname=".SQL_DB." user=".SQL_USER." password=".SQL_PWD;
        return pg_connect($conn_string);
    }
}