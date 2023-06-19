<?php

date_default_timezone_set("Asia/Bangkok");
require_once('../../include/php/connect.php');
// require_once '../PHPMailer/src/Exception.php';
// require_once '../PHPMailer/src/PHPMailer.php';
// require_once '../PHPMailer/src/SMTP.php';
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
// require_once('../../include/php/time.php');
$keyAPI = 'TiwPatipanSHfQ0QrwqlRdXpwzTxvEGd7QbiADFsxEIKzsVSYgMx30YroyvBNRd5CqUbPSjvPZM6gTaRzhdKsoY8TpYgy477C7Vxoe6PdTqoOhtPJSdn19PAk4';
if(!isset($_SESSION)){ session_start();}
ob_start();

function checkTextSQL2($data){
  $data = str_replace("'","",$data);
  $data = str_replace("?","",$data);
  $data = str_replace("=","",$data);
  $data = str_replace("%","",$data);
  return $data;
}
function TransactionId($len){
      $chars = "0123456789";
      $ret_char = "";
      $num = strlen($chars);
      for($i = 0; $i < $len; $i++) {
          $ret_char.= $chars[rand()%$num];
          $ret_char.="";
      }
      $ret_char=time()."".$ret_char;
      return $ret_char;
}
function new_token($len){
  $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  $ret_char = "";
  $num = strlen($chars);
  for($i = 0; $i < $len; $i++) {
      $ret_char.= $chars[rand()%$num];
      $ret_char.="";
  }
  return $ret_char;
}
function new_token_uppercase($len){
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $ret_char = "";
    $num = strlen($chars);
    for($i = 0; $i < $len; $i++) {
        $ret_char.= $chars[rand()%$num];
        $ret_char.="";
    }
    return $ret_char;
  }
