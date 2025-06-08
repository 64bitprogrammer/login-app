<?php

// session_name("login-app-v1");
// if (session_status() === PHP_SESSION_NONE) {
    session_start();
// }

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

function runQuery($query, $params){
    global $conn;
    
        $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($conn));
    }

    if (!empty($params)) {
        // Dynamically build the types string (e.g., 'ssi')
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                $types .= 'b'; // blob or unknown
            }
        }

        // Bind parameters
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    
    if ($result !== false) {
        // SELECT query: return result object
        return $result;
    } else {
        // Non-SELECT query: return number of affected rows
        return mysqli_stmt_affected_rows($stmt);
    }
}