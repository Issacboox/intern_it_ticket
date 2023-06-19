<?php

date_default_timezone_set("Asia/Bangkok");
require_once('../../include/php/connect.php');
require_once('email.php');
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
    // $mail->SMTPDebug = 2;  
    $mail->IsSMTP(); 
    $mail->Host = "ssl://smtp.gmail.com";
    $mail->SMTPAuth = true; 
    $mail->SMTPKeepAlive = true;
    // $mail->Username = "notify.btmidland@gmail.com";
    // $mail->Password = "Bt@gmail2022";
    // $mail->Username = "info@bt-midland.com";
    // $mail->Password = "bTmidland@inFo1485##";
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


function callAPISendMail($dataSendToAPI){
  $curl = curl_init('https://report.bt-midland.com/api/private_test/it');
  curl_setopt($curl, CURLOPT_URL, 'https://report.bt-midland.com/api/private_test/it');
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  $headers = array(
    "Content-Type: application/json",
    'Authorization: Bearer z123456FDknhbcstuolnHTmnsdLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG00098TIWxXcCdC'
  );
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  $data = array( "type"=>"sendEmail",
    "data"=>$dataSendToAPI,
    "key" =>"z123456FDknhbcstuolnHTmnsdLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG00098TIWxXcCdC"
  );
  curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
  $resp = curl_exec($curl);
  curl_close($curl);
  $response = json_decode($resp);
  return $response;
}

// function callAPISendMail($dataG){
//   $curl = curl_init('https://report.bt-midland.com/api/private_test/service');
//   curl_setopt($curl, CURLOPT_URL, 'https://report.bt-midland.com/api/private_test/service');
//   curl_setopt($curl, CURLOPT_POST, true);
//   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//   $headers = array(
//     "Content-Type: application/json",
//     'Authorization: Bearer zv1KtOE81TdO2bY13Cu2eRN0sKMFLClOnsxcFLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG000000DSzO'
//   );
//   curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//   $data = array( "type"=>"sendEmail",
//     "data"=>$dataG,
//     "key" =>"zv1KtOE81TdO2bY13Cu2eRN0sKMFLClOnsxcFLq7GU0eBG8VFOwNWYxD7FvnhIGBNXmw5e5fAlPx4GHFcNRCPBg1wKyjoqIK1Uw0vryNHHG000000DSzO"
//   );
//   curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//   curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
//   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
//   $resp = curl_exec($curl);
//   curl_close($curl);
//   $response = json_decode($resp);
//   return $response;
// }

function genWorkRanningNo($codeId){
  $NowYear = date('y');
  $NowMonth = date('m');
  $return = '-';
  $codeWorktype = getDataSQL(1,'type_request','id',$codeId);

  // $codeWorktype = getDataSQLv1(1,'SELECT  * FROM  type_request  WHERE id=?',array($codeId));
  if($codeWorktype){
    $code = $codeWorktype['typeCode'];
  }else{
    $code = 'OT';
  }
  $search = $code.$NowYear.$NowMonth."%"; 
  $assign_work = getDataSQLv1(1,'SELECT * FROM  form_request  WHERE workNo LIKE ?  ORDER BY workNo DESC LIMIT 1',array($search));
  if(count($assign_work)>0){
    $DocNoLast = $assign_work[0]['workNo'];
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

?>