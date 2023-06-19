<?php 


            // $path = '../../src/img/setting/';
            // $extensions = ['jpg', 'jpeg', 'png','ico'];
            // $all_files = count($_FILES['files']['tmp_name']);
            // for ($i = 0; $i < $all_files; $i++) {  
            // $file_name = $_FILES['files']['name'][$i];
            // $file_tmp = $_FILES['files']['tmp_name'][$i];
            // $file_type = $_FILES['files']['type'][$i];
            // $file_size = $_FILES['files']['size'][$i];
            // $tmp = explode('.', $_FILES['files']['name'][$i]);
            // $file_ext = strtolower(end($tmp));
            //  $file_name = new_file_name($file_ext);
            // $file = $path . $file_name;

                    
            //         if(move_uploaded_file($file_tmp, $file)){ 
            //             // saveToDb($file_name,$_POST['setid'][$i]);
                   
            //         }
     
            // }
 

$data = array($_POST);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data);

function new_file_name($tmp){
	$filename = new_token(10).".".$tmp;
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