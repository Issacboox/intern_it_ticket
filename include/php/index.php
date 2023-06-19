<?php
session_start();
ob_start();

require_once('vendor/autoload.php');
require_once('../_PHPMailer/src/Exception.php');
require_once('../_PHPMailer/src/PHPMailer.php');
require_once('../_PHPMailer/src/SMTP.php');
require_once('function_main.php');
// require_once('user.php');
require_once('function.php');


// require_once('function_contract.php');
// require_once('function_pm.php');






// require_once '../../include/PHPMailer/src/Exception.php';
// require_once '../../include/PHPMailer/src/PHPMailer.php';
// require_once '../../include/PHPMailer/src/SMTP.php';


// use \Slim\App;
// $app = new App();
// \Slim\Slim::registerAutoloader();
// $app = new \Slim\Slim();
$app = new \Slim\Slim();



$app->get("/", function() {
    echo "API WEB PLANNEDPRO CREATIVE SOLUTIONS";
});
$app->post("/", function() {
    echo "API WEB PLANNEDPRO CREATIVE SOLUTIONS";
});

$app->notFound(function () use ($app) {
   echo "NOT FOUND 404";
});

$app->group('/company', function () use ($app) {
    $app->get('/add', function () {
       echo "add";
    });
    $app->get('/create', function ($request, $response) {
        echo "create";
    });

});
 

$app->group('/getdata', function () use ($app) {
  $app->post("/TypeRequest",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getdataTypeRequest($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/HistoryRequest",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getdataHistoryRequest($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });


});






















$app->group('/get', function () use ($app) {
  $app->post("/dashboard",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getDashboard($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/viewPM",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getdataPMPlanForcustomer($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });
  $app->post("/PM",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = managePM_($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  
  
});

$app->group('/setting', function () use ($app) {
  $app->post("/account",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = manageAccount($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });
  $app->post("/admin",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = manageAdmin($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  
  
});














$app->run();





function checkTextSQL($data){
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  return $data;
}
function checkTextSQLv2($data){
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  // $data = str_replace("'","",$data);
  // $data = str_replace("?","",$data);
  // $data = str_replace("=","",$data);
  // $data = str_replace("%","",$data);
  return $data;
}

function checkTextSQLv3($data){
  $data = str_replace("'","",$data);
  $data = str_replace("?","",$data);
  $data = str_replace(";","",$data);
  $data = str_replace("%","",$data);
  $data = str_replace("</","<\/",$data);

  
  return $data;
}







 ?>