<?php
// session_start();
// ob_start();
date_default_timezone_set("Asia/Bangkok");

require_once('connect.php');

function getDataSQL1($tablename,$whereColumn,$condition){
  global $dbHR;
  // $tablename = '[hr].[dbo].['.$tablename.']';
  // $whereColumn = '['.$whereColumn.']';
  $getdata = $dbHR->prepare('SELECT TOP 1 * FROM '.$tablename.'  WHERE '.$whereColumn.'=?    ');
  $getdata->execute(array($condition));
  $dataSelect = $getdata->fetch(PDO::FETCH_ASSOC);
  return $dataSelect;
}

function checklogin(){
  global $dbHR;
  if(isset($_SESSION["emp_token"])){
    // echo $_SERVER['REQUEST_URI'];
    $dataSelect = getDataSQL1('users_emp','emp_token',$_SESSION["emp_token"]);
    if($dataSelect){
      echo '<script>window.location="../"</script>';
    }
  }
}

function checkloginMaster(){
  global $dbHR;
  $_SESSION['from-page']=$_SERVER['REQUEST_URI'];
  if(isset($_SESSION["emp_token"])){
    $dataSelect = getDataSQL1('users_emp','emp_token',$_SESSION["emp_token"]);
    
    if(!$dataSelect){
      echo '<script>window.location="./auth"</script>';
    }else{
      if($dataSelect['emp_status']==0){
        session_destroy();
        // echo '<script>window.location="./auth"</script>';
      }
    }
  }else{
        echo '<script>window.location="./auth"</script>';
  }
}
function checkloginEvauation(){
  global $dbHR;
  $_SESSION['from-page']=$_SERVER['REQUEST_URI'];
  if(isset($_SESSION["emp_token"])){
    $dataSelect = getDataSQL1('users_emp','emp_token',$_SESSION["emp_token"]);
    if(!$dataSelect){
      echo '<script>window.location="../auth"</script>';
    }
  }else{
        echo '<script>window.location="../auth"</script>';
  }
}

function active_show($url){
    $return="";
    if(isset($_GET["show"])){
      if($_GET["show"]==$url){
        $return = "active";
      }
    }
    return $return;
  }
  
function active_menu($url){
    $return="";
    if(isset($_GET["page"])){
      if($_GET["page"]==$url){
        $return = "active";
      }
    }elseif ($url=="home") {
      $return = "active";
    }
    return $return;
}
function menu_open($url){
    $return="";
    if(isset($_GET["page"])){
      if($_GET["page"]==$url){
        $return = "menu-open";
      }
    }
    return $return;
}
 


?>