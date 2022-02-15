<?php
namespace Pap\Gescom\Model\Widgets\Manager\Informatique\Altassian;

use Nahid\JsonQ\Jsonq;

class listeUserAltassianManager
{
    /**
     *==============================================================================================================
     * decode le fichier searchTask pour poouvoir l'exploiter
     *
     * @param string $fileT chemin du fichier searchTask.json
     *==============================================================================================================
     */
    public function listeTaskManager($fileT){

        //Exploitation du fichier searchTask.json
        $dataT = file_get_contents($fileT);
        $objTicket = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $dataT), true);
        return $objTicket;

    }

    /**
     *==============================================================================================================
     * Requete Json sur le fichier searchTask pour récupèrer tous les utilisteurs distinct
     *
     * @param string $fileT chemin du fichier searchTask.json
     *==============================================================================================================
     */
    function requestUser($fileT){

        $q = new Jsonq($fileT);
        $res = $q->from('issues')
            ->groupBy('fields.customfield_10065.0.displayName');
        return $res;
    }

    /**
     *==============================================================================================================
     * Récupère tous les utilisateurs ou le nom = $name
     *
     * @param string $fileT chemin du fichier searchTask.json
     * @param string $name nom de l'utilisateur récupèrer dans la route
     *==============================================================================================================
     */
    //Récupération de tous les utilisateurs avec le temps total passé sur un ticket
    function requestAvgTime($fileT,$name){

        $q = new Jsonq($fileT);
        $res = $q->from('issues')
            ->where('fields.customfield_10065.0.displayName','=', $name)
            ->sum('fields.timespent');
        return $res;
    }

    /**
     *==============================================================================================================
     * Récupère tous les projets
     *
     * @param string $fileT chemin du fichier searchTask.json
     *==============================================================================================================
     */
    function requestProject($fileT){

        $q = new Jsonq($fileT);
        $res = $q->from('issues')
            ->groupBy('fields.project.name');
        return $res;
    }

    /**
     *==============================================================================================================
     * Récupère tous les tickets ou le nom du projet = $idP
     *
     * @param string $fileT chemin du fichier searchTask.json
     * @param string $idP id du projet récupèrer dans la route
     *==============================================================================================================
     */
    function requestTicket($fileT, $idP){

        $q = new Jsonq($fileT);
        $res = $q->from('issues')
            ->where('fields.project.id','=',$idP)
            ->groupBy('fields.summary');
        return $res;
    }

    /**
     *==============================================================================================================
     * Récupère tous les projets ou l'utilisateur = $idu
     *
     * @param string $fileT chemin du fichier searchTask.json
     * @param string $idU nom de l'utilisateur récupèrer dans la route
     *==============================================================================================================
     */
    function requestProjectperUser($fileT, $idU){

        $q = new Jsonq($fileT);
        $res = $q->from('issues')
            ->where('fields.customfield_10065.0.accountId','=',$idU)
            ->groupBy('fields.project.name');
        return $res;
    }

    /**
     *==============================================================================================================
     * Récupère tous les tickets ou le nom du projet = $idP
     *
     * @param string $fileT chemin du fichier searchTask.json
     * @param string $idP id du projet récupèrer dans la route
     * @param string $idU id de l'utilisateur récupèrer dans la route
     *==============================================================================================================
     */
    function requestTicketperProjet($fileT, $idU, $idP){

        $q = new Jsonq($fileT);
        $res = $q->from('issues')
            ->where('fields.project.id','=',$idP)
            ->where('fields.customfield_10065.0.accountId','=',$idU)
            ->groupBy('fields.summary');
        return $res;
    }
}
