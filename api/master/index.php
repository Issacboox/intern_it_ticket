<?php
session_start();
ob_start();

require_once('vendor/autoload.php');
// require_once('../_PHPMailer/src/Exception.php');
// require_once('../_PHPMailer/src/PHPMailer.php');
// require_once('../_PHPMailer/src/SMTP.php');
// require_once '../../include/PHPMailer/src/Exception.php';
// require_once '../../include/PHPMailer/src/PHPMailer.php';
// require_once '../../include/PHPMailer/src/SMTP.php';
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
require_once('function_main.php');
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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

  // $app->post("/DataRequest",function() use($app){
  //   $json = $app->request->getBody();
  //   $app->response->setStatus(200);
  //   $contentType = $app->response->headers->get('Content-Type');
  //   $app->response->headers->set('Content-Type', 'application/json');
  //   $data = json_decode($json,true);
  //   $type =checkTextSQL($data["type"]);
  //   $dataoption = checkTextSQL($data["dataoption"]);
  //   $dataAPI =checkTextSQLv2($data["data"]);
  //   $result = getDataRequest($type,$dataAPI,$dataoption);
  //   echo json_encode($result);
  // });
   $app->post("/CurrentJobRequest",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getCurrentJobRequest($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });
  $app->post("/responderSetting",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getresponderSetting($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/TicketComplete",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getTicketComplete($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/typeRequestSetting",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getdatatypeRequestSetting($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/sugestcardSetting",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getsugestcardSetting($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/SugestCardguide",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getSugestCardguide($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/responderManagement",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getresponderManagement($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/allEmpforTicket",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getallEmpforTicket($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/checkTimelineTicket",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = getcheckTimelineTicket($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  $app->post("/uploadFile",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQL($data["data"]);
    $result = UploadFileImgToServer($type,$dataAPI,$dataoption);
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

  $app->post("/set",function() use($app){
    $json = $app->request->getBody();
    $app->response->setStatus(200);
    $contentType = $app->response->headers->get('Content-Type');
    $app->response->headers->set('Content-Type', 'application/json');
    $data = json_decode($json,true);
    $type =checkTextSQL($data["type"]);
    $dataoption = checkTextSQL($data["dataoption"]);
    $dataAPI =checkTextSQLv2($data["data"]);
    $result = manageSetting_SET($type,$dataAPI,$dataoption);
    echo json_encode($result);
  });

  
  
});

$app->post("/setStatus",function() use($app){
  $json = $app->request->getBody();
  $app->response->setStatus(200);
  $contentType = $app->response->headers->get('Content-Type');
  $app->response->headers->set('Content-Type', 'application/json');
  $data = json_decode($json,true);
  $tableDB =checkTextSQL($data["tableDB"]);
  $columnstatus =checkTextSQL($data["columnstatus"]);
  $columnwhere =checkTextSQL($data["columnwhere"]);
  $newstatus =checkTextSQL($data["newstatus"]);
  $id =checkTextSQL($data["id"]);
  $result = SetStatus($tableDB,$columnstatus,$newstatus,$columnwhere,$id);
  echo json_encode($result);
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



function UploadFileImgToServer($type,$dataAPI,$dataoption){
  $data =array();
  // $emp = $_SESSION["emp"];
  if($type=='save'){
      $newFileName = new_token(20);
      // $newFileName = $dataAPI['name'];

      $photo = $dataAPI['file'];
      

      $photo = str_replace('data:image/png;base64,', '', $photo);
      $photo = str_replace('data:image/jpeg;base64,', '', $photo);
      $photo = str_replace('data:image/gif;base64,', '', $photo);
      $photo = str_replace('data:image/webp;base64,', '', $photo);
      $photo = str_replace('data:image/svg+xml;base64,', '', $photo);
      $photo = str_replace('data:application/octet-stream;base64,', '', $photo);
      $entry = base64_decode($photo);
    //   $image = imagecreatefromstring($entry);
      $fileName = time().$newFileName. ".png";
      // $fileName = $newFileName. ".png";

      $path = "../../include/uploads/guide/".$dataAPI['folder']."/";
    //   $savepath = "img/uploads/".$dataAPI['folder']."/";
      $directory =  $path. $fileName;
      if(file_put_contents($directory,$entry)){
    //     // insertSQL('uploadfile', 'file_name,file_for,file_path,file_empId,file_status,file_token,file_type,file_dateupload', '?,?,?,?,?,?,?,?', 
    //     // array($fileName,'work',$savepath,$emp['emp_id'],1,$newTokenFile,'image/png',time()));
        // $fileSize = getimagesize($directory);
        // $imageResourceId = imagecreatefromstring(file_get_contents($directory));
        // $targetLayer = imageResize($imageResourceId,$fileSize[0],$fileSize[1]);
        // imagepng($targetLayer,$directory);
        array_push($data,array('fileName'=>$fileName,'path'=>$path));
      }
    
    // array_push($data,array('dataAPI'=>$photo));
  }
  
  if(count($data)>0){
    $datareturn=array('status'=>200,'msg'=>'this data','data'=>$data,'dataoption'=>$dataoption,'api'=>$dataAPI);
  }else{
    $datareturn=array('status'=>404,'msg'=>'อัพโหลดรูปภาพผิดพลาด โปรดลองอีกครั้งภายหลัง','data'=>array());
  }
  return $datareturn;
}





 ?>