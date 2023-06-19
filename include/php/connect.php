<?php

$host="powerbi";
$userName="it_ticket";
$userPassword = "ITticket@23##";
$dbName="hr";
try{
    $db= new PDO("sqlsrv:Server=$host; Database= $dbName", $userName, $userPassword);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $ex){
   echo $ex->getMessage();
}

$userNamehr="connectHR";
$userPasswordhr = "HRbtmidland###";
$dbNameHr="hr";
try{
    $dbHR= new PDO("sqlsrv:Server=$host; Database= $dbNameHr", $userNamehr, $userPasswordhr);
    $dbHR->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $ex){
   // echo $ex->getMessage();
}




?>
