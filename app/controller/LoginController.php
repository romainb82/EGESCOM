<?php

namespace Pap\Gescom\Controller;

use Pap\Gescom\tools\ConnectionTools;
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

            /*
                        $objLoginEntity = new LoginEntity([
                            'mail' => 'aurelien.boisselet@gmail.com',
                        ]);
                        $params = [
                            "mail" => $objLoginEntity->getMail(),
                        ];
                        echo $params["mail"];
            */

            $params = [
                "user" => $_POST['user'],
                "pwd" => sha1($_POST['pwd'])
            ];

            $result = pg_prepare($connection, "my_query", 'SELECT * FROM users WHERE name = $1 AND mdp = $2');
            $result = pg_execute($connection, "my_query", array($params["user"],$params["pwd"]));
            header('Location: /app/dashboard');
            die();

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