function new_otp($len){
  $chars = "123456789";
  $ret_char = "";
  $num = strlen($chars);
  for($i = 0; $i < $len; $i++) {
      $ret_char.= $chars[rand()%$num];
      $ret_char.="";
  }
  return $ret_char;
}
function sensorNumber($number,$numDigit){
  $numcut = $numDigit-4;
  $x = "";
  for($i=1;$i<=$numcut;$i++){
    $x=$x."x";
  }
  $number=$x.substr($number,  $numcut, $numDigit-1);
  return $number;
}
function ConvertTimeToArray($time){
  $timeArray = array('dateOld'=>$time,'date'=>thai_date_short_v5($time),'time'=>time_tableTime($time),'full'=>thai_date_short_v4($time),'short'=>time_tableDate($time));
  return $timeArray;
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
  function getDataSQLBT($type,$tablename,$condition){
    global $db2016;
    $DataArray = array();
    if($type==1){
      $getdata = $db2016->prepare(''.$tablename.'');
      $getdata->execute($condition);
      while($dataSelect = $getdata->fetch(PDO::FETCH_ASSOC)){
        array_push($DataArray,$dataSelect);
      }
    }
    return $DataArray;
  }
  function getDataSQLHR($type,$tablename,$condition){
    global $dbHR;
    $DataArray = array();
    if($type==1){
      $getdata = $dbHR->prepare(''.$tablename.'');
      $getdata->execute($condition);
      while($dataSelect = $getdata->fetch(PDO::FETCH_ASSOC)){
        array_push($DataArray,$dataSelect);
      }
    }
    return $DataArray;
  }
  function updateSQL($tablename,$dataupdate,$whereColumn,$condition){
    global $db;
    $update = $db->prepare("UPDATE  $tablename SET $dataupdate WHERE $whereColumn");
    $update->execute($condition);
    return true;
  }
  function insertSQL($table,$insertColumn,$condition){
    global $db;
    $countColimn = explode(",",$insertColumn);
    $value = '';
    for($i=0;$i<count($countColimn);$i++){
        $i>0?  $value.=',' :  null;
        $value.='?';
    }
    $save = $db->prepare("INSERT INTO $table ($insertColumn) VALUES ($value)");
    $save->execute($condition);
    return $save;
  }

  function countColumn($tableDB,$condition){
    global $db;
    $check = $db->prepare("SELECT COUNT(*) FROM $tableDB");
    $check->execute($condition);
    $num = $check->fetchColumn();
    return  $num;
  }

  function setDataReturn($code,$data){
    if(count($data)>0){
      $datareturn = array('status'=>200,'msg'=>'you don\'t currently have permission to access this data','data'=>$data);
    }else{
      $datareturn = array('status'=>$code!=0?$code:403,'msg'=>'you don\'t currently have permission to access this data','data'=>$data);
    }
    return $datareturn;
  }

  function encrypt($key, $payload) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($payload, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
  }
  
  function decrypt($key, $data) {
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
  }


  function sendmailToEmp($from,$arrTo,$subject,$bodyHtml){
    $test = array($from,$arrTo,$subject,$bodyHtml);
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    $mail->IsSMTP(); 
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->SMTPAuth = true; 
    $mail->SMTPKeepAlive = true;
    $mail->Username = "survey@bt-midland.com";
    $mail->Password = "bTmidland@Survey1485##";
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';
    foreach($arrTo AS $to){
        $mail->AddAddress($to['mail'],$to['name']);
    }
    // ใส่ Email ที่ต้องการให้ reply กลับ ที่นี่ 
    $mail->AddReplyTo('survey@bt-midland.com','Admin');

    $mail->setFrom('survey@bt-midland.com',$from);
    $mail->WordWrap = 50; 
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $bodyHtml;
    // $mail->Body = "<div>Hello</div>";

    if($mail->Send()){
      $data=true;
    }else{
      $data=false;
    }
    // $mail = array($from,$arrTo,$arrCC,$arrFile,$subject,$bodyHtml);
    return $data;
}


function callAPISendMail($dataG){
  $curl = curl_init('https://report.bt-midland.com/api/private_test/service');
  curl_setopt($curl, CURLOPT_URL, 'https://report.bt-midland.com/api/private_test/service');
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $headers = array(
    "Content-Type: application/json",
    'Authorization: Bearer zv1KtOE81TdO2bY13Cu2eRN0sKMFLClOnsxcFLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG000000DSzO'
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $data = array( "type"=>"sendEmail_V2",
    "data"=>$dataG,
    "key" =>"zv1KtOE81TdO2bY13Cu2eRN0sKMFLClOnsxcFLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG000000DSzO"
  );
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $resp = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($resp);
  return $response;
}

function genWorkRanningNo($codeId){
  $NowYear = date('y');
  $NowMonth = date('m');
  $return = '-';
  $codeWorktype = getDataSQL(1,'it_request_type','type_id',$codeId);

  // $codeWorktype = getDataSQLv1(1,'SELECT  * FROM  type_request  WHERE id=?',array($codeId));
  if($codeWorktype){
    $code = $codeWorktype['type_code'];
  }else{
    $code = 'OT';
  }
  $search = $code.$NowYear.$NowMonth."%"; 
  $assign_work = getDataSQLv1(1,'SELECT TOP 1 * FROM  it_request  WHERE request_workNo LIKE ?  ORDER BY request_workNo DESC ',array($search));
  if(count($assign_work)>0){
    $DocNoLast = $assign_work[0]['request_workNo'];
    $last = substr($DocNoLast,-4);
    $last+=1;
  }else{
    $last=1;
  }
  $new=sprintf("%04d",$last);
  $return = $code.$NowYear.$NowMonth.$new;
  return $return;
}

function getDataSQL($type,$tablename,$whereColumn,$condition){
  global $db;
  $DataArray = array();
  if($type==1){
    // $tablename = ''.$tablename.'';
    // $whereColumn = '['.$whereColumn.']';
    $getdata = $db->prepare('SELECT * FROM '.$tablename.'  WHERE '.$whereColumn.'=?    ');
    $getdata->execute(array($condition));
    $dataSelect = $getdata->fetch(PDO::FETCH_ASSOC);
    $DataArray = $dataSelect;
  }else if($type==2){
    // $tablename = '[hr].[dbo].['.$tablename.']';
    // $whereColumn = '['.$whereColumn.']';
    $getdata = $db->prepare('SELECT * FROM '.$tablename.'  WHERE '.$whereColumn.'='.$condition.'    ');
    $getdata->execute(array());
    while($dataSelect = $getdata->fetch(PDO::FETCH_ASSOC)){
      array_push($DataArray,$dataSelect);
    }
  }
  return $DataArray;
}


function insertSQLv2($table,$insertColumn,$condition){
  global $db;
  $countColimn = explode(",",$insertColumn);
  $value = '';
  for($i=0;$i<count($countColimn);$i++){
      $i>0?  $value.=',' :  null;
      $value.='?';
  }
  $save = $db->prepare("INSERT INTO $table ($insertColumn) VALUES ($value)");
  $save->execute($condition);
  return $save;
}





function sendmailAttachment($from,$arrTo,$arrCC,$arrFile,$subject,$bodyHtml){
  //  $mail = new PHPMailer(true); 
   $mail = new PHPMailer\PHPMailer\PHPMailer();
  //   // $mail = new PHPMailer\PHPMailer\PHPMailer();
    // $mail->SMTPDebug = 2;  
    $mail->IsSMTP(); 
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->SMTPAuth = true; 
    $mail->SMTPKeepAlive = true;
    // $mail->Username = "notify.btmidland@gmail.com";
    // $mail->Password = "Bt@gmail2022";
    $mail->Username = "info@bt-midland.com";
    $mail->Password = "bTmidland@inFo1485##";
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';
    foreach($arrTo AS $to){
        $mail->AddAddress($to['mail'],$to['name']);
    }
    foreach($arrCC AS $cc){
        $mail->AddCC($cc['mail'],$cc['name']);
    }

    $mail->addBcc('patipan@bt-midland.com','Dev');
    
    // function addAttachment // ถ้าเปิดจะใช้เวลาในการแนบไฟล์มากขึั้น
    foreach($arrFile AS $file){
        $mail->addAttachment($file[0],$file[1]);
    }
    // $mail->AddAttachment('../../include/file/PatientTransfer/BT2305HC003_4eVaZ.pdf', 'BT2305HC003_4eVaZ.pdf');

    $mail->AddReplyTo('amonrat@bt-midland.com','Admin');
    $mail->setFrom('amonrat@bt-midland.com',$from);
    $mail->WordWrap = 50; 
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $bodyHtml;
    if($mail->Send()){
      $data=true;
    }else{
      $data=false;
    }
    return $data;
  }



function createHTMLEmailToStaff($token){

  $dataWorkRequest = getDataSQLv1(1, "SELECT *,
  FORMAT(request_create_at, 'yyyy-MM-dd') AS Senddate,
  FORMAT(request_create_at, 'HH:mm') AS Sendtime,
  FORMAT(request_duedate, 'yyyy-MM-dd') AS Duedate,
  FORMAT(request_duedate, 'HH:mm') AS Duetime
  FROM it_request
  LEFT JOIN it_request_type ON request_type = type_id
  LEFT JOIN user_emp_view ON requestor_id = emp_id
  WHERE request_token = ?", array($token));



  foreach($dataWorkRequest AS $request){
    // $requestor = getDataSQLv1(1, 'SELECT top  1 * FROM user_emp_view WHERE emp_id=?', array($request['requestor_id']));
    $dataResponder = getDataSQLv1(1, 'SELECT top 1 * FROM user_emp_view WHERE emp_id=?', array($request['request_responder']));
    $dataFile = getDataSQLv1(1, 'SELECT  * FROM it_uploadfile WHERE file_ref=?', array($request['request_token']));
    $TXTFile = '';
    $domain = 'https://it.btm.co.th/';
    
    foreach($dataFile AS $file){
      $TXTFile.='<div><a  href="'.$domain.'include/uploads/'.$file['file_path'].$file['file_name'].'">'.$file['file_name'].' &#128209; </a></div>';
    }

    $nameResponder = '';
    foreach($dataResponder AS $Responder){
      $nameResponder = $Responder['emp_fname'].' '.$Responder['emp_lname'];
    }


    $txt1 ='';
    if($request['request_urgent']==1){
      $txt1 = 'ต้องการภายใน | '.$request['Duedate'].' เวลา '.$request['Duetime'].'น.';
    }

   

  
  return '<!DOCTYPE html>
  <html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
  
  <head>
      <title></title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]--><!--[if !mso]><!-->
  
      <style>
          * {
              box-sizing: border-box;
          }
  
          body {
              margin: 0;
              padding: 0;
          }
  
          a[x-apple-data-detectors] {
              color: inherit !important;
              text-decoration: inherit !important;
          }
  
          #MessageViewBody a {
              color: inherit;
              text-decoration: none;
          }
  
          p {
              line-height: inherit
          }
  
          .desktop_hide,
          .desktop_hide table {
  
              display: none;
              max-height: 0px;
              overflow: hidden;
          }
  
          .image_block img+div {
              display: none;
          }
  
          @media (max-width:770px) {
              .desktop_hide table.icons-inner {
                  display: inline-block !important;
              }
  
              .icons-inner {
                  text-align: center;
              }
  
              .icons-inner td {
                  margin: 0 auto;
              }
  
              .row-content {
                  width: 100% !important;
              }
  
              .mobile_hide {
                  display: none;
              }
  
              .stack .column {
                  width: 100%;
                  display: block;
              }
  
              .mobile_hide {
                  min-height: 0;
                  max-height: 0;
                  max-width: 0;
                  overflow: hidden;
                  font-size: 0px;
              }
  
              .desktop_hide,
              .desktop_hide table {
                  display: table !important;
                  max-height: none !important;
              }
  
              .reverse {
                  display: table;
                  width: 100%;
              }
  
              .reverse .column.first {
                  display: table-footer-group !important;
              }
  
              .reverse .column.last {
                  display: table-header-group !important;
              }
  
              .row-1 td.column.first .border {
                  padding: 35px 0 35px 25px;
                  border-top: 0;
                  border-right: 0px;
                  border-bottom: 0;
                  border-left: 0;
              }
  
              .row-1 td.column.last .border {
                  padding: 5px 0;
                  border-top: 0;
                  border-right: 0px;
                  border-bottom: 0;
                  border-left: 0;
              }
          }
      </style>
  </head>
  
  <body style="background-color: #f2f2f2; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
      <table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
          style=" background-color: #f2f2f2;">
          <tbody>
              <tr>
                  <td>
                      <table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                          role="presentation">
                          <tbody>
                              <tr>
                                  <td>
                                      <table class="row-content stack" align="center" border="0" cellpadding="0"
                                          cellspacing="0" role="presentation"
                                          style=" background-color: #ffffff; color: #000000; width: 750px;" width="750">
                                          <tbody>
                                              <tr class="reverse">
                                                  <td class="column column-1 first" width="83.33333333333333%"
                                                      style=" font-weight: 400; text-align: left; padding-bottom: 35px; padding-left: 25px; padding-top: 35px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                      <div class="border">
                                                          <table class="heading_block block-1" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-left:5px;padding-top:10px;text-align:center;width:100%;">
                                                                      <h1
                                                                          style="margin: 0; color: #fe7062; direction: ltr;  font-size: 13px; font-weight: 700; letter-spacing: 1px; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;">
                                                                          <span
                                                                              class="tinyMce-placeholder">Notification</span>
                                                                      </h1>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                          <table class="heading_block block-2" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-left:5px;padding-right:5px;padding-top:5px;text-align:center;width:100%;">
                                                                      <h1
                                                                          style="margin: 0; color: #2f2e41; direction: ltr; font-size: 26px; font-weight: 400; letter-spacing: 1px; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;">
                                                                          <strong>Your ticket has been received! </strong>&nbsp; <strong>#'.$request['request_workNo'].'🎫</strong>
                                                                      </h1>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                          <table class="paragraph_block block-3" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation"
                                                              style=" word-break: break-word;">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-bottom:10px;padding-left:5px;padding-right:5px;">
                                                                      <div
                                                                          style="color:#393d47;direction:ltr; font-size:16px;font-weight:400;letter-spacing:0px;line-height:150%;text-align:left;">
                                                                          <p style="margin: 0;">please wait a moment.
                                                                          We will repair it as soon as possible.  </p>
                                                                      </div>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                      </div>
                                                  </td>
                                                  <td class="column column-2 last" width="16.666666666666668%"
                                                      style=" font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                      <div class="border">
                                                          <table class="image_block block-1" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-top:45px;width:100%;padding-right:0px;padding-left:0px;">
                                                                      <div class="alignment" align="center"
                                                                          style="line-height:10px"><img
                                                                              src="https://survey.btm.co.th/include/img/logo_bt_midland.png"
                                                                              style="display: block; height: auto; border: 0; width: 88px; max-width: 100%;"
                                                                              width="88"></div>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                      </div>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                      <table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                          role="presentation">
                          <tbody>
                              <tr>
                                  <td>
                                      <table class="row-content stack" align="center" border="0" cellpadding="0"
                                          cellspacing="0" role="presentation"
                                          style=" background-color: #ffffff; color: #000000; border-radius: 0; width: 750px;"
                                          width="750">
                                          <tbody>
                                              <tr>
                                                  <td class="column column-1" width="100%"
                                                      style=" font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                      <table class="text_block block-1" width="100%" border="0"
                                                          cellpadding="0" cellspacing="0" role="presentation"
                                                          style=" word-break: break-word;">
                                                          <tr>
                                                              <td class="pad" style="padding-right:30px;">
                                                                  <div>
                                                                      <div class
                                                                          style="font-size: 12px;   color: #000000; line-height: 1.2;">
                                                                          <p
                                                                              style="margin: 0; font-size: 12px; text-align: right;">
                                                                              <span style="font-size:18px;"><strong>ประเภท
                                                                                  </strong>| '.$request['type_name'].'</span>
                                                                          </p>
                                                                      </div>
                                                                  </div>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                      <table class="divider_block block-2" width="100%" border="0"
                                                          cellpadding="10" cellspacing="0" role="presentation">
                                                          <tr>
                                                              <td class="pad">
                                                                  <div class="alignment" align="center">
                                                                      <table border="0" cellpadding="0" cellspacing="0"
                                                                          role="presentation" width="100%">
                                                                          <tr>
                                                                              <td class="divider_inner"
                                                                                  style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;">
                                                                                  <span>&#8202;</span>
                                                                              </td>
                                                                          </tr>
                                                                      </table>
                                                                  </div>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                      <table style="font-size: 16px; padding: 20px; text-align: top;">
                                                          <tr>
                                                              <td style="width: 25%;"><strong>ทำรายการโดย</strong></td>
                                                              <td style="width: 50%;">'.$request['emp_fname'].'  '.$request['emp_lname'].' </td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>เรื่อง</strong></td>
                                                              <td>'.$request['request_title'].'</td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>รายละเอียด</strong></td>
                                                              <td style="line-height:1">'.$request['request_description'].'</td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>เวลาที่ทำรายการ</strong></td>
                                                              <td>'.date('H:i วันที่ d/m/Y',strtotime($request['request_create_at'])).'</td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>ผู้รับผิดชอบ</strong></td>
                                                              <td>'.$nameResponder.'</td>
                                                          </tr>
                                                          <tr >
                                                              <td style="color: #ff0101;  display: flex;
                                                              align-items: flex-start;"><strong>Remark</strong></td>
                                                              <td>'.$txt1.'</td>
                                                          </tr>
                                                          <tr>
                                                          <td style="
                                                          display: flex;
                                                          align-items: flex-start;"><strong>ไฟล์แนบ</strong></td>
                                                          <td>'.$TXTFile.'</td>
                                                      </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                      
                  </td>
              </tr>
          </tbody>
      </table><!-- End -->
  </body>
  
  </html>';
  }

}
function sendEmailNotifyOnUpdateStatus($id){
  global $keyAPI;
  $dataWorkRequest = getDataSQLv1(1, 'SELECT * FROM it_request
  left join it_request_type on request_type=type_id
  WHERE request_id=?', array($id));
  foreach($dataWorkRequest AS $request){

    $requestor = getDataSQLv1(1, 'SELECT top  1 * FROM user_emp_view WHERE emp_id=?', array($request['requestor_id']));
    $dataResponder = getDataSQLv1(1, 'SELECT top 1 * FROM user_emp_view WHERE emp_id=?', array($request['request_responder']));
    foreach($dataResponder AS $emp){
            // $Email = 'nurarat0024@gmail.com';
            // $Name = 'User Test';
            $Email = $requestor[0]['emp_email'];
            $Name = $requestor[0]['emp_fname'];
            if(count($requestor)>0){
              $arrTo = array();
              $arrCC = array();
              $arrFile = array();
              $from = $requestor[0]['emp_fname'] . ' ' . $requestor[0]['emp_lname'];
              $subject = 'Ticket  #'.$request['request_workNo']. ' Update';
              $bodyHtml_to=createEmailNotifyOnUpdateStatus($id);

              // $dataFile = getDataSQLv1(1, 'SELECT  * FROM it_uploadfile WHERE file_ref=?', array($token));
              // foreach($dataFile AS $file){
              //   array_push($arrFile,array('./include/uploads/'.$file['file_path'].$file['file_name'],$file['file_name']));
              // }
              array_push($arrTo,array('mail'=>$Email,'name'=>$Name));
              array_push($arrTo,array('mail'=>$emp['emp_email'],'name'=>$emp['emp_fname']));


              // array_push($arrCC,array('mail'=>'it@btm.co.th','name'=>'IT Ticket'));
              array_push($arrCC,array('mail'=>'patipan@btm.co.th','name'=>'IT Ticket'));
              $sand= sendmailAttachment($from,$arrTo,$arrCC,$arrFile,$subject,$bodyHtml_to);
              // return $sand;
            }
    }

  }
}
function createEmailNotifyOnUpdateStatus($id){
  
  $dataWorkRequest = getDataSQLv1(1, "SELECT *,
  FORMAT(request_create_at, 'yyyy-MM-dd') AS Senddate,
  FORMAT(request_create_at, 'HH:mm') AS Sendtime,
  FORMAT(request_duedate, 'yyyy-MM-dd') AS Duedate,
  FORMAT(request_duedate, 'HH:mm') AS Duetime
  FROM it_request
  LEFT JOIN it_request_type ON request_type = type_id
  LEFT JOIN user_emp_view ON requestor_id = emp_id
  WHERE request_id = ?", array($id));



  foreach($dataWorkRequest AS $request){
    // $requestor = getDataSQLv1(1, 'SELECT top  1 * FROM user_emp_view WHERE emp_id=?', array($request['requestor_id']));
    $dataResponder = getDataSQLv1(1, 'SELECT top 1 * FROM user_emp_view WHERE emp_id=?', array($request['request_responder']));
    $dataFile = getDataSQLv1(1, 'SELECT  * FROM it_uploadfile WHERE file_ref=?', array($request['request_token']));
    // $dataTimeline = getDataSQLv1(1, 'SELECT  * FROM it_timeline WHERE file_ref=?', array($request['request_token']));
    $dataTimeline = getDataSQLv1(1,'SELECT * FROM it_timeline 
    LEFT JOIN it_request ON it_request.request_id = it_timeline.timeline_refid 
    LEFT JOIN user_emp_view ON user_emp_view.emp_id = it_timeline.timeline_userid
    LEFT JOIN it_allStatus ON (it_allStatus.status_key = it_timeline.timeline_refstatusid and it_allStatus.status_for = 1)
    WHERE timeline_refid = ? order by timeline_timestamp asc', array($id));

    $TXTFile = '';
    $domain = 'https://it.btm.co.th/';
    
    foreach($dataFile AS $file){
      $TXTFile.='<div><a  href="'.$domain.'include/uploads/'.$file['file_path'].$file['file_name'].'">'.$file['file_name'].' &#128209; </a></div>';
    }

    $nameResponder = '';
    foreach($dataResponder AS $Responder){
      $nameResponder = $Responder['emp_fname'].' '.$Responder['emp_lname'];
    }


    $txt1 ='';
    if($request['request_urgent']==1){
      $txt1 = 'ต้องการภายใน | '.$request['Duedate'].' เวลา '.$request['Duetime'].'น.';
    }
    $txtTimeline = '';
    foreach($dataTimeline AS $timeline){
      $txtTimeline.='<tr>
        <td style="vertical-align: baseline;">'.date('Y-m-d H:i',strtotime($timeline['timeline_timestamp'])).'</td>
        <td><b>'.$timeline['status_title'].'</b><br>
            <small style="color:grey;fornt-weight:600;">'.$timeline['timeline_title'].' - '.$timeline['timeline_description'].'</small><br>
            <small>By '.$timeline['emp_fname'].'</small>
        </td>

      </tr>';
    }

   

  
  return '<!DOCTYPE html>
  <html xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office" lang="en">
  
  <head>
      <title></title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]--><!--[if !mso]><!-->
  
      <style>
          * {
              box-sizing: border-box;
          }
  
          body {
              margin: 0;
              padding: 0;
          }
  
          a[x-apple-data-detectors] {
              color: inherit !important;
              text-decoration: inherit !important;
          }
  
          #MessageViewBody a {
              color: inherit;
              text-decoration: none;
          }
  
          p {
              line-height: inherit
          }
  
          .desktop_hide,
          .desktop_hide table {
  
              display: none;
              max-height: 0px;
              overflow: hidden;
          }
  
          .image_block img+div {
              display: none;
          }
  
          @media (max-width:770px) {
              .desktop_hide table.icons-inner {
                  display: inline-block !important;
              }
  
              .icons-inner {
                  text-align: center;
              }
  
              .icons-inner td {
                  margin: 0 auto;
              }
  
              .row-content {
                  width: 100% !important;
              }
  
              .mobile_hide {
                  display: none;
              }
  
              .stack .column {
                  width: 100%;
                  display: block;
              }
  
              .mobile_hide {
                  min-height: 0;
                  max-height: 0;
                  max-width: 0;
                  overflow: hidden;
                  font-size: 0px;
              }
  
              .desktop_hide,
              .desktop_hide table {
                  display: table !important;
                  max-height: none !important;
              }
  
              .reverse {
                  display: table;
                  width: 100%;
              }
  
              .reverse .column.first {
                  display: table-footer-group !important;
              }
  
              .reverse .column.last {
                  display: table-header-group !important;
              }
  
              .row-1 td.column.first .border {
                  padding: 35px 0 35px 25px;
                  border-top: 0;
                  border-right: 0px;
                  border-bottom: 0;
                  border-left: 0;
              }
  
              .row-1 td.column.last .border {
                  padding: 5px 0;
                  border-top: 0;
                  border-right: 0px;
                  border-bottom: 0;
                  border-left: 0;
              }
          }
      </style>
  </head>
  
  <body style="background-color: #f2f2f2; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
      <table class="nl-container" width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation"
          style=" background-color: #f2f2f2;">
          <tbody>
              <tr>
                  <td>
                      <table class="row row-1" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                          role="presentation">
                          <tbody>
                              <tr>
                                  <td>
                                      <table class="row-content stack" align="center" border="0" cellpadding="0"
                                          cellspacing="0" role="presentation"
                                          style=" background-color: #ffffff; color: #000000; width: 750px;" width="750">
                                          <tbody>
                                              <tr class="reverse">
                                                  <td class="column column-1 first" width="83.33333333333333%"
                                                      style=" font-weight: 400; text-align: left; padding-bottom: 35px; padding-left: 25px; padding-top: 35px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                      <div class="border">
                                                          <table class="heading_block block-1" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-left:5px;padding-top:10px;text-align:center;width:100%;">
                                                                      <h1
                                                                          style="margin: 0; color: #fe7062; direction: ltr;  font-size: 13px; font-weight: 700; letter-spacing: 1px; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;">
                                                                          <span
                                                                              class="tinyMce-placeholder">Notification</span>
                                                                      </h1>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                          <table class="heading_block block-2" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-left:5px;padding-right:5px;padding-top:5px;text-align:center;width:100%;">
                                                                      <h1
                                                                          style="margin: 0; color: #2f2e41; direction: ltr; font-size: 26px; font-weight: 400; letter-spacing: 1px; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;">
                                                                          <strong>Your ticket has been update please check! </strong>&nbsp; <strong>#'.$request['request_workNo'].'🎫</strong>
                                                                      </h1>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                          <table class="paragraph_block block-3" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation"
                                                              style=" word-break: break-word;">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-bottom:10px;padding-left:5px;padding-right:5px;">
                                                                      <div
                                                                          style="color:#393d47;direction:ltr; font-size:16px;font-weight:400;letter-spacing:0px;line-height:150%;text-align:left;">
                                                                          <p style="margin: 0;">please wait a moment.
                                                                          We will repair it as soon as possible.  </p>
                                                                      </div>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                      </div>
                                                  </td>
                                                  <td class="column column-2 last" width="16.666666666666668%"
                                                      style=" font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                      <div class="border">
                                                          <table class="image_block block-1" width="100%" border="0"
                                                              cellpadding="0" cellspacing="0" role="presentation">
                                                              <tr>
                                                                  <td class="pad"
                                                                      style="padding-top:45px;width:100%;padding-right:0px;padding-left:0px;">
                                                                      <div class="alignment" align="center"
                                                                          style="line-height:10px"><img
                                                                              src="https://survey.btm.co.th/include/img/logo_bt_midland.png"
                                                                              style="display: block; height: auto; border: 0; width: 88px; max-width: 100%;"
                                                                              width="88"></div>
                                                                  </td>
                                                              </tr>
                                                          </table>
                                                      </div>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                      <table class="row row-2" align="center" width="100%" border="0" cellpadding="0" cellspacing="0"
                          role="presentation">
                          <tbody>
                              <tr>
                                  <td>
                                      <table class="row-content stack" align="center" border="0" cellpadding="0"
                                          cellspacing="0" role="presentation"
                                          style=" background-color: #ffffff; color: #000000; border-radius: 0; width: 750px;"
                                          width="750">
                                          <tbody>
                                              <tr>
                                                  <td class="column column-1" width="100%"
                                                      style=" font-weight: 400; text-align: left; padding-bottom: 5px; padding-top: 5px; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;">
                                                      <table class="text_block block-1" width="100%" border="0"
                                                          cellpadding="0" cellspacing="0" role="presentation"
                                                          style=" word-break: break-word;">
                                                          <tr>
                                                              <td class="pad" style="padding-right:30px;">
                                                                  <div>
                                                                      <div class
                                                                          style="font-size: 12px;   color: #000000; line-height: 1.2;">
                                                                          <p
                                                                              style="margin: 0; font-size: 12px; text-align: right;">
                                                                              <span style="font-size:18px;"><strong>ประเภท
                                                                                  </strong>| '.$request['type_name'].'</span>
                                                                          </p>
                                                                      </div>
                                                                  </div>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                      <table class="divider_block block-2" width="100%" border="0"
                                                          cellpadding="10" cellspacing="0" role="presentation">
                                                          <tr>
                                                              <td class="pad">
                                                                  <div class="alignment" align="center">
                                                                      <table border="0" cellpadding="0" cellspacing="0"
                                                                          role="presentation" width="100%">
                                                                          <tr>
                                                                              <td class="divider_inner"
                                                                                  style="font-size: 1px; line-height: 1px; border-top: 1px solid #BBBBBB;">
                                                                                  <span>&#8202;</span>
                                                                              </td>
                                                                          </tr>
                                                                      </table>
                                                                  </div>
                                                              </td>
                                                          </tr>
                                                      </table>
                                                      <table style="font-size: 16px; padding: 20px; text-align: top;">
                                                          <tr>
                                                              <td style="width: 25%;"><strong>ทำรายการโดย</strong></td>
                                                              <td style="width: 50%;">'.$request['emp_fname'].'  '.$request['emp_lname'].' </td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>เรื่อง</strong></td>
                                                              <td>'.$request['request_title'].'</td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>รายละเอียด</strong></td>
                                                              <td style="line-height:1">'.$request['request_description'].'</td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>เวลาที่ทำรายการ</strong></td>
                                                              <td>'.date('H:i วันที่ d/m/Y',strtotime($request['request_create_at'])).'</td>
                                                          </tr>
                                                          <tr>
                                                              <td style="
                                                              display: flex;
                                                              align-items: flex-start;"><strong>ผู้รับผิดชอบ</strong></td>
                                                              <td>'.$nameResponder.'</td>
                                                          </tr>
                                                          <tr >
                                                              <td style="color: #ff0101;  display: flex;
                                                              align-items: flex-start;"><strong>Remark</strong></td>
                                                              <td>'.$txt1.'</td>
                                                          </tr>
                                                          <tr>
                                                              <td style=" display: flex; align-items: flex-start;"><strong>ไฟล์แนบ</strong></td>
                                                              <td>'.$TXTFile.'</td>
                                                          </tr>
                                                      </table>

                                                      <table style="font-size: 16px; padding: 20px; text-align: top;">
                                                         <tr>
                                                         <td><strong>สถานะงาน</strong></td>
                                                         </tr>
                                                        
                                                      </table>

                                                      <table style="font-size: 16px; padding: 20px; text-align: top;">
                                                          '.$txtTimeline.'
                                                        
                                                      </table>
                                                  </td>
                                              </tr>
                                          </tbody>
                                      </table>
                                  </td>
                              </tr>
                          </tbody>
                      </table>
                      
  
                  </td>
              </tr>
          </tbody>
      </table><!-- End -->
  </body>
  
  </html>';
  }
}

?>