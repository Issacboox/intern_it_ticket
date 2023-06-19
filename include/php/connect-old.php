<?php

/** *//** *//** *//** *//** *//** *//** *//*
$host="localhost";
$user="plannedp_demoProject";
$pass = "oy75qWks";
$db_name="plannedp_demoProject";
/**//*/**//** *//** *//** *//** */
$host="localhost";
$user="root";
$pass = "";
$db_name="proj_it";
/**//** *//** *//** *//** *//**//** *//*
$host="localhost";
$user="airkhonk_ean";
$pass = "O2cFRiXDwG";
$db_name="airkhonk_ean";
/**/
try{
    $db= new PDO('mysql:host='.$host.';dbname='.$db_name.';charset=utf8',$user,$pass);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $db->query("set names utf8");

}catch(PDOException $ex){
    echo $ex->getMessage();
}


/*
mysql_query("SET NAMES UTF8");
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET NAMES UTF8");
*/





?>
