<?php
session_start();
ob_start();
require_once('vendor/autoload.php');
$app = new \Slim\Slim();

$app->get("/", function() {
    echo "THIS API - GET";
});

$app->post("/", function() {
    echo "THIS API - POST";
});
$app->notFound(function () use ($app) {
   echo "NOT FOUND";
});

$app->group('/auth', function () use ($app) {
  $app->post("/loginwithgoogle",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $fname =checkTextSQL($data["fname"]);
    $lname =checkTextSQL($data["lname"]);
    $email =checkTextSQL($data["email"]);
    $id =checkTextSQL($data["id"]);
    $img =$data["img"];
    $result = callApiFromBT_authLoginWithGoogle('auth/loginwithgoogle',$fname,$lname,$email,$id,$img);
    if(count($result)>0){
      $result=$result[0];
      // เก็บ SESSEION จาก $result['data]; or token = $result['data']['emp_token'];
     $_SESSION['emp_it_token'] = $result['data']['emp_token'];
     $_SESSION['emp_email'] = $result['data']['emp_email'];
     $_SESSION['emp_token'] = $result['data']['emp_token'];
     $_SESSION['emp_fname'] = $result['data']['emp_fname'];
     $_SESSION['emp_id'] = $result['data']['emp_id'];


     $_SESSION['emp'] = $result['data'];

    }
    echo json_encode($result);
  });
  $app->post("/loginwithempcode",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataApi =checkTextSQL($data["data"]);
    $token =checkTextSQL($data["token"]);
    $result = callApiFromBT_authLoginWithEmpCode('auth/loginwithempcode',$type,$dataApi,$token);
    if(count($result)>0){
      $result=$result[0];
      if($type=='otp'){
         // เก็บ SESSEION จาก $result['data]; or token = $result['data]['emp_token'];
      $_SESSION['emp_it_token'] = $result['data']['emp_token'];
      $_SESSION['emp_email'] = $result['data']['emp_email'];
      $_SESSION['emp_token'] = $result['data']['emp_token'];
      $_SESSION['emp_fname'] = $result['data']['emp_fname'];
      $_SESSION['emp_id'] = $result['data']['emp_id'];
       $_SESSION['emp'] = $result['data'];
         
      }
      
    }
    echo json_encode($result);
  });
});

$app->run();

function checkTextSQL($data){
  $data = str_replace("'","",$data);
  $data = str_replace("?","",$data);
  $data = str_replace("=","",$data);
  $data = str_replace("%","",$data);
  return $data;
}

function callApiFromBT_authLoginWithGoogle($url,$fname,$lname,$email,$id,$img){
  $datareturn = array(); 
  $url = "https://hr.bt-midland.com/api/auth/".$url;
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $AccessToken = '9cb40f22d441fb5a3c939f422abaa55cDGd6WMfMhWkksqUGlDV4';
  $headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer ".$AccessToken,
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $data = '{"fname":"'.$fname.'","lname":"'.$lname.'","email":"'.$email.'","id":"'.$id.'","img":"'.$img.'"}';
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  $resp = curl_exec($curl);
  $result = (array) json_decode($resp,true);
  curl_close($curl);
  // var_dump($resp);
  array_push($datareturn,$result);
  return $datareturn;
}

function callApiFromBT_authLoginWithEmpCode($url,$type,$dataApi,$token){
  $datareturn = array(); 
  $url = "https://hr.bt-midland.com/api/auth/".$url;
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $AccessToken = '9cb40f22d441fb5a3c939f422abaa55cDGd6WMfMhWkksqUGlDV4';
  $headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer ".$AccessToken,
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $data = '{"type":"'.$type.'","data":"'.$dataApi.'","token":"'.$token.'"}';
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
  

  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
 $resp = curl_exec($curl);
 $result = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $resp);
 $result = (array) json_decode($result,true);
 curl_close($curl);
 array_push($datareturn,$result);
 return $datareturn;
}


 ?>