<?php

session_name("login-app-v1");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('SERVER','localhost');
define('USERNAME','root');
define('PASSWORD','');
define('DATABASE','login-app');

// Create connection
$conn = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}