<?php

namespace Pap\Gescom\Controller;

use Pap\Gescom\Tools\ConnectionTools;
use Pap\Gescom\Model\manager\LoginManager;
use Pap\Gescom\Model\manager\Entity\LoginEntity;



class LoginController
{

    public function index()
    {
        $db = new ConnectionTools ;
        $connection = $db->index() or die("Connexion impossible");
        $stat = pg_connection_status($connection);

        if ($stat === PGSQL_CONNECTION_OK) {
            $params = [
                "user" => $_GET['user'],
                "pwd" => sha1($_GET['pwd'])
            ];

            $result = pg_prepare($connection, "queryUser", 'SELECT * FROM users WHERE name = $1 AND mdp = $2');
            $result = pg_execute($connection, "queryUser", array($params["user"],$params["pwd"]));

            if (!$result) {
                echo "Une erreur est survenue.\n";
                exit;
            }else{
                $rows = pg_num_rows($result);
                if($rows == 1){
                    header('Location: /app/dashboard');
                }else{
                    header('Location: /');
                }

            }
        } else {
            echo 'Connexion erronée';
            exit;
        }

    }

}