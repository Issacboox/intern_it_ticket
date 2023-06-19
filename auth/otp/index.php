<?php
session_start();
// require('../../include/php/function-index.php');
// $datalogin = checklogin();
// session_destroy();
// echo $_SESSION['from-page'];
if(isset($_SESSION['from-page'])){
    $frompage = $_SESSION['from-page'];
}else{
    $frompage = '';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BT Auth - BT MIDLAND CO.,LTD.</title>
    <link rel="icon" type="image/png" href="../logo_bt_ico.png" />
    
    <link rel="stylesheet" href="../bootstrap.min.css"/>
    <link href="../semantic.css" rel="stylesheet" />
    <link rel="stylesheet" href="../auth.css"/>
    <!-- <script type="text/javascript" src="../../include/sweetalert/sweetalert2@11"></script> -->
    <script type="text/javascript" src="../sweetalert.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="../auth.js"></script>
    
    <script type="text/javascript">
    $(window).ready(() => {
    $(`#empCode`).keyup(function(event) {
        this.value = this.value.toLocaleUpperCase();
        this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
        if(this.value.length >3){
            this.value = this.value[0] +this.value[1] +this.value[2] 
        }else{
            if (event.keyCode === 13) { checkDataEmpCode('<?=$frompage?>') }
        }
    })
    });
</script>
</head>
<body class="sidebar-mini layout-fixed " style="height: auto;">
    <div class="login-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card">
                        <div class="card-body text-center" id="cardTech">
                            <img src="../logo_bt.svg"  class="logo_bt logo_bt_tech">
                            <h1 class="title text-center tech">BT MIDLAND SIGNIN</h1>
                            <hr>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="empCode" class="txtTitleD">ระบุรหัสพนักงาน (ตัวเลขเท่านั้น)</label>
                                        <input type="text" class="form-control inputempCode_signin" id="empCode" aria-describedby="emailHelp">
                                        <span id="txt_subtitle_signin" class="form-text text-muted txt_subtitle_signin">ระบุรหัสพนักงานของท่าน ระบบจะส่ง OTP ไปยัง Email ที่ท่านได้ลงทะเบียนไว้</span>
                                    </div>
                                    <div class="form-group" id="showInputOtp">
                                        <!-- <label for="OTP" class="txtTitleD">ระบุ OTP ที่ได้รับทาง Email<br><small id="txtshowEmail"></small></label>
                                        <input type="text" class="form-control inputempCode_signin" id="OTP" aria-describedby="emailHelp"> -->
                                        <!-- <span id="emailHelp" class="form-text text-muted txt_subtitle_signin">ระบุรหัสพนักงานของท่าน ระบบจะส่ง OTP ไปยัง Email ที่ท่านได้ลงทะเบียนไว้</span> -->
                                    </div>
                                </div>
                                <!-- <div class="col-md-6">2</div> -->
                            </div>
                            <button class="btn btn-block btn-danger mt-3 btn_checkData" onclick="checkDataEmpCode('<?=$frompage?>')" id="btnSignIn"  >
                                   ตรวจสอบข้อมูล
                            </button>
                            <button class="btn btn-block btn-secondary" onclick="location='../'" id="gp-login-tech-btn" >
                            < ย้อนกลับ
                            </button>
                          <!--  <button class="btn btn-block " onclick="signOut()">logout</button> -->
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</body>
</html>


<!-- 
test@tech.bt-midland.com
Bt123456*
 -->
