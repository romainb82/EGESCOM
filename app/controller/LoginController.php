<?php

namespace Pap\Gescom\Controller;

use Pap\Gescom\Tools\ConnexionTools;
use Pap\Gescom\Model\manager\LoginManager;
use Pap\Gescom\Model\manager\Entity\LoginEntity;



class LoginController
{
    public function index()
    {

        $params = new LoginEntity([
            'name' => $_GET['user'],
            'pwd' => $_GET['pwd']
        ]);

        $model = new LoginManager();
        $data = $model->select($params);

        if(isset($data["BD"])){
            header('Location: /app/?message='.$data["message"]);
        }else{
            if(isset($data["SQL"])){
                header('Location: /app/?message='.$data["message"]);
            }else{
                if($data["rows"] === 1){
                    $_SESSION['name'] = $data["name"];
                    $_SESSION['mail'] = $data["mail"];
                    header('Location: /app/dashboard');
                }else{
                    header('Location: /app/?message=Utilisateur ou mot de passe invalide');
                }
            }
        }
    }
}