<?php
namespace Pap\Gescom\Controller;

use Pap\Gescom\Model\manager\IndexManager;

class IndexController
{
    public function index()
    {
        session_unset();
        session_destroy();

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        echo $twig->render('index.html.twig',['url' => 'home']);
    }
}