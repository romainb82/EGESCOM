<?php

//phpinfo();


include "globalconf.php";

if (PROJECT_MAINTENANCE == 'TRUE'){

    header('Location: /maintenance.html');
    exit();

}else{

    header('Location: /aide-au-chargement/');
    exit();
}


