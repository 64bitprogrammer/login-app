<?php
    session_start();  
    $_SESSION = []; 
    session_unset();
    session_destroy();
    print_r($_SESSION);
    header("Location: index.php");
    exit;

?>

