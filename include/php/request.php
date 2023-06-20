<?php 
date_default_timezone_set("Asia/Bangkok");
// if(!isset($_SESSION)){ session_start();}
// ob_start();

 include_once('../../api/master/function_main.php');
 $dateNow = date('Y-m-d H:i:s', time());

  
require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if(!isset($_SESSION)){ session_start();}
  ob_start();

$dataReturn = array('status'=>404);
//if(isset($_FILES['files'])){
    $path = '../../include/uploads/formrequest/';
    $path_ = 'formrequest/';
    // $path__ = 'img/uploads/Store/';
    // $all_files = count($_FILES['files']['tmp_name']);

    // $q_time = $_POST['q_time'];
    // $q_timer = $_POST['q_timer'];
    // $q_score = $_POST['q_score'];
  //  $arrChoice = $_POST['choice'];
    $typeID = $_POST['typeID'];
    $problem = $_POST['problem'];
    $problemdesc = $_POST['problem-desc'];
    $rqurgent = $_POST['rqurgent'];
    if(!!$_POST['urgentDate'] && $_POST['urgentDate']!=''){
      $urgentDate =date("Y-m-d H:i:s", strtotime($_POST['urgentDate']));   
    }else{
      $urgentDate =date("Y-m-d H:i:s", time());   
    }
    
    $ticketOt = $_POST['ticketOt'];
    $selectAnotherEmp = $_POST['selectAnotherEmp'];

    $userId = $_SESSION['emp_id'];

    $tokenNew =time(). new_token(20);
    $workNo = genWorkRanningNo($typeID);

        $FileName = '';
          if(isset($_FILES['files'])){
            $all_files = count($_FILES['files']['tmp_name']);
            for ($i = 0; $i < $all_files; $i++) {  
              $file_name = $_FILES['files']['name'][$i];
              $file_tmp = $_FILES['files']['tmp_name'][$i];
              $file_type = $_FILES['files']['type'][$i];
              $file_size = $_FILES['files']['size'][$i];
              $tmp = explode('.', $_FILES['files']['name'][$i]);
              $file_ext = strtolower(end($tmp));
              $file_name = new_file_name($file_ext);
              $file = $path . $file_name;
              $dataReturn = $file;
                if(move_uploaded_file($file_tmp, $file)){
                  // Add To database
                  $FileName = $file_name;
                  // insertSQLv2('file_uploads','file_type,file_name,file_path,file_token,file_upload,byUserId',array('form',$file_name,$path_,$tokenNew,date('Y-m-d H:i:s',time()),$userId));
                  insertSQLv2('it_uploadfile','file_type,file_name,file_path,file_token,file_ref,file_create_as,file_owner',array('form',$file_name,$path_,$tokenNew,$tokenNew,date('Y-m-d H:i:s',time()),$userId));

              }
          }
        }  
        $responder =1; 
        $datastaff = getDataSQLv1(1, 'SELECT staff_userId FROM it_staff_fortype WHERE staff_type_id=? order by staff_number desc', array($typeID));

        foreach($datastaff as $staff){
          $responder=$staff['staff_userId'];
        }
        if ($ticketOt == 0) {
          $f = insertSQLv2('it_request', 'request_type,request_title,request_description,request_token,request_workNo,request_create_at,request_urgent,
          request_duedate,request_responder,requestor_id,requestor_adminid,request_status',
            array( $typeID, $problem, $problemdesc, $tokenNew, $workNo,$dateNow, $rqurgent, $rqurgent==1? $urgentDate:null, $responder, $userId,0,2));
            $selectAnotherEmp = $responder;
          } else {
          $f = insertSQLv2('it_request', 'request_type,requestor_id,request_title,request_description,request_token,request_workNo,request_create_at,request_urgent,request_duedate,request_responder,requestor_adminid,request_status',
            array($typeID, $selectAnotherEmp, $problem, $problemdesc, $tokenNew, $workNo, $dateNow, $rqurgent, $urgentDate, $responder, $userId,2));
        }





        $dataWorkRequest = getDataSQLv1(1, 'SELECT * FROM it_request WHERE request_token=?', array($tokenNew));
        foreach($dataWorkRequest AS $work){
          $f = insertSQLv2('it_assign', '[assign_request]
          ,[assign_type]
          ,[assign_assigner]
          ,[assign_assignTo]
          ,[assign_date]
          ,[assign_status]',
            array($work['request_id'],1,$responder,$selectAnotherEmp,$dateNow,2));

            $f = insertSQLv2('it_timeline', '[timeline_type]
            ,[timeline_refid]
            ,[timeline_refstatusid]
            ,[timeline_title]
            ,[timeline_description]
            ,[timeline_userid]
            ,[timeline_timestamp]
            ,[timeline_status]',
              array(1,$work['request_id'],1,'Create Ticket','',$userId,$dateNow,1));

        }



      sendEmailOnCreateTicket($tokenNew);
     

$dataReturn = array('status'=>200,'data'=>'this data');
// $dataReturn = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $resp);
// $dataReturn = (array) json_decode($result,true);
// echo json_encode($dataReturn);
// echo json_encode($mail);

// echo $dataReturn;

echo json_encode($dataReturn);
// print_r(json_encode($dataReturn));
// $t = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $t);
// $t = (array) json_decode($t,true);
// $t = json_encode($t);
// echo $t;

function new_file_name($tmp){
  $filename = time()."_".new_token(10).".".$tmp;
	return $filename;
}


function sendEmailOnCreateTicket($token){
  global $keyAPI;
  $dataWorkRequest = getDataSQLv1(1, 'SELECT * FROM it_request
  left join it_request_type on request_type=type_id
  WHERE request_token=?', array($token));
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
              $subject = $requestor[0]['emp_fname'] . ' Create Ticket  #'.$request['request_workNo']. ' ['.$request['type_name']. '] - '.$request['request_title'];
              $bodyHtml_to=createHTMLEmailToStaff($token);

              $dataFile = getDataSQLv1(1, 'SELECT  * FROM it_uploadfile WHERE file_ref=?', array($token));
              foreach($dataFile AS $file){
                array_push($arrFile,array('./include/uploads/'.$file['file_path'].$file['file_name'],$file['file_name']));
              }
              array_push($arrTo,array('mail'=>$Email,'name'=>$Name));
              array_push($arrTo,array('mail'=>$emp['emp_email'],'name'=>$emp['emp_fname']));

              // array_push($arrCC,array('mail'=>'it@btm.co.th','name'=>'IT Ticket'));
            //  array_push($arrCC,array('mail'=>'it@btm.co.th','name'=>'IT Ticket'));
              $sand= sendmailAttachment($from,$arrTo,$arrCC,$arrFile,$subject,$bodyHtml_to);
              // return $sand;
            }


    }


  }

}


?>