<?php

namespace Pap\Gescom\Model\manager;

use Pap\Gescom\Tools\ConnexionTools;

class LoginManager
{
    public function select($params)
    {
        $arr = [];
        $db = new ConnexionTools ;
        $connection = $db->index();
        $stat = pg_connection_status($connection);

        if ($stat === PGSQL_CONNECTION_OK) {
            $result = pg_prepare($connection, "my_query", 'SELECT * FROM users WHERE name = $1 AND pwd = $2');
            $result = pg_execute($connection, "my_query", array($params["user"],$params["pwd"]));

            if ($result) {
                $arr['rows'] = pg_num_rows($result);
                $arr['name'] = pg_fetch_result($result, 0, 'name');
                $arr['mail'] = pg_fetch_result($result, 0, 'mail');
            }else{
                $arr['SQL'] = true;
                $arr['rows'] = 0;
                $arr['message'] = 'Erreur dans la requete SQL';
            }
        } else {
            $arr['BDD'] = true;
            $arr['rows'] = 0;
            $arr['message'] = 'Connexion impossible';
        }

        return $arr;


    }

}