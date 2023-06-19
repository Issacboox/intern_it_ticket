<?php 
date_default_timezone_set("Asia/Bangkok");
require_once('connect.php');
if(!isset($_SESSION)){ session_start();}
  ob_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {
        $errors = [];
        $path = '../'.$_POST["path"];
		// $extensions = ['jpg', 'jpeg', 'png', 'gif'];
        $all_files = count($_FILES['files']['tmp_name']);
        for ($i = 0; $i < $all_files; $i++) {  
		$file_name = $_FILES['files']['name'][$i];
		$file_tmp = $_FILES['files']['tmp_name'][$i];
		
		//$ext = pathinfo($_FILES['file']['name'][$i], PATHINFO_EXTENSION);
		$file_type = $_FILES['files']['type'][$i];
		$file_size = $_FILES['files']['size'][$i];
		$tmp = explode('.', $_FILES['files']['name'][$i]);
		$file_ext = strtolower(end($tmp));
	 	$file_name = new_file_name($file_ext);
		$file = $path . $file_name;
		$fileNewName = 'new_'.$file_name;

		if($file_type=='application/pdf'){
			move_uploaded_file($file_tmp, $file);
		}else if($file_type=='image/gif' || $file_type=='image/jpeg' || $file_type=='image/png'){
			$sourceProperties = getimagesize($file_tmp);
			$imageType = $sourceProperties[2];
			switch ($imageType) {
				case IMAGETYPE_PNG:
					$imageResourceId = imagecreatefrompng($file_tmp); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					// imagepng($targetLayer,$folderPath. $fileNewName. ".". $ext);
					imagepng($targetLayer,$path.$file_name);
					break;
				case IMAGETYPE_GIF:
					$imageResourceId = imagecreatefromgif($file_tmp); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					// imagegif($targetLayer,$folderPath. $fileNewName. ".". $ext);
					imagegif($targetLayer,$path.$file_name);
					break;
				case IMAGETYPE_JPEG:
					$imageResourceId = imagecreatefromjpeg($file_tmp); 
					$targetLayer = imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);
					// imagejpeg($targetLayer,$folderPath. $fileNewName. ".". $ext);
					imagejpeg($targetLayer,$path.$file_name);
					break;
				default:
					move_uploaded_file($file_tmp, $file);
					echo "Invalid Image type.";
					exit;
					break;
			}
		}else{
			move_uploaded_file($file_tmp, $file);
		}
		

		// if(move_uploaded_file($file_tmp, $file)){ 
			seveUploadToDB($i,$file_name,$_POST["path"],$_POST['type'],$_POST['empId'],$_POST['token'],$file_type);
		// }
	}
	if ($errors) print_r($errors);
    }
	
}
function imageResize($imageResourceId,$width,$height) {
	$targetWidth = $width < 1280 ? $width : 1280 ;
	$targetHeight = ($height/$width)* $targetWidth;
	$targetLayer = imagecreatetruecolor($targetWidth,$targetHeight);
	imagecopyresampled($targetLayer, $imageResourceId, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
	return $targetLayer;
}

/** show details */
function size_as_kb($size = 0) {
	if($size < 1048576) {
		$size_kb = round($size / 1024, 2);
		return "{$size_kb} KB";
	} else {
		$size_mb = round($size / 1048576, 2);
		return "{$size_mb} MB";
	}
}

function imgSize($img) {
	$targetWidth = $img[0] < 1280 ? $img[0] : 1280 ;
	$targetHeight = ($img[1] / $img[0])* $targetWidth;
	return [round($targetWidth, 2), round($targetHeight, 2)];
}


function updateSQL($tablename,$dataupdate,$whereColumn,$condition){
    global $db;
    $update = $db->prepare("UPDATE  $tablename SET $dataupdate WHERE $whereColumn");
    $update->execute($condition);
    return true;
  }

function insertSQL($table,$insertColumn,$value,$condition){
	global $db;
	$save = $db->prepare("INSERT INTO $table ($insertColumn) VALUES ($value)");
	$save->execute($condition);
	return $save;
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


function seveUploadToDB($i,$Filename,$path,$Type,$empid,$token,$file_type){
	global $db;
    // $Filename = 'include/img/emp/'.$Filename;
	$new_token_file_name = new_token(52);
if($Type=='emp_profile'){
	$dataEmp = getDataSQLv1(1,'SELECT * FROM  users_emp  WHERE emp_token=?',array($token));
	if($dataEmp){
		$data = updateSQL('users_emp','emp_img=?','emp_token=?',array($new_token_file_name,$token));
		// $data = insertSQL('uploadfile]','[file_name],[file_for],[file_path],[file_empId],[file_token],[file_dateupload],[file_status],[file_type]','?,?,?,?,?,?,?,?',array($Filename,$Type,$path,$empid,$new_token_file_name,time(),1,$file_type));
		$data = insertSQL('uploadfile','file_name,file_for,file_path,file_empId,file_token,file_dateupload,file_status,file_type','?,?,?,?,?,?,?,?',array($Filename,$Type,$path,$empid,$new_token_file_name,time(),1,$file_type));
	
	}else{
		// $data = insertSQL('[rental].[dbo].[uploadfile]','[file_name],[file_for],[file_path],[file_empId],[file_token],[file_dateupload],[file_status],[file_type]','?,?,?,?,?,?,?,?',array($Filename,$Type,$path,$empid,$token,time(),1,$file_type));
		$data = insertSQL('uploadfile','file_name,file_for,file_path,file_empId,file_token,file_dateupload,file_status,file_type','?,?,?,?,?,?,?,?',array($Filename,$Type,$path,$empid,$token,time(),1,$file_type));
	
	}
}else{
	// $data = insertSQL('[uploadfile]','[file_name,file_for,file_path,file_empId,file_token,file_dateupload,file_status,file_type','?,?,?,?,?,?,?,?',array($Filename,$Type,$path,$empid,$token,time(),1,$file_type));

	// $data = insertSQL('[hr].[dbo].[uploadfile]','[file_name],[file_for],[file_path],[file_empId],[file_token],[file_dateupload],[file_status],[file_type]','?,?,?,?,?,?,?,?',array($Filename,$Type,$path,$empid,$token,time(),1,$file_type));
}

	


	
	
    // updateSQL('[pms].[dbo].[users_emp]','[emp_img]=?','[emp_token]=?',array($Filename,$id));
	// $seve = $db->prepare("INSERT INTO upload_file(UserId,TypeFile,NameFile,PathFile,StatusFile,DateFile,IpUpload) VALUES (?,?,?,?,?,?,?) ");
    // $seve->execute(array($UserId,$TypeFile,$Filename,$path,0,time(),$ip));
	// if($seve){
	// 	if($TypeFile===1){
	// 	$update_user = $db->prepare("UPDATE account_detail SET StatusImg=? WHERE UserId=? ");
    //   	$update_user->execute(array(1,$UserId));
	// 	}
	// 	return true;
	// }else{
	// 	return false;
	// }

}
function new_file_name($tmp){
	// $token=$_SESSION["token_user"];
    // $id=$_SESSION["UserId"];
	//$filetoken=new_token(5);
	$filename = md5(new_token(20)).".".$tmp;
	// $filename =$tmp;

	return $filename;
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

function get_client_ip() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
	   $ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
  }