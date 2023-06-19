<?php
// session_start();
// ob_start();
date_default_timezone_set("Asia/Bangkok");

require_once('connect.php');

function getDataSQL1($tablename,$whereColumn,$condition){
  global $db;
  // $tablename = '[hr].[dbo].['.$tablename.']';
  // $whereColumn = '['.$whereColumn.']';
  $getdata = $db->prepare('SELECT TOP 1 * FROM '.$tablename.'  WHERE '.$whereColumn.'=?    ');
  $getdata->execute(array($condition));
  $dataSelect = $getdata->fetch(PDO::FETCH_ASSOC);
  return $dataSelect;
}
function getDataSQLv1($type,$tablename,$condition){
  global $db;
  $DataArray = array();
  if($type==1){
    $getdata = $db->prepare(''.$tablename.'');
    $getdata->execute($condition);
    while($dataSelect = $getdata->fetch(PDO::FETCH_ASSOC)){
      array_push($DataArray,$dataSelect);
    }
  }
  return $DataArray;
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
  // global $dbHR,$db;
  $_SESSION['from-page']=$_SERVER['REQUEST_URI'];

  if(isset($_COOKIE['emp_email']) && isset($_COOKIE['emp_token'])){
    $_SESSION["emp_email"] = $_COOKIE['emp_email'];
    $_SESSION["emp_token"] = $_COOKIE['emp_token'];
  }


  if(isset($_SESSION["emp_it_token"])){
    $dataSelect = getDataSQL1('user_emp_view','emp_token',$_SESSION["emp_it_token"]);
    // print_r($dataSelect);
    if(!$dataSelect){
      echo '<script>window.location="./auth"</script>';
    }else{
      if($dataSelect['emp_status']==0){
        session_destroy();
        // echo '<script>window.location="./auth"</script>';
      }else{
        // print_r($_SESSION["emp_it_token"]);
        // // isset($_COOKIE['emp_token'])?  $_SESSION["emp_token"] = $_COOKIE['emp_token'] : null;
// isset($_COOKIE['emp_it_token'])?  $_SESSION["emp_it_token"] = $_COOKIE['emp_it_token'] : null;
// isset($_COOKIE['emp_fname'])?  $_SESSION["emp_fname"] = $_COOKIE['emp_fname'] : null;
// isset($_COOKIE['emp_email'])?  $_SESSION["emp_email"] = $_COOKIE['emp_email'] : null;
// isset($_COOKIE['emp_id'])?  $_SESSION["emp_id"] = $_COOKIE['emp_id'] : null;

$_SESSION["emp_profile"]=$dataSelect['emp_profile'];
$_SESSION["emp_lname"]=$dataSelect['emp_lname'];



// isset($_SESSION["emp_token"])?setcookie('emp_token', $_SESSION["emp_token"], time() + (86400 * 30), "/"):null;
  isset($_SESSION["emp_fname"])?setcookie('emp_fname', $_SESSION["emp_fname"], time() + (86400 * 30), "/"):null;
  isset($_SESSION["emp_email"])?setcookie('emp_email', $_SESSION["emp_email"], time() + (86400 * 30), "/"):null;
  isset($_SESSION["emp_id"])?setcookie('emp_id', $_SESSION["emp_id"], time() + (86400 * 30), "/"):null;
  isset($_SESSION["emp_it_token"])?setcookie('emp_it_token', $_SESSION["emp_it_token"], time() + (86400 * 30), "/"):null;

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
 



function getDataUserPermisionByRolesTypeAndSessionToken($Key){
  $dataUserAdmin = getDataSQLv1(1,'SELECT * FROM  it_emp_roles with(nolock)
  left join user_emp_view with(nolock) on roles_emp_id=emp_id
   left join it_roles_type with(nolock) on it_emp_roles.roles_typeId=it_roles_type.roles_typeId
  where roles_typeKey=? AND roles_status=? AND emp_token=?',array($Key,1,$_SESSION["emp_token"]));
  $return = false;
  if(count($dataUserAdmin)>0){
    $return = true;
  }

 return $return;
}

function getDataUserPermisionByRolesTypeAndSessionTokenAll(){
  $dataUserAdmin = getDataSQLv1(1,'SELECT * FROM  it_emp_roles with(nolock)
   left join it_roles_type with(nolock) on it_emp_roles.roles_typeId=it_roles_type.roles_typeId
  where roles_status=1 AND roles_emp_id=?',array($_SESSION["emp_id"]));
  $return = false;
  if(count($dataUserAdmin)>0){
    $_SESSION['permission']=$dataUserAdmin;
  }else{
    $_SESSION['permission'] = array();
  }

//  return $return;
}

?>