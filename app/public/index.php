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
    $r->addRoute('GET', '/app/', 'Pap\Gescom\Controller\IndexController::index');
    $r->addRoute('GET', '/app/dashboard', 'Pap\Gescom\Controller\DashboardController::index');

    /****** INFORMATIQUE ******/
    $r->addRoute('GET', '/app/informatique', 'Pap\Gescom\Controller\Informatique\InformatiqueController::index');
    /****** ATLASSIAN *****/
    $r->addRoute('GET', '/app/Altassian', 'Pap\Gescom\Controller\Informatique\Altassian\AltassianController::index');
    $r->addRoute('GET', '/app/Altassian/oauth', 'Pap\Gescom\Controller\Informatique\Altassian\AltassianController::oauth');

    /******** WIDGETS ***********/
    $r->addGroup('/app/widgets', function (FastRoute\RouteCollector $r) {

        /************ Atlassian **********/
        $r->addRoute('GET', '/informatique/Altassian/widgetlisteUser', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::index');
        $r->addRoute('GET', '/informatique/Altassian/widgetListeProjet', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::project');
        $r->addRoute('GET', '/informatique/Altassian/widgetListeProjetUtilisateur/{idUser}', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::projectU');
        $r->addRoute('GET', '/informatique/Altassian/widgetListeticket/{idProjet}', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::TicketperProjet');
        $r->addRoute('GET', '/informatique/Altassian/widgetListeticketUser/{idProjet}/{idUser}', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::TicketperProjetUser');
        $r->addRoute('GET', '/informatique/Altassian/widgetListeIssueTempo', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\listeUserAltassianController::ListeIssueTempo');
        /***** TEMPO  ******/
        $r->addRoute('GET', '/informatique/Altassian/tempo/users', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoUsers');
        $r->addRoute('GET', '/informatique/Altassian/tempo/{user}/projets', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoProjets');
        $r->addRoute('GET', '/informatique/Altassian/tempo/{user}/{projet}/tickets', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoTickets');
        $r->addRoute('GET', '/informatique/Altassian/tempo/{user}/{projet}/{ticket}/times', 'Pap\Gescom\Controller\Widgets\Informatique\Altassian\tempoAltassianController::tempoTimes');

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

try {

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
}
catch (\Throwable $t) {
    header('Location: /app?message='.$t->getMessage().' File ='.$t->getFile().' line = '.$t->getLine());
    exit;
}

