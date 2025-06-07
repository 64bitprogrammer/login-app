<?php
    session_start();
    if(isset($_GET['msg'])){
        echo "<h2> {$_GET['msg']} </h2>";
    }
    else{
        
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
?>

