<?php

namespace Pap\Gescom\Model\manager;

use Pap\Gescom\Model\manager\Entity\DeveloppeurEntity;
use Pap\Gescom\Tools\ConnexionTools;

class DeveloppeurManager
{
    public function selectDev()
    {
        $arr = [];
        $db = new ConnexionTools ;
        $connection = $db->index();  
        $stat = pg_connection_status($connection);

        if ($stat === PGSQL_CONNECTION_OK) {

            $result = pg_prepare($connection, "my_query", 'SELECT * FROM developpeur');
            $result = pg_execute($connection, "my_query");

            if ($result) {
                $arr['rows'] = pg_num_rows($result);
                $arr['idDev'] = pg_fetch_result($result, 0, 'id_dev');
                $arr['prenom'] = pg_fetch_result($result, 0, 'prenom');
                $arr['timespent'] = pg_fetch_result($result, 0, 'temps_passe');
            }else{
                $arr['SQL'] = true;
                $arr['message'] = 'Erreur SQL';
            }

        } else {
            $arr['BD'] = true;
            $arr['message'] = 'Connexion impossible à la base de données';
        }

        return $arr;


    }

}