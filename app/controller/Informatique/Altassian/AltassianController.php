<?php
namespace Pap\Gescom\Controller\Informatique\Altassian;


class AltassianController
{
    public function index()
    {
            $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
            $twig = new \Twig\Environment($loader, [
                'cache' => false,
            ]);
            $twig->addGlobal('session', $_SESSION);
            $twig->addGlobal('modules', PROJECT_MODULES);
            echo $twig->render('/informatique/Altassian/index.html.twig', ['url' => 'informatique']);

    }

    public function oauth()
    {
            $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
            $twig = new \Twig\Environment($loader, [
                'cache' => false,
            ]);
            $twig->addGlobal('session', $_SESSION);
            $twig->addGlobal('modules', PROJECT_MODULES);
            echo $twig->render('/informatique/Altassian/oauth.html.twig', ['url' => 'informatique']);
    }
}
