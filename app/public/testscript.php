<?php

    //$option = array('i5_dbcs_alloc'=>1,'i5_lib'=>'DCP','i5_naming'=>DB2_I5_NAMING_ON);
    $option = array('i5_dbcs_alloc'=>1,'i5_libl'=>'DCP','i5_naming'=>DB2_I5_NAMING_ON);
    $db2 = db2_connect('*LOCAL','USRPHPDATA','USRPHPDATA',$option);
    if (!$db2){
        echo 'Bad authentification !!!';
        exit();
    }

    $sql = "select BACCL as CODE_CLIENT, BAART as CODE_ART, BAACT as CODE_ACT, BADTFA as DATE_FACT_ORIG "
    .", Date(SUBSTR( CHAR( BADTFA ),5,2) ||'/' || SUBSTR( CHAR ( BADTFA ),7,2) || '/' || SUBSTR( CHAR (BADTFA ),1,4)) as DATE_FACT "
    //.", F_MADATE(BADTFA) as DATE_FACT "
    //.", Date(SUBSTR( CHAR( BADTMJ ),5,2) ||'/' || SUBSTR( CHAR ( BADTMJ ),7,2) || '/' || SUBSTR( CHAR (BADTMJ ),1,4)) as DATE_MAJ "
    //.", Date(SUBSTR( CHAR( BADTLI ),5,2) ||'/' || SUBSTR( CHAR ( BADTLI ),7,2) || '/' || SUBSTR( CHAR (BADTLI ),1,4)) as DATE_LIVR "
    //.", Date(SUBSTR( CHAR( BADTML ),5,2) ||'/' || SUBSTR( CHAR ( BADTML ),7,2) || '/' || SUBSTR( CHAR (BADTML ),1,4)) as DATE_MAJ_LIVR "
    //.", (SELECT F_MADATE(BADTML) FROM SYSIBM.SYSDUMMY1) as DATE_MAJ_LIVR "
    .", F_MADATE(BADTML) as DATE_MAJ_LIVR "
    ."from SPF_MTB.GCBCPD "
    ."where BACCL = ? and BAVIS = 'O' "
    ."limit 50 ";  // offset fait planter F_MADATE

    //$sql = "values F_MADATE('20211231') ";

    /*$stmt = db2_exec($db2,$sql);
    $monMsg = 'SQLSTATE:' . db2_stmt_error() . ' Message:' . db2_stmt_errormsg();
    echo $monMsg;*/

    $param1 = '32015';

    $stmt = db2_prepare($db2,$sql);
    if (!$stmt){
        $monMsg = 'Prepare -> SQLSTATE:' . db2_stmt_error() . ' Message:' . db2_stmt_errormsg();
        echo $monMsg;
        exit();
    }
    db2_bind_param($stmt, 1, 'param1', DB2_PARAM_IN);

    if(!db2_execute($stmt)){
        $monMsg = 'Execute -> SQLSTATE:' . db2_stmt_error() . ' Message:' . db2_stmt_errormsg();
        echo $monMsg;
        exit();
    }


    while($result = db2_fetch_object($stmt)){
        var_dump($result);
    }

    /*
    // Display the result
    echo '<table id="table" style="width: 100%;" border="1">';
        echo '<thead>';
            echo '<tr>';
                echo '<th>CODE CLIENT</th>';
                echo '<th>CODE ARTICLE</th>';
                echo '<th>CODE ACT</th>';
                echo '<th>DATE FACT ORIG</th>';
                echo '<th>DATE FACT</th>';
            echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
            while ($result = db2_fetch_object($stmt)){
                echo '<tr>';
                echo '<td>' . $result->CODE_CLIENT . '</td>';
                echo '<td>' . $result->CODE_ART . '</td>';
                echo '<td>' . $result->CODE_ACT . '</td>';
                echo '<td>' . $result->DATE_FACT_ORIG . '</td>';
                echo '<td>' . $result->DATE_FACT . '</td>';
                echo '</tr>';
            }
        echo '</tbody>';
    echo '</table>';
    */

    echo '<br><br>Successful<br><br>';



