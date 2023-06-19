<!DOCTYPE html>
<html lang="en">
<?php 
ob_start();
session_start();
use Steampixel\Route;
include 'include/Steampixel/Route.php';
date_default_timezone_set("Asia/Bangkok");
// require_once('include/php/connect.php');
require_once('include/php/function-index.php');
checkloginMaster();
getDataUserPermisionByRolesTypeAndSessionTokenAll();

// print_r($_SESSION['permission']);
// print_r($_SESSION['emp_orgunit']);
// print_r($_SESSION["emp_it_token"]);
// echo "<bR><BR>";
// print_r($_COOKIE);

// // isset($_COOKIE['emp'])?  $_SESSION["emp"] = $_COOKIE['emp'] : null;
// // isset($_COOKIE['emp_token'])?  $_SESSION["emp_token"] = $_COOKIE['emp_token'] : null;
// isset($_COOKIE['emp_it_token'])?  $_SESSION["emp_it_token"] = $_COOKIE['emp_it_token'] : null;
// // isset($_COOKIE['emp_fname'])?  $_SESSION["emp_fname"] = $_COOKIE['emp_fname'] : null;
// // isset($_COOKIE['emp_email'])?  $_SESSION["emp_email"] = $_COOKIE['emp_email'] : null;
// // isset($_COOKIE['emp_id'])?  $_SESSION["emp_id"] = $_COOKIE['emp_id'] : null;



// // isset($_SESSION["emp_token"])?setcookie('emp_token', $_SESSION["emp_token"], time() + (86400 * 30), "/"):null;
// isset($_SESSION["emp_fname"])?setcookie('emp_fname', $_SESSION["emp_fname"], time() + (86400 * 30), "/"):null;
// isset($_SESSION["emp_email"])?setcookie('emp_email', $_SESSION["emp_email"], time() + (86400 * 30), "/"):null;
// isset($_SESSION["emp_id"])?setcookie('emp_id', $_SESSION["emp_id"], time() + (86400 * 30), "/"):null;
// isset($_SESSION["emp_it_token"])?setcookie('emp_it_token', $_SESSION["emp_it_token"], time() + (86400 * 30), "/"):null;





define('BASEPATH','/');

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script> 
    <link href='<?=BASEPATH?>include/css/semantic.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js?v=1.3"></script>
    <script src="https://kit.fontawesome.com/64d58efce2.js" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.js"></script>
<!-- <script src="your-script.js"></script> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@latest/dist/apexcharts.min.css">

   


    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="<?=BASEPATH?>include/css/simditor/simditor.css?v=2.2" />
    <script type="text/javascript" src="<?=BASEPATH?>include/js/simditor/module.js?v=2.2"></script>
    <script type="text/javascript" src="<?=BASEPATH?>include/js/simditor/hotkeys.js?v=2.2"></script>
    <script type="text/javascript" src="<?=BASEPATH?>include/js/simditor/uploader.js?v=2.2"></script>
    <script type="text/javascript" src="<?=BASEPATH?>include/js/simditor/simditor.js?v=2.2"></script>
    <script type="text/javascript" src="<?=BASEPATH?>include/js/simditor/beautify-html.js?v=2.2"></script>
    <link rel="stylesheet" href="<?=BASEPATH?>include/js/simditor/simditor-html.css?v=2.2">
    <script type="text/javascript" src="<?=BASEPATH?>include/js/simditor/simditor-html.js?v=2.2"></script>

    <link rel="icon" type="img/png" href="<?=BASEPATH?>img/ticket1.png">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <link rel="stylesheet" href="style2.css"> -->
    <link rel="stylesheet" href="<?=BASEPATH?>include/css/style.css">
    <script src="<?=BASEPATH?>include/js/main_.js"></script>
    <script src="<?=BASEPATH?>include/js/main_config.js"></script>
    <script src="<?=BASEPATH?>include/js/customFunctions.js"></script>
    <!-- <script src="<?=BASEPATH?>include/js/customFunctions.js"></script> -->
    <script src="<?=BASEPATH?>include/js/custom.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script src="https://cdn.jsdelivr.net/npm/moment@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker@latest"></script>
    

    <script>
    $(window).ready(() => {
        setPathURL_T('<?=BASEPATH?>');
        getDataMySettingPage();
        SETTINGPAGE3 = <?php echo json_encode($_SESSION['permission']) ?>;
    });
    </script>
    <title>Ticket System</title>
</head>

<body>


    <?php
include("include/page/sidebar.php");
include("include/page/navbar.php");
?>


    <?php
    Route::add('/', function() {
        include("include/page/home/main.php");
       
    });
    Route::add('/home', function() {
        include("include/page/home/main.php");
       
    });
    Route::add('/create', function() {
        include("include/page/ticket/main.php");
       
    });

    Route::add('/Assign', function() {
        include("include/page/assign/main.php");
        
    });
    Route::add('/Assign/(.*)', function($token) {
        include("include/page/assign/detail.php");
        
    });
    Route::add('/setting', function() {
        include("include/page/setting/main.php");
       
    });
    Route::add('/inprocess', function() {
        include("include/page/inprocess/main.php");
       
    });
    Route::add('/start_process/(.*)', function($token) {
        include("include/page/start_work/main.php");
    });
    Route::add('/complete', function() {
        include("include/page/complete/main.php");
    });
    Route::add('/assessment', function() {
        include("include/page/assessment/main.php");
    });
    Route::add('/history', function() {
        include("include/page/history/main.php");
    });
    Route::add('/permission', function() {
        include("include/page/setting/permission.php");
    });
    Route::add('/suggest_card', function() {
        include("include/page/setting/suggest_card.php");
    });
    Route::add('/type_req', function() {
        include("include/page/setting/type_request.php");
    });

  
 
              
                    Route::pathNotFound(function($path) {
                        echo 'Error 404 :-(<br>';
                    });
                    
                    Route::methodNotAllowed(function($path, $method) {
                        echo 'Error 405 :-(<br>';
                        echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
                    });


        Route::run(BASEPATH);


?>



    <script src="<?=BASEPATH?>include/js/script.js"></script>
</body>


<!-- <div class="modal fade" id="modal-ViewPDF" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="ViewPDF-Title"></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="far fa-times-circle"></i>
               </button>
            </div>
            <div class="modal-body p-0" id="body-ViewPDF">
            </div>
         </div>
      </div>
   </div> -->

   <div class="modal fade" id="modal-ViewPDF" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="ViewPDF-Title">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0 bodyPreviewImage" id="body-ViewPDF">
        ...
      </div>
      
    </div>
  </div>
</div>
</html>