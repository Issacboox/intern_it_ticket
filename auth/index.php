<?php
ob_start();
session_start();
// require('../include/php/function-index.php');
// $datalogin = checklogin();
// session_destroy();
// echo $_SESSION['from-page'];
if(isset($_SESSION['from-page'])){
    $frompage = $_SESSION['from-page'];
}else{
    $frompage = '';
}

if(isset($_SESSION['emp_it_token']) && !!$_SESSION['emp_it_token']){
    echo "<script>window.location='../home'</script>";
}


// $_COOKIE['name']='tiw';
// print_r($_SERVER['HTTP_COOKIE']);
// echo '<br>';
// print_r($_COOKIE);
// echo "<br>";
// print_r($_SESSION);



//$_SESSION['test']='patipan';
//echo $_SESSION['test'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบ IT Ticket บริษัท บีที มิตรแลนด์ จำกัด</title>
    <!-- <link rel="stylesheet" href="app.css"/> -->
    <link rel="icon" type="image/png" href="../include/img/logo_bt_ico.png" />
    <link href="semantic.css" rel="stylesheet" />
    <link rel="stylesheet" href="bootstrap.min.css"/>
    <link rel="stylesheet" href="auth.css?v=1"/>
    <!-- <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script> -->

    <meta name="google-signin-scope" content="profile email">
    <meta name="google-signin-client_id" content="758364311008-9c3kp8975g2m1n8qlf6fags9ih3d2rp8.apps.googleusercontent.com">
    

    <!-- // test 758364311008-f1shc1g4vephpqct7slpa47i59snnc1l.apps.googleusercontent.com
// product 758364311008-9c3kp8975g2m1n8qlf6fags9ih3d2rp8.apps.googleusercontent.com -->

<!-- //production -  758364311008-9c3kp8975g2m1n8qlf6fags9ih3d2rp8.apps.googleusercontent.com
// test - 758364311008-f1shc1g4vephpqct7slpa47i59snnc1l.apps.googleusercontent.com -->

    <script src="https://apis.google.com/js/platform.js?onload=bindGpLoginBtn" async defer></script>
    <!-- <script src="../include/sweetalert/sweetalert2@11"></script>-->
    <script type="text/javascript" src="sweetalert.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script type="text/javascript" src="auth.js?v=1"></script>
    <script type="text/javascript">
    $(window).ready(() => {
    // //   getDataAccountAdmin('all','')
    //     getDataPageProfile('all','')
    // $('.btn_checkData').click(function(){
    //     checkDataEmpCode()
    // })
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
    <div class="login-page" id="login-page">
        <div class="container">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-sm-12 col-lg-6">
                    <div class="card setPandingCenter">
                        <div class="card-body text-center ">
                                <div class="form-row">
                                    <div class="col-4 text-left"><img src="./logo-bt-mimdland.png"  class="logo_bt"></div>
                                    <div class="col-8 text-right"><div class="title txtTitleLogin_t">IT Ticket<br>บริษัท บีที มิตรแลนด์</div></div>
                                    <div class="col-12"><hr></div>
                                </div>
                            <div class="form-row text-left">
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label for="empEmail" class="txtTitleD">ระบุอีเมลพนักงาน</label>
                                        <input type="text" class="form-control inputempCode_signin" id="empEmail" aria-describedby="emailHelp">
                                        <span id="txt_subtitle_signin0" class="form-text text-muted txt_subtitle_signin">ใช้อีเมล @bt-midland.com หรือ @tech.bt-midland.com เท่านั้น</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="empCode" class="txtTitleD">ระบุรหัสพนักงาน (ตัวเลขเท่านั้น)</label>
                                        <input type="text" class="form-control inputempCode_signin" id="empCode" aria-describedby="emailHelp">
                                        <span id="txt_subtitle_signin" class="form-text text-muted txt_subtitle_signin">ระบุรหัสพนักงานของท่าน เช่น 000</span>
                                    </div>
                                    <div class="form-group" id="showInputOtp"></div>
                                </div>
                                <div class="col-md-12">
                                    <button class="btn btn-block btn-danger mt-3 btn_checkData" onclick="checkDataEmpCode('<?=$frompage?>')" id="btnSignIn"  >
                                        ตรวจสอบข้อมูล
                                    </button>
                                </div>
                            </div>
                            <small style="font-size: .7rem;">Specify employee code for get an OTP code sent to your email address</small>
                            <p style="line-height: 1.5;font-size: .7rem;margin-bottom: 0;margin-top: .5rem">เว็บไซต์นี้มีการจัดเก็บข้อมูลการจราจรทางคอมพิวเตอร์ (Log การใช้งาน)<br>การลงชื่อเข้าใช้ ถือว่าท่าน<b>ยินยอม</b>ให้ระบบบันทึกข้อมูลพฤติกรรมการใช้งาน<b>ในระบบนี้ทั้งหมด</b></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</body>
</html>


<!-- <script type="module">
  // Import the functions you need from the SDKs you need
  import { initializeApp } from "https://www.gstatic.com/firebasejs/9.6.4/firebase-app.js";
  import { getAnalytics } from "https://www.gstatic.com/firebasejs/9.6.4/firebase-analytics.js";
  // TODO: Add SDKs for Firebase products that you want to use
  // https://firebase.google.com/docs/web/setup#available-libraries

  // Your web app's Firebase configuration
  // For Firebase JS SDK v7.20.0 and later, measurementId is optional
  const firebaseConfig = {
    apiKey: "AIzaSyCF027e6WDUoHXGuvveHkKYupjAVWARIuM",
    authDomain: "project-test-18b78.firebaseapp.com",
    projectId: "project-test-18b78",
    storageBucket: "project-test-18b78.appspot.com",
    messagingSenderId: "18631706357",
    appId: "1:18631706357:web:7075d6a71e4ed62df3a7bc",
    measurementId: "G-110TVX0ZS0"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
  const analytics = getAnalytics(app);
</script> -->