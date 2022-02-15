<?php

namespace Pap\Gescom\Model\Widgets\Manager\Informatique\Altassian;

use Nahid\JsonQ\Jsonq;

class tempoAltassianManager
{

    /**
     *==============================================================================================================
     * Récupère tous les tickets Tempo
     *
     * @param string $fileT chemin du fichier issueTempo.json
     *==============================================================================================================
     */
    function requestIssueTempo($fileT){

        $q = new Jsonq($fileT);
        $res = $q->from('results')
            ->groupBy('issue.key');
        return $res;

    }

    /**
     *==============================================================================================================
     * Récupère tous les utilisateurs du gorupe Developpers
     *
     * @param string $fileT chemin du fichier issueTempo.json
     *==============================================================================================================
     */
    function requestUser($fileUser){

        $q = new Jsonq($fileUser);
        $res = $q->from('results')
            ->groupBy('issue.key');
        return $res;

    }

    /**
     *==============================================================================================================
     * Récupère tous les projets par Utilisateur
     *
     * @param string $fileT chemin du fichier issueTempo.json
     * @param string $user id de l'utilisateur
     *==============================================================================================================
     */
    function requestprojetPerUser($fileProjet, $user){

        $q = new Jsonq($fileProjet);
        $res = $q->from('results')
            //->where(...$user)
            ->groupBy('issue.key');
        return $res;

    }

    /**
     *==============================================================================================================
     * Récupère tous les projets par Utilisateur
     *
     * @param string $fileT chemin du fichier issueTempo.json
     * @param string $user id de l'utilisateur
     * @param string $projet id du projet
     *==============================================================================================================
     */
    function requestTicketperProjet_User($fileTicket, $user, $projet){

        $q = new Jsonq($fileTicket);
        $res = $q->from('results')
            //->where(...$user)
            //->where(...$projet)
            ->groupBy('issue.key');
        return $res;

    }

    /**
     *==============================================================================================================
     * Récupère tous les temps TEMPO par Projet et Utilisateur et par Ticket
     *
     * @param string $fileT chemin du fichier issueTempo.json
     * @param string $user id de l'utilisateur
     * @param string $projet id du projet
     * @param string $ticket id du ticket
     *==============================================================================================================
     */
    function requestTimeperTicket_Projet_User($fileTime, $user, $projet, $ticket){

        $q = new Jsonq($fileTime);
        $res = $q->from('results')
            //->where(...$user)
            //->where(...$projet)
            //->where(...$ticket)
            ->groupBy('issue.key');
        return $res;

    }

}