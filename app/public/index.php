<?php
session_start();
require_once('../../globalconf.php');
require_once('../config/config.inc.php');
require_once('../vendor/autoload.php');

if (PROJECT_MAINTENANCE == 'TRUE'){
    echo "En maintenance";
    die();
}

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', 'Pap\Gescom\Controller\IndexController::index');
    $r->addRoute('GET', '/dashboard', 'Pap\Gescom\Controller\DashboardController::index');
    $r->addRoute('GET', '/informatique', 'Pap\Gescom\Controller\Informatique\InformatiqueController::index');
    $r->addGroup('/informatique', function (FastRoute\RouteCollector $r) {
        /****** ATLASSIAN *****/
        $r->addRoute('GET', '/Altassians', 'Pap\Gescom\Controller\Informatique\Altassian\AltassianController::index');
        $r->addRoute('GET', '/Altassians/oauth', 'Pap\Gescom\Controller\Informatique\Altassian\AltassianController::oauth');
    });
    /******** WIDGETS ***********/
    $r->addGroup('/widgets', function (FastRoute\RouteCollector $r) {
        /************ Atlassian **********/
        $r->addRoute('GET', '/informatique/Altassians/widgetlisteUser', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::index');
        $r->addRoute('GET', '/informatique/Altassians/widgetListeProjet', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::project');
        $r->addRoute('GET', '/informatique/Altassians/widgetListeProjetUtilisateur/{idUser}', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::projectU');
        $r->addRoute('GET', '/informatique/Altassians/widgetListeticket/{idProjet}', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::TicketperProjet');
        $r->addRoute('GET', '/informatique/Altassians/widgetListeticketUser/{idProjet}/{idUser}', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::TicketperProjetUser');
        $r->addRoute('GET', '/informatique/Altassians/widgetListeIssueTempo', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::ListeIssueTempo');
        /***** TEMPO  ******/
        $r->addRoute('GET', '/informatique/Altassians/tempo/users', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoUsers');
        $r->addRoute('GET', '/informatique/Altassians/tempo/{user}/projets', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoProjets');
        $r->addRoute('GET', '/informatique/Altassians/tempo/{user}/{projet}/tickets', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoTickets');
        $r->addRoute('GET', '/informatique/Altassians/tempo/{user}/{projet}/{ticket}/times', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoTimes');
    });

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$uri = substr($uri, strlen(PROJECT_ROOT), strlen($uri));

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);


    switch ($routeInfo[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            echo '404';

            break;

        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $allowedMethods = $routeInfo[1];
            echo '405';

            break;

        case FastRoute\Dispatcher::FOUND:
            $handler = $routeInfo[1];
            $vars = $routeInfo[2];
            list($class, $method) = explode('::', $handler, 2);
            call_user_func_array([new $class(), $method], $vars);

            break;
    }


