<?php
namespace Pap\Gescom\Controller\Widgets\Informatique\Altassian;

use Pap\Gescom\Model\Widgets\Manager\Informatique\Altassian\listeUserAltassianManager;
use Pap\Gescom\Model\manager\DeveloppeurManager;

class listeUserAltassianController
{
    /**
     *==============================================================================================================
     * Affiche la liste utilisateurs et de leurs temps passé sur un ticket
     *
     *==============================================================================================================
     */
    public function index()
    {
        $fileT = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/searchTask.json";
        $user = new DeveloppeurManager();
        //Decodage de la requete pour pouvoir l'exploiter et recupérer les valeurs

        $arraytUser = $user->selectDev();
        echo $arraytUser;
        die();

        foreach($arraytUser as $key => $val){
            //$key => le nom de l'utilisateur  et $val les valeurs après le $key
            $tab[] = ["time" => $user->requestAvgTime($fileT, $key),
                      "assignement" => $key,
                      "idU" => $val[0]["fields"]["customfield_10065"][0]["accountId"],
                      "nameUser" => $val[0]["fields"]["customfield_10065"][0]["displayName"]];
        }
        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetlisteUser.html.twig', ['url' => 'informatique', 'table' => $tab]);
    }

    /**
     *==============================================================================================================
     * Affiche tous les projets globaux
     *
     *==============================================================================================================
     */
    public function project(){
        $fileT = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/searchTask.json";
        $tab = array();

        $user = new listeUserAltassianManager();

        $arrayProjet = json_decode($user->requestProject($fileT),true);
        //Decodage de la requete pour pouvoir l'exploiter et recupérer les valeurs
        foreach($arrayProjet as $key => $val){
            //$key => le nom du projet  et $val les valeurs après le $key
            $tab[] = ["nameProjet" => $key,
                "idProjet" => $val[0]["fields"]["project"]["id"],
                "idU" => $val[0]["fields"]["customfield_10065"][0]["accountId"]];
        }

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetListeProjet.html.twig', ['url' => 'informatique' , 'tableProjet' => $tab]);
    }

    /**
     *==============================================================================================================
     * Affiche tous les projets en fonction d'un utilisateur
     *
     * @param string $idUser id de l'utilisateur pour pouvoir faire la recherche dessus
     *==============================================================================================================
     */
    public function projectU($idUser){

        $fileT = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/searchTask.json";
        $tab = array();

        $user = new listeUserAltassianManager();

        $arrayProjet = json_decode($user->requestProjectperUser($fileT,$idUser),true);
        //Decodage de la requet pour pouvoir l'exploiter et recupérer les valeurs
        foreach($arrayProjet as $key => $val){
            //$key => le nom du projet  et $val les valeurs après le $key
            $tab[] = ["nameProjet" => $key,
                      "idProjet" => $val[0]["fields"]["project"]["id"],
                      "idU" => $val[0]["fields"]["customfield_10065"][0]["accountId"],
                      "nameUser" => $val[0]["fields"]["customfield_10065"][0]["displayName"]];
        }

        $nameU = $_GET["nameUser"];

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetListeProjetUtilisateur.html.twig', ['url' => 'informatique' , 'tableProjet' => $tab, 'nameUser' => $nameU]);
    }

    /**
     *==============================================================================================================
     * Affiche tous les tickets en fonction du projet
     *
     * @param string $idProjet id du projet pour pouvoir faire la recherche dessus
     *==============================================================================================================
     */
    public function TicketperProjet($idProjet){
        $fileT = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/searchTask.json";
        $tab = array();

        $user = new listeUserAltassianManager();

        //Decodage de la requete pour pouvoir l'exploiter et recupérer les valeurs
        $arrayTicket = json_decode($user->requestTicket($fileT, $idProjet),true);
        foreach($arrayTicket as $key => $val){
            //$key => la description du ticket  et $val les valeurs après le $key
            $tab[] = ["descTicket" => $key,
                      "nameProjet" => $val[0]["fields"]["project"]["name"],
                      "creation" => $val[0]["fields"]["created"]];
        }

        $nameP = $_GET["nameP"];

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetListeticket.html.twig', ['url' => 'informatique' , 'tableauTicket' => $tab, 'nameP' => $nameP]);
    }

    /**
     *==============================================================================================================
     * Affiche tous les tickets en fonction d'un utilisateur et d'un projet
     *
     * @param string $idProjet id du projet pour pouvoir faire la recherche dessus
     * @param string $idUser id de l'utilisateur pour pouvoir faire la recherche dessus
     *==============================================================================================================
     */
    public function TicketperProjetUser($idProjet, $idUser){
        $fileT = "https://egescom-proapro.herokuapp.com/app/public/datajson/Altassian/searchTask.json";
        $tab = array();

        $user = new listeUserAltassianManager();

        //Decodage de la requete pour pouvoir l'exploiter et recupérer les valeurs
        $arrayTicket = json_decode($user->requestTicketperProjet($fileT, $idUser, $idProjet),true);
        foreach($arrayTicket as $key => $val){
            //$key => la description du ticket  et $val les valeurs après le $key
            $tab[] = ["descTicket" => $key,
                      "nameProjet" => $val[0]["fields"]["project"]["name"],
                      "nameUser" => $val[0]["fields"]["customfield_10065"][0]["displayName"],
                      "tempsPasse" => $val[0]["fields"]["timespent"],
                      "tempsEstime" => $val[0]["fields"]["aggregatetimespent"]];
        }

        $nameP = $_GET["nameP"];
        $nameU = $_GET["nameU"];
        $idu = $_GET["idUser"];

        $loader = new \Twig\Loader\FilesystemLoader(BASE_PATH_TWIG);
        $twig = new \Twig\Environment($loader, [
            'cache' => false,
        ]);
        $twig->addGlobal('session', $_SESSION);
        $twig->addGlobal('modules', PROJECT_MODULES);

        echo $twig->render('/widgets/informatique/Altassian/widgetListeticketUser.html.twig', ['url' => 'informatique' , 'tableProjet' => $tab, 'nameP' => $nameP, 'nameU' => $nameU, 'idUser' => $idu]);
    }
}
