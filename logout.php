<?php
ob_start();
session_start();
?>
<?php
 session_destroy();
 if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-7000000);
        setcookie($name, '', time()-7000000, '/');
    }
}
 echo "<script>window.location='./'</script>";
?>
