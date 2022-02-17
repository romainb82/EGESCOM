<?php

namespace Pap\Gescom\Controller\Widgets\Informatique\Altassian;

use Pap\Gescom\Model\Widgets\Manager\Informatique\Altassian\tempoAltassianManager;

class tempoAltassianController
{

    /**
     *==============================================================================================================
     * Affiche tous les utilisateurs ayant saisi un temps dans Tempo
     *
     *==============================================================================================================
     */
    public function tempoUsers()
    {
        $fileTempo = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";

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

    /**
     *==============================================================================================================
     * Affiche tous les projets en fonction de l'utilisateur choisi
     *
     * @param string $user id de l'utilisateur pour pouvoir faire la recherche dessus
     *==============================================================================================================
     */
    public function tempoProjets($user)
    {
        $fileTempo = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";
        $tempo = new tempoAltassianManager();

        $projet = json_decode($tempo->requestTicketperProjet_User($fileTempo,$user));

        foreach ($projet as $key => $value){

        }

        $nameUser = $_GET["nameUser"];

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetTempoProjets.html.twig', ['url' => 'informatique', 'user' => $user, "name"=>$nameUser]);
    }

    /**
     *==============================================================================================================
     * Affiche tous les tickets en fonction de l'utilisateur choisi, du projet choisi
     *
     * @param string $user id de l'utilisateur pour pouvoir faire la recherche dessus
     * @param string $projet id du projet pour pouvoir faire la recherche dessus
     *==============================================================================================================
     */
    public function tempoTickets($user, $projet)
    {
        $fileTempo = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";
        $tempo = new tempoAltassianManager();





        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetTempoTickets.html.twig', ['url' => 'informatique', 'user' => $user, 'projet' => $projet]);
    }

    /**
     *==============================================================================================================
     * Affiche tous les temps Tempo en fonction de l'utilisateur choisi, du projet choisi et du ticket choisi
     *
     * @param string $idUser id de l'utilisateur pour pouvoir faire la recherche dessus
     * @param string $idProjet id du projet pour pouvoir faire la recherche dessus
     * @param string $ticket id du ticket choisi
     *==============================================================================================================
     */
    public function tempoTimes($user, $projet, $ticket)
    {
        $fileTempo = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/issueTempo.json";
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
