<?php

namespace Pap\Gescom\Model\manager;

use Pap\Gescom\Model\manager\Entity\LoginEntity;
use Pap\Gescom\Tools\ConnexionTools;

class LoginManager
{
    public function select(LoginEntity $params)
    {
        $arr = [];
        $db = new ConnexionTools ;
        $connection = $db->index();
        $stat = pg_connection_status($connection);

        if ($stat === PGSQL_CONNECTION_OK) {

            $objEntity = [
                "name" => $params->getName(),
                "pwd" => $params->getPwd()
            ];

            $result = pg_prepare($connection, "my_query", 'SELECT * FROM users WHERE name = $1 AND mdp = $2');
            $result = pg_execute($connection, "my_query", array($objEntity["name"],$objEntity["pwd"]));

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