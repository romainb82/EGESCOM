<?php

namespace Pap\Gescom\Model\manager;

use Pap\Gescom\Tools\ConnexionTools;

class LoginManager
{
    public function select($params)
    {
        $arr = [];
        $db = new ConnectionTools ;
        $connection = $db->index();
        $stat = pg_connection_status($connection);

        if ($stat === PGSQL_CONNECTION_OK) {

            /*
                        $objLoginEntity = new LoginEntity([
                            'mail' => 'aurelien.boisselet@gmail.com',
                        ]);
                        $params = [
                            "mail" => $objLoginEntity->getMail(),
                        ];
                        echo $params["mail"];
            */

            $result = pg_prepare($connection, "my_query", 'SELECT * FROM users WHERE name = $1 AND pwd = $2');
            $result = pg_execute($connection, "my_query", array($params["user"],$params["pwd"]));

            if ($result) {
                $arr['rows'] = pg_num_rows($result);
                $arr['name'] = pg_fetch_result($result, 0, 'name');
                $arr['mail'] = pg_fetch_result($result, 0, 'mail');
            }else{
                $arr['rows'] = 0;
                $arr['message'] = 'Pas de résultat';
            }

        } else {
            $arr['rows'] = 0;
            $arr['message'] = 'Connexion impossible';
        }

        return $arr;


    }

}