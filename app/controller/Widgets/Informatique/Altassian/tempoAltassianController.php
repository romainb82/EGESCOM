<?php

namespace Pap\Gescom\Controller\Widgets\Informatique\Altassian;

use Pap\Gescom\Model\Widgets\Manager\Informatique\Altassian\tempoAltassianManager;

class tempoAltassianController
{

    public function tempoUsers()
    {
        $fileTempo = "https://egescomromain.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";

        $tempo = new tempoAltassianManager();

        $user =array();

        $arrayTicket = json_decode($tempo->requestIssueTempo($fileTempo),true);
        foreach($arrayTicket as $key => $val){
            $user[] = ["keyTicket" => $key,
                "dateDebut" => $val[0]["startDate"],
                "nameUser" => $val[0]["author"]["displayName"],
                "idUser" => $val[0]["author"]["accountId"]];
        }

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetTempoUsers.html.twig', ['url' => 'informatique', 'tableauUser' => $user]);
    }

    public function tempoProjets($user)
    {
        $fileTempo = "https://egescomromain.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";
        $tempo = new tempoAltassianManager();
        /*
        $projet = json_decode($tempo->requestTicketperProjet_User($fileTempo,$user));

        foreach ($projet as $key => $value){

        }
        */
        $nameUser = $_GET["nameUser"];

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetTempoProjets.html.twig', ['url' => 'informatique', 'user' => $user, "name"=>$nameUser]);
    }

    public function tempoTickets($user, $projet)
    {
        $fileTempo = "https://egescomromain.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";
        $tempo = new tempoAltassianManager();





        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetTempoTickets.html.twig', ['url' => 'informatique', 'user' => $user, 'projet' => $projet]);
    }

    public function tempoTimes($user, $projet, $ticket)
    {
        $fileTempo = "https://egescomromain.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";
        $tempo = new tempoAltassianManager();





        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetTempoTimes.html.twig', ['url' => 'informatique', 'user' => $user, 'projet' => $projet, 'ticket' => $ticket]);
    }

}
