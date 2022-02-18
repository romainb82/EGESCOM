<?php

namespace Pap\Gescom\Controller;

use Pap\Gescom\Tools\ConnectionTools;
use Pap\Gescom\Model\Manager\LoginManager;
use Pap\Gescom\Model\Manager\Entity\LoginEntity;



class LoginController
{

    public function index()
    {
        $db = new ConnectionTools ;
        $connection = $db->index() or die("Connexion impossible");
        $stat = pg_connection_status($connection);

        if ($stat === PGSQL_CONNECTION_OK) {

            $params = [
                "username" =>$_GET['Username'],
                "password" => $_GET['Password']
            ];
            $result = pg_prepare($connection, "my_query", 'SELECT * FROM users WHERE name = $1 AND mdp = $2');
            $result = pg_execute($connection, "my_query", array($params["username"], sha1($params["password"])));
            if (!$result) {
                echo "Une erreur est survenue.\n";
                exit;
            }else {
                $rows = pg_num_rows($result);
                if ($rows == 1) {
                    header('Location: /app/dashboard');
                } else {
                    header('Location: /');
                }
                //$arr = pg_fetch_all($result);
                //print_r($arr);
            }

        } else {
            echo 'Connexion erronée';
            exit;
        }

    }

}