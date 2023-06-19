<?php
$dateNow = date('Y-m-d  H:i',time());
$browser = $_SERVER['HTTP_USER_AGENT'];

function getdataTypeRequest($type,$dataAPI,$dataoption){
  global $dateNow,$browser,$keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  if($type=='formrequest'){
    $data = getDataSQLv1(1,'SELECT *  FROM it_request_type where type_status=1 and type_id!=12',array());
    // $codeReturn=203;
  }else if($type == 'EmpDash'){
    $datafordash = getDataSQLv1(1, 'SELECT * FROM user_emp_view WHERE emp_orgunit = 22 AND emp_status = 1', array());
    foreach ($datafordash as $form) {
      $Current = getDataSQLv1(1, 'SELECT * FROM it_assign WHERE assign_assignTo = ? AND assign_status = 2' , array($form['emp_id']));
      $Started = getDataSQLv1(1, 'SELECT * FROM it_assign WHERE assign_assignTo = ? AND assign_status = 4' , array($form['emp_id']));
      $Plan = getDataSQLv1(1, 'SELECT * FROM it_assign WHERE assign_plan IS NOT NULL AND assign_assignTo = ? AND assign_status != 5 AND assign_status != 3', array($form['emp_id']));
  
      $form['Current'] = count($Current);
      $form['Started'] = count($Started);
      $form['Plan'] = count($Plan);   
      array_push($data, $form);
  }
  }
  else if($type == 'ResponderSetting'){

  
  }
  return setDataReturn($codeReturn,$data);;
}

 function getdataHistoryRequest($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $userId = $_SESSION['emp_id'];

  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  if ($type == 'foruser') {
    $start = $dataAPI['start'];
    $end = $dataAPI['end'];

    $search = "%".$dataAPI['search']."%";
    $condition = '';
    $permission ='';
    // $condition2 = '';
    // $condition.=' AND it_request.request_status ='.$dataAPI['filterstatus'];

    if($dataAPI['filterstatus']!='All'){
      $condition.=' AND it_request.request_status ='.$dataAPI['filterstatus'];
    }
    if($dataAPI['filterEmp']!='All'){
      // $condition.=' AND ev.emp_id ='.$dataAPI['filterEmp'];
      // $condition2 .= " AND user_emp_view.emp_id='".$dataAPI['filterEmp']."' ";
      $condition .= " AND it_request.request_responder='".$dataAPI['filterEmp']."' ";
    }
    if(getDataUserPermisionByRolesTypeAndSessionToken('ViewHistoryAll')){

    }else{
      $condition.=" AND requestor_id='".$userId."' ";
    }

    $query = 'SELECT * FROM user_emp_view where emp_orgunit=22 and emp_status = 1';
    $dataformemp = getDataSQLv1(1, $query, array());

    $dataresponder = getDataSQLv1(1, $query, array());

    // $query = 'SELECT *, it_request.request_id AS id, it_request.request_create_at AS req_datetime, it_request.request_status 
    // AS req_status, it_request.request_workNo AS Ticket_No FROM it_request
    // LEFT JOIN it_request_type AS tq ON tq.type_id = it_request.request_type
    // LEFT JOIN user_emp_view AS ev ON ev.emp_id = it_request.requestor_id
    // WHERE (it_request.request_status = 2 OR it_request.request_status = 4) AND request_responder != 0 
    // AND (request_create_at BETWEEN ? AND ?) '.$condition.' ORDER BY it_request.request_create_at DESC';
    
    $query = "SELECT it_request.*,
    it_request.request_id AS id,
    it_request.request_create_at AS req_datetime,
    it_request.request_status AS req_status,
    it_request.request_workNo AS Ticket_No, tq.*, ev.*
    FROM it_request
    LEFT JOIN it_request_type AS tq ON tq.type_id = it_request.request_type
    LEFT JOIN user_emp_view AS ev ON ev.emp_id = it_request.requestor_id
    WHERE it_request.request_status NOT IN (1, 3, 5, 6) AND (request_create_at BETWEEN ? AND ?) " . $condition . " 
    ORDER BY it_request.request_create_at DESC";


      $dataform = getDataSQLv1(1, $query, array($start,$end));
      foreach ($dataform as $form) {
          // $datastaff = getDataSQLv1(1, 'SELECT * FROM it_staff_fortype LEFT JOIN user_emp_view ON user_emp_view.emp_id = it_staff_fortype.staff_userId 
          //                               WHERE staff_type_id=? AND staff_status=1 '.$condition2.' 
          //                               order by it_staff_fortype.staff_number ASC', array($form['request_type']));
          // // if(count($datastaff)>0){
          //    $form['staff'] = $datastaff;
          $datafile = getDataSQLv1(1, 'SELECT * FROM it_uploadfile WHERE file_status = 1 AND file_token = ?', array($form['request_token']));
          $form['file'] = $datafile;
          $form['staffit'] = $dataformemp;
          $form['myuserId']=$userId;
          array_push($data, $form);
          // }
         
   }   
  }
  else if($type == 'manageresponder'){
    foreach($dataAPI as $res){
      $type_id = $res['type_id'];
      $emp_ = $res['emp'];
      $staff_number=1;
      updateSQL('it_staff_fortype','staff_status=?','staff_type_id=?',array(0,$type_id));
      foreach($emp_ as $emp){
        $datastaff = getDataSQLv1(1,'SELECT * FROM it_staff_fortype where staff_type_id=? and staff_userId=?', array($type_id,$emp));
        if(count($datastaff)==0){
          insertSQLv2('it_staff_fortype','staff_type_id,staff_userId,staff_number',array($type_id,$emp,$staff_number));
          $staff_number++; 
        }else{
          updateSQL('it_staff_fortype','staff_status=?','staff_type_id=? and staff_userId=?',array(1,$type_id,$emp));
        }
      }
    }
    array_push($data,$dataAPI);
  }else if ($type == 'view') {
    $query = 'SELECT * FROM it_request_type WHERE type_status = 1 and type_id!=12';
    $datatype = getDataSQLv1(1, $query, array($dataAPI));

    $query = 'SELECT *, it_request.request_id AS id, it_request.request_create_at AS req_datetime, 
    it_request.request_status AS req_status, it_request.request_workNo AS Ticket_No FROM it_request
    LEFT JOIN it_request_type AS tq ON tq.type_id = it_request.request_type
    LEFT JOIN user_emp_view AS ev ON ev.emp_id = it_request.request_responder
    WHERE it_request.request_status != 3 and request_id=?  ORDER BY it_request.request_create_at DESC';
  
    $dataform = getDataSQLv1(1, $query, array($dataAPI));
    foreach ($dataform as $form) {
      $datareq = getDataSQLv1(1, 'SELECT * FROM it_request LEFT JOIN it_request_type AS tq ON tq.type_id=it_request.request_type
       WHERE it_request.request_id=? AND it_request.request_type=?', array($form['request_id'], $form['request_type']));

      $form['datareq'] = $datareq;
      $form['allticket'] = $datatype;
      array_push($data, $form);
    
    }
    }else if($type == 'edit'){
      if($dataAPI['id']!=0){
        $typeID = $dataAPI['TypeSelectEdit'];
          $query = 'SELECT * FROM it_request_type WHERE type_status = 1 and type_id=? and type_id!=12';
          $dataedittype = getDataSQLv1(1, $query, array($typeID));
          
          $query = 'SELECT * FROM it_request WHERE request_status !=9 and request_id=? ';
          $datareq = getDataSQLv1(1, $query, array($dataAPI['id']));

          foreach($datareq AS $request){
            updateSQL('it_request','request_status=?','request_id=?',array(6, $request['request_id']));
            createTimelineStatusTicket($dataAPI['id'],6,'Change Type Ticket To '.$typeID,'');

            $newToken = $request['request_token']."_".new_token(5);
            $workNo = genWorkRanningNo($typeID);
            $responder =0; 
            $datastaff = getDataSQLv1(1, 'SELECT staff_userId FROM it_staff_fortype WHERE staff_type_id=? AND staff_number=1', array($typeID));
            foreach($datastaff as $staff){
              $responder=$staff['staff_userId'];
            }

            $f= insertSQLv2('it_request','request_type,request_title,request_description,request_token,request_workNo,request_create_at
                             ,request_urgent,request_duedate,request_responder,requestor_id,requestor_adminid,request_status',
              array($typeID,$request['request_title'],$request['request_description'],$newToken,$workNo,$request['request_create_at'],
              $request['request_urgent'],$request['request_duedate'],$responder,$request['requestor_id'],$userId,2
            ));

            $dataWorkRequest = getDataSQLv1(1, 'SELECT * FROM it_request WHERE request_token=?', array($newToken));
            foreach($dataWorkRequest AS $work){
              $f = insertSQLv2('it_assign', '[assign_request]
              ,[assign_type]
              ,[assign_assigner]
              ,[assign_assignTo]
              ,[assign_date]
             ',
                array($work['request_id'],1,$responder,$responder,$dateNow));

                createTimelineStatusTicket($work['request_id'],4,'Change Type Ticket','New running number is ' . $workNo );
              
            }

            array_push($data,1);

          }

    
        }else{
        
        }
  }else if ($type == 'reponderEdit') {
    
    if ($dataAPI['id'] != 0) {
      $query = 'SELECT * FROM it_request WHERE request_status !=9 and request_id=? ';
      $datareq = getDataSQLv1(1, $query, array($dataAPI['id']));
      foreach($datareq AS $request){
        if($dataAPI['emp_respond']!=$request['request_responder']){
          updateSQL(
            'it_assign',
            'assign_assigner=?,assign_assignTo=?,assign_status=?',
            'assign_request=?',
            array($dataAPI['emp_respond'],$dataAPI['emp_respond'], 2, $dataAPI['id'])
          );
            updateSQL('it_request','request_responder=?','request_id=?',
            array($dataAPI['emp_respond'], $request['request_id'])
            );
          createTimelineStatusTicket($request['request_id'], 3, 'Change responder', 'Change To ' . $_SESSION['emp_fname'] . ' ' . $_SESSION['emp_lname']);

        }
      }
        array_push($data, 1);
    } else {

    }
}

  else if ($type == 'assessment') {
    // $query = 'SELECT * FROM it_request_type WHERE type_status = 1 ';
    // $datatype = getDataSQLv1(1, $query, array($dataAPI));

    $query = 'SELECT *, it_request.request_id AS id, it_request.request_create_at AS req_datetime, 
    it_request.request_status AS req_status, it_request.request_workNo AS Ticket_No FROM it_request
    LEFT JOIN it_request_type AS tq ON tq.type_id = it_request.request_type
    LEFT JOIN user_emp_view AS ev ON ev.emp_id = it_request.request_responder
    WHERE it_request.request_status = 3 and request_id=?  ORDER BY it_request.request_create_at DESC';
  
    $dataform = getDataSQLv1(1, $query, array($dataAPI));
    foreach ($dataform as $form) {

      array_push($data, $form);
    
    }
  }else if ($type == 'comAss') {
    if ($dataAPI['id'] != 0) {
        updateSQL(
            'it_request',
            'request_rate_service=?, request_rate=?, request_comment=?',
            'request_id=?',
            array($dataAPI['Servicerating'], $dataAPI['rating'], $dataAPI['feedbackAss'], $dataAPI['id'])
        );
        createTimelineStatusTicket($dataAPI['id'], 8, 'Assessment Complete', 'Thank You ' . $_SESSION['emp_fname'] . ' ' . $_SESSION['emp_lname']);
        array_push($data, 1);

}
  }

   return setDataReturn($codeReturn, $data);
}

function getallEmpforTicket($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  if ($type == 'empSelect') {
           $query = 'SELECT *FROM user_emp_view WHERE emp_status =1' ;
   $dataform = getDataSQLv1(1, $query, array());
    foreach ($dataform as $form) {
             array_push($data, $form);
            
        }
      
  }

  return setDataReturn($codeReturn, $data);
}

function getCurrentJobRequest($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();

  if ($type == 'forstaff') {
    $start = $dataAPI['start'];
    $end = $dataAPI['end'];

    $search = "%".$dataAPI['search']."%";
    $condition1 = '';

    // $condition2 = '';
    // $condition.=' AND it_request.request_status ='.$dataAPI['filterstatus'];

    if($dataAPI['filterstatus']!= 'All' && $dataAPI['filterstatus'] != 'Complete' ){
      $condition1.=' AND it_request.request_status ='.$dataAPI['filterstatus'];
    }else{
      $condition1.=' AND it_request.request_status != 3';
    }
    if($dataAPI['filterstatus'] == 'Complete' ){
      $condition1 =' AND it_request.request_status = 3';
    }

    $query = 'SELECT * FROM user_emp_view WHERE emp_orgunit=22 AND emp_status = 1';
    $dataformIn = getDataSQLv1(1, $query, array());

    $query = "SELECT it_request.*, it_request.request_id AS id, it_request.request_create_at AS req_datetime,
    it_request.request_status AS req_status, it_request.request_workNo AS Ticket_No, tq.*, ev.*,it_assign.*
    FROM it_request
    LEFT JOIN it_request_type AS tq ON tq.type_id = it_request.request_type
    LEFT JOIN user_emp_view AS ev ON ev.emp_id = it_request.requestor_id
    LEFT JOIN it_assign ON it_assign.assign_request = it_request.request_id
    WHERE it_request.request_status NOT IN (1,5,6) 
    AND request_responder = " . $_SESSION['emp_id'] . " AND (request_create_at BETWEEN ? AND ?) " . $condition1 . "  
     ORDER BY it_request.request_create_at DESC";

    $dataform = getDataSQLv1(1, $query, array($start,$end));
    foreach ($dataform as $form) {
      $datastaffInprpo = getDataSQLv1(1, 'SELECT * FROM it_staff_fortype LEFT JOIN user_emp_view ON user_emp_view.emp_id = it_staff_fortype.staff_userId 
      WHERE staff_type_id=? AND staff_status=1', array($form['request_type']));
      $form['staffInpro'] = $datastaffInprpo;

      $datafile = getDataSQLv1(1, 'SELECT * FROM it_uploadfile WHERE file_status = 1 AND file_token = ?', array($form['request_token']));
      $form['file'] = $datafile;
      $form['staffIn'] = $dataformIn;
      array_push($data, $form);
    }
  } else if ($type == 'planProcess') {
    if ($dataAPI['id'] != 0) {
      updateSQL(
        'it_assign',
        'assign_plan=?,assign_remark=?,assign_plan_at=?',
        'assign_request=?',
        array($dataAPI['planTimeStart'], $dataAPI['planRemark'], $dateNow, $dataAPI['id'])
      );
      createTimelineStatusTicket($dataAPI['id'], 10, 'Plan Complete', $dataAPI['planRemark'].' [Plan '.$dataAPI['planTimeStart'].']');
      sendEmailNotifyOnUpdateStatus($dataAPI['id']);
      array_push($data, 1);
    } else {
      // Handle the case when $dataAPI['id'] is 0
    }
  } else if ($type == 'comment') {
    if ($dataAPI['id'] != 0) {
      createTimelineStatusTicket($dataAPI['id'], 9, 'Comment ', $dataAPI['descInput']);
      sendEmailNotifyOnUpdateStatus($dataAPI['id']);
      array_push($data, 1);
    } else {
      // Handle the case when $dataAPI['id'] is 0
    }
  } else if ($type == 'start') {
    if ($dataAPI['id'] != 0) {
      updateSQL(
        'it_assign',
        'assign_start=?,assign_remark2=?,assign_status=?',
        'assign_request=?',
        array($dateNow, $dataAPI['startPc'], 4, $dataAPI['id'])
      );
      updateSQL(
        'it_request',
        'request_status=?',
        'request_id=?',
        array(4, $dataAPI['id'])
      );
      createTimelineStatusTicket($dataAPI['id'], 6, 'Start Working', $dataAPI['startPc']);
      sendEmailNotifyOnUpdateStatus($dataAPI['id']);
      array_push($data, 1);
    } else {
      // Handle the case when $dataAPI['id'] is 0
    }
  } else if ($type == 'finish') {
    if ($dataAPI['id'] != 0) {
      updateSQL(
        'it_assign',
        'assign_finished=?,assign_remark3=?,assign_closeJob=?,assign_status=?',
        'assign_request=?',
        array($dateNow, $dataAPI['remarkSolveTicket'], $dateNow, 3, $dataAPI['id'])
      );
      updateSQL(
        'it_request',
        'request_status=?',
        'request_id=?',
        array(3, $dataAPI['id'])
      );
      createTimelineStatusTicket($dataAPI['id'], 7, 'Ticket Complete', $dataAPI['remarkSolveTicket']);
      sendEmailNotifyOnUpdateStatus($dataAPI['id']);
      array_push($data, 1);
    } else {
      // Handle the case when $dataAPI['id'] is 0
    }
  } else if ($type == 'reject') {
    if ($dataAPI['id'] != 0) {
      updateSQL(
        'it_assign',
        'assign_closeJob=?,assign_comment=?,assign_status=?',
        'assign_request=?',
        array($dateNow, $dataAPI['rejectdesc'], 5, $dataAPI['id'])
      );
      updateSQL(
        'it_request',
        'request_status=?',
        'request_id=?',
        array(5, $dataAPI['id'])
      );
      sendEmailNotifyOnUpdateStatus($dataAPI['id']);
      createTimelineStatusTicket($dataAPI['id'], 11, 'Ticket Reject', 'Reason  : '.$dataAPI['rejectdesc']);
      array_push($data, 1);
    } else {
      // Handle the case when $dataAPI['id'] is 0
    }
  } else if ($type == 'job') {
    if ($dataAPI['id'] != 0) {
      updateSQL(
        'it_assign',
        'assign_assigner=?,assign_assignTo=?,assign_status=?',
        'assign_request=?',
        array($_SESSION['emp_id'],$_SESSION['emp_id'], 2, $dataAPI['id'])
      );
      updateSQL(
        'it_request',
        'request_responder=?',
        'request_id=?',
        array($_SESSION['emp_id'], $dataAPI['id'])
      );
      sendEmailNotifyOnUpdateStatus($dataAPI['id']);
      createTimelineStatusTicket(
        $dataAPI['id'],
        3,
        'Change responder',
        'Change to ' . $_SESSION['emp_fname'] . ' ' . $_SESSION['emp_lname']
      );
      array_push($data, 1);
    } else {
      // Handle the case when $dataAPI['id'] is 0
    }
  }

  return setDataReturn($codeReturn, $data);
}



function getTicketComplete($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  $myId = $_SESSION['emp_id'];
  if ($type == 'forcheck') {
    $startDate = $dataAPI['datestart'];
    $endDate = $dataAPI['dateend'];
  
    $search = "%" . $dataAPI['search'] . "%";
    $Historycondition = '';
    $Historycondition2 = '';
  
    if ($dataAPI['filterbystatus'] != 'All') {
      $Historycondition .= ' AND it_request.request_status =' . $dataAPI['filterbystatus'];
    }
    if ($dataAPI['filterbyEmp'] != 'All') {
      $Historycondition2 .= " AND it_request.request_responder ='" . $dataAPI['filterbyEmp'] . "' ";
    }

    $query = 'SELECT * FROM user_emp_view WHERE emp_orgunit=22 AND emp_status = 1';
    $dataformIn = getDataSQLv1(1, $query, array());
    // $emp
    // foreach($dataformIn AS $emp=>{
    //   if($myId==$emp['emp_id']){

    //   }
    // })
    if(getDataUserPermisionByRolesTypeAndSessionToken('ViewHistoryAll')){

    }else{
      $Historycondition2.=" AND requestor_id='".$myId."' ";
    }
    
    $query = "SELECT *, it_request.request_id AS id, it_request.request_create_at AS req_datetime,
    it_request.request_status AS req_status, it_request.request_workNo AS Ticket_No
    FROM it_request 
    LEFT JOIN it_request_type AS tq ON tq.type_id = it_request.request_type 
    LEFT JOIN user_emp_view AS ev ON ev.emp_id = it_request.requestor_id 
    WHERE (it_request.request_status = 3 OR it_request.request_status = 5) 
    -- AND request_responder = " . $_SESSION['emp_id'] . "
    AND (request_create_at BETWEEN ? AND ?)" . $Historycondition . $Historycondition2 . " ORDER BY it_request.request_create_at DESC";


    $dataform = getDataSQLv1(1, $query, array($startDate,$endDate));
    foreach ($dataform as $form) {
    $datafile = getDataSQLv1(1, 'SELECT * FROM it_uploadfile WHERE file_status = 1 AND file_token = ?', array($form['request_token']));
    $form['file'] = $datafile;
    $form['staffitCom'] = $dataformIn;
    array_push($data, $form);
        }
      
  }

  return setDataReturn($codeReturn, $data);
}

function  getdatatypeRequestSetting($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  if ($type == 'forsetting') {
  $data = getDataSQLv1(1,'SELECT * FROM it_request_type where type_status!=9 and type_id!=12', array());
  }else if($type == 'manage'){
    if($dataAPI['id']!=0){
          updateSQL('it_request_type','type_name=?,type_icon=?,type_description=?,type_code=?,type_kpi_minuts=?,type_color=?','type_id=?',
          array($dataAPI['rq_type'],$dataAPI['rq_icon'],$dataAPI['rqt_desc'],$dataAPI['rq_short'],$dataAPI['rq_kpi_minites'],$dataAPI['rq_color'],$dataAPI['id']));
          array_push($data,1);
        }else{
          $f= insertSQLv2('it_request_type','type_name,type_icon,type_description,type_code,type_kpi_minuts,type_color',
          array($dataAPI['rq_type'],$dataAPI['rq_icon'],$dataAPI['rqt_desc'],$dataAPI['rq_short'],$dataAPI['rq_kpi_minites'],$dataAPI['rq_color']));
          array_push($data,1);
    }
  }else if($type=='view'){
  $data = getDataSQLv1(1,'SELECT top 1 * FROM it_request_type where type_status!=9 and type_id=? and type_id!=12', array($dataAPI));

  }
  return setDataReturn($codeReturn, $data); 
}

function SetStatus($tableDB,$columnstatus,$newstatus,$columnwhere,$id){
  global $db;
  $olll = array($tableDB,$columnstatus,$newstatus,$columnwhere,$id);
  $getdata = getDataSQL(1,$tableDB,$columnwhere,$id); 
  // $dataUserToken = $_SESSION["emp_token"];
  // $dataUser = getDataSQL(1,'users_emp','emp_token',$dataUserToken);
  //   if($getdata){
      $columnstatus = $columnstatus."=?";
      $columnwhere = $columnwhere."=?";
      $update_status = updateSQL($tableDB,$columnstatus,$columnwhere,array($newstatus,$id));
      if($update_status){
        $datareturn=array('status'=>1,'msg'=>'ดำเนินการสำเร็จ','data'=>$olll);  
      }else{
        $datareturn=array('status'=>0,'msg'=>'Error','data'=>$olll);  
      }
    // }else{
    //   $datareturn=array('status'=>0,'msg'=>'you don\'t currently have permission to access this data','data'=>array());
    // }
  return $datareturn;
}



function getsugestcardSetting($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  if ($type == 'forguide') {
    
    $data = getDataSQLv1(1,'SELECT *FROM it_request_guide LEFT JOIN it_request_type AS tq ON tq.type_id = it_request_guide.guide_fortype 
    WHERE it_request_guide.guide_status !=9', array());
  }
  else if($type == 'guidemanage'){
    if($dataAPI['id']!=0){
          updateSQL('it_request_guide','guide_fortype=?,guide_title=?,guide_description=?,guide_solutions=?','guide_id=?',
          array($dataAPI['typeSelect'],$dataAPI['RqTitleCard'],$dataAPI['RqDescCard'],$dataAPI['Solution'],$dataAPI['id']));
          array_push($data,1);
        }else{
          $f= insertSQLv2('it_request_guide','guide_fortype,guide_title,guide_description,guide_solutions',
          array($dataAPI['typeSelect'],$dataAPI['RqTitleCard'],$dataAPI['RqDescCard'],$dataAPI['Solution']));
          array_push($data,1);
    }
} else if($type == 'view'){

  $guide = getDataSQLv1(1,'SELECT *FROM it_request_guide LEFT JOIN it_request_type AS tq ON tq.type_id = it_request_guide.guide_fortype 
    WHERE it_request_guide.guide_status != 9 and guide_id=?', array($dataAPI));
  $requesy_type = getDataSQLv1(1,'SELECT * FROM it_request_type where type_status!=9 and type_id!=12', array());
  $data = array('data'=>$guide,'rqtype'=>$requesy_type);
} 
  return setDataReturn($codeReturn, $data);
}


function getresponderSetting($type, $dataAPI, $dataoption) {
  $datareturn = array('request_type' => [], 'it_emp' => []);
  $codeReturn = 0;

  if ($type == 'responder') {
    $query = 'SELECT * FROM it_request_type WHERE type_status != 9 and type_id!=12';
    $dataform = getDataSQLv1(1, $query, array());

    $query = 'SELECT * FROM user_emp_view WHERE emp_orgunit = 22 AND emp_status = 1';
    $dataformemp = getDataSQLv1(1, $query, array());

    foreach ($dataform as $form) {
      $query1 = 'SELECT * FROM it_staff_fortype 
        LEFT JOIN user_emp_view ON emp_id = staff_userId
        WHERE staff_type_id = ? AND staff_status = 1';
      $dataemp = getDataSQLv1(1, $query1, array($form['type_id']));

      $form['emp'] = $dataemp;
      array_push($datareturn['request_type'], $form);
    }

    foreach ($dataformemp as $form) {
      array_push($datareturn['it_emp'], $form);
    }
  }

  return setDataReturn($codeReturn, $datareturn);
}


function getresponderManagement($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array('request_type' => [], 'it_emp' => [] ,'dashEmp' =>[] );
  $codeReturn = 0;

  if ($type == 'responder') {
    // Existing logic for 'responder' case
    $query = 'SELECT * FROM it_request_type WHERE type_status != 9 and type_id!=12';
    $dataform = getDataSQLv1(1, $query, array());

    $query = 'SELECT * FROM user_emp_view WHERE emp_orgunit = 22 AND emp_status = 1';
    $dataformemp = getDataSQLv1(1, $query, array());

    foreach ($dataform as $form) {
      $query1 = 'SELECT * FROM it_staff_fortype 
      LEFT JOIN user_emp_view ON emp_id = staff_userId
      WHERE staff_type_id = ? AND staff_status = 1';
      $dataemp = getDataSQLv1(1, $query1, array($form['type_id']));

      $form['emp'] = $dataemp;
      array_push($datareturn['request_type'], $form);
    }

    foreach ($dataformemp as $form) {
      $start = $dataAPI['start'];
      $end = $dataAPI['end'];
      $condition = " AND (assign_date between '".$start."' AND '".$end."')";
      
      $Current = getDataSQLv1(1, 'SELECT * FROM it_assign WHERE assign_assignTo = ? AND assign_status = 2' . $condition, array($form['emp_id']));
      $Started = getDataSQLv1(1, 'SELECT * FROM it_assign WHERE assign_assignTo = ? AND assign_status = 4' . $condition, array($form['emp_id']));
      $Plan = getDataSQLv1(1, 'SELECT * FROM it_assign WHERE assign_plan IS NOT NULL AND assign_assignTo = ? AND assign_status != 5 AND assign_status != 3' . $condition, array($form['emp_id']));
  
      $form['Current'] = count($Current);
      $form['Started'] = count($Started);
      $form['Plan'] = count($Plan);    
    
      array_push($datareturn['it_emp'], $form);
    }

  } else if ($type == 'dashboard') {
    // $dataDash = getDataSQLv1(1, 'SELECT * FROM it_request WHERE request_status != 9', array());
    // $datareturn = array('EmpDash' => []);
    // foreach ($dataDash as $dash) {
      $datareturn= array();
      $start = $dataAPI['start'];
      $end = $dataAPI['end'];
      $condition = " AND (request_create_at between '".$start."' AND '".$end."')";

      $Assigned = getDataSQLv1(1, 'SELECT * FROM it_request WHERE request_status = 2'.$condition, array());
      $Inprocess = getDataSQLv1(1, 'SELECT * FROM it_request WHERE request_status = 4'.$condition, array());
      $Complete = getDataSQLv1(1, 'SELECT * FROM it_request WHERE request_status = 3'.$condition, array());
      $Reject = getDataSQLv1(1, 'SELECT * FROM it_request WHERE request_status = 5'.$condition, array());
      $dash = array();

      $dash['Assigned'] = count($Assigned);
      $dash['Inprocess'] = count($Inprocess);
      $dash['Complete'] = count($Complete);
      $dash['Reject'] = count($Reject);

      array_push($datareturn, $dash);
    // }
  } else if ($type == 'donutChart') {
    
    $start = $dataAPI['start'];
    $end = $dataAPI['end'];
    $condition = " AND (request_create_at between '".$start."' AND '".$end."')";
    $dataform = getDataSQLv1(1, 'SELECT top 5 type_name, COUNT(*) AS request_count FROM it_request 
                                 LEFT JOIN it_request_type ON it_request_type.type_id = it_request.request_type 
                                 WHERE request_status !=5 '.$condition.'
                                 GROUP BY type_name order by COUNT(*) desc', array());
                                 $datareturn = $dataform;
  }

  return setDataReturn($codeReturn, $datareturn);
}


function countTicketByEmpIdAndStatus($empId,$status){

}

function getSugestCardguide($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();
  if ($type == 'cardguide') {
    // $problem = "%".$dataAPI['problem']."%";
           $query = 'SELECT *FROM it_request_guide LEFT JOIN it_request_type AS tq ON tq.type_id = it_request_guide.guide_fortype 
           WHERE it_request_guide.guide_status =1 ' ;
$dataform = getDataSQLv1(1, $query, array());
foreach ($dataform as $form) {
array_push($data, $form);
        }
      
  }else if ($type == 'AllEmp'){
    $dataform = getDataSQLv1(1, 'SELECT * FROM user_emp_view WHERE emp_status = 1 order by emp_id ASC', array($dataAPI));
    foreach ($dataform as $form) {
        array_push($data, $form);
    }
}
else if ($type == 'check') {
  $query = 'SELECT * FROM user_emp_view WHERE emp_status = 1';
  $dataEmpper = getDataSQLv1(1, $query, array());

  $dataform = getDataSQLv1(1, 'SELECT * FROM user_emp_view WHERE emp_status = 1 and emp_id=?', array($dataAPI));
  foreach ($dataform as $form) {
    $dataRolesType = getDataSQLv1(1,'SELECT * FROM it_roles_type where roles_typeStatus=1',array());
    $ArrR = array();
    
    foreach($dataRolesType AS $roles){
      $roles['checked'] = array();
      $roles['checked'] = checkpermissionByAdmin($roles['roles_typeKey'],$dataAPI);
      array_push($ArrR,$roles);
    }


    // $form['allEmp'] = getDataSQLv1(1, 'SELECT * FROM user_emp_view WHERE emp_status = 1 and emp_id=?', array($dataAPI));
      $form['RolesType'] = $ArrR;
      $form['allEmp'] = $dataEmpper;
      array_push($data, $form);
  }
}else if($type=='updatePermission'){
  $empId = $dataAPI['empId'];
  $roles = $dataAPI['roles'];

  updateSQL('it_emp_roles','roles_status=?','roles_emp_id=?',array(0,$empId));
  foreach($roles as $role){
    $old = getDataSQLv1(1,'SELECT * FROM  it_emp_roles with(nolock) where roles_typeId=? AND roles_emp_id=?',array($role,$empId));
    if(count($old)>0){
      updateSQL('it_emp_roles','roles_status=?','roles_emp_id=? AND roles_typeId=?',array(1,$empId,$role));
    }else{
      insertSQLv2('it_emp_roles','roles_emp_id,roles_typeId,roles_status',array($empId,$role,1));
    }
  }


  array_push($data, $dataAPI);
  
  // array_push($data, $dataAPI);

}else if($type=='DuplicatePermission'){
  $data = getDataSQLv1(1,'SELECT * FROM  it_emp_roles with(nolock)
  left join it_roles_type with(nolock) on it_emp_roles.roles_typeId=it_roles_type.roles_typeId
  where  roles_status=1 AND roles_emp_id=?',array($dataAPI['empId']));
}
  return setDataReturn($codeReturn, $data);
}

function checkpermissionByAdmin($key,$empId){
  return getDataSQLv1(1,'SELECT * FROM  it_emp_roles with(nolock)
  left join it_roles_type with(nolock) on it_emp_roles.roles_typeId=it_roles_type.roles_typeId
  where roles_typeKey=? AND roles_status=1 AND roles_emp_id=?',array($key,$empId));
}
function createTimelineStatusTicket($request_id,$status,$title,$detail){
  global $dateNow, $browser, $keyAPI;
  $userId = $_SESSION['emp_id'];
  $username = $_SESSION['emp_fname'];
  $lastname = $_SESSION['emp_lname'];

  $f = insertSQLv2('it_timeline', '[timeline_type]
  ,[timeline_refid]
  ,[timeline_refstatusid]
  ,[timeline_title]
  ,[timeline_description]
  ,[timeline_userid]
  ,[timeline_timestamp]
  ,[timeline_status]',
    array(1,$request_id,$status,$title,$detail,$userId,$dateNow,1));

}

function getcheckTimelineTicket($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();

  if ($type == 'timeline') {
    $query = 'SELECT * FROM it_timeline 
    LEFT JOIN it_request ON it_request.request_id = it_timeline.timeline_refid 
    LEFT JOIN user_emp_view ON user_emp_view.emp_id = it_timeline.timeline_userid
    LEFT JOIN it_allStatus ON (it_allStatus.status_key = it_timeline.timeline_refstatusid and it_allStatus.status_for = 1)
    WHERE timeline_refid = ?';
    $dataform = getDataSQLv1(1, $query, array($dataAPI));
    
    // Assigning the retrieved data directly to $data
    $data = $dataform;
  }
  
  return setDataReturn($codeReturn, $data);
}

function manageSetting_SET($type, $dataAPI, $dataoption) {
  global $dateNow, $browser, $keyAPI;
  $datareturn = array();
  $codeReturn = 0;
  $data = array();

  if($type=='all'){
    $dataUserAdmin = getDataSQLv1(1,'SELECT * FROM  it_emp_roles with(nolock)
    left join it_roles_type with(nolock) on it_emp_roles.roles_typeId=it_roles_type.roles_typeId
    where  roles_status=1 AND roles_emp_id=?',array($_SESSION['emp_id']));
    $data = $dataUserAdmin;
  }

  return setDataReturn($codeReturn, $data);
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

 ?>