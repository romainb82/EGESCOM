<?php

namespace Pap\Gescom\Controller;

use Pap\Gescom\Tools\ConnexionTools;
use Pap\Gescom\Model\manager\LoginManager;
use Pap\Gescom\Model\manager\Entity\LoginEntity;



class LoginController
{

    public function index()
    {

        $params = [
            "user" => $_GET['user'],
            "pwd" => sha1($_GET['pwd'])
        ];

        $model = new LoginManager();
        $data = $model->select($params);

        if($data["rows"] === 1){
            $_SESSION['name'] = $data["name"];
            $_SESSION['mail'] = $data["mail"];
            header('Location: /app/dashboard');
        }else{
            header('Location: /app/?message='.$data["message"]);
        }

    }

}