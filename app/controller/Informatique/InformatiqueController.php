<?php

namespace Pap\Gescom\Controller\Informatique;

class InformatiqueController
{
    public function index()
    {
        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);
        echo $twig->render('/informatique/informatique.html.twig',['url' => 'informatique']);
    }
}
