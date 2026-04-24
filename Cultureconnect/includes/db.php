<?php
$host = "127.0.0.1";
$user = "root";
$passwords = ["", "root", "admin", "password"]; // Common local dev passwords
$dbname = "cultureconnect";

$conn = null;
foreach ($passwords as $p) {
    $conn = @new mysqli($host, $user, $p, $dbname, 3307);
    if (!$conn->connect_error) {
        $pass = $p;
        break;
    }
}

if (!$conn || $conn->connect_error) {
    // If we still can't connect, maybe the DB doesn't exist
    $conn = @new mysqli($host, $user, "", "", 3307); 
    if ($conn && !$conn->connect_error) {
        $conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
        $conn->select_db($dbname);
    } else {
        die("<div style='font-family:sans-serif; padding:2rem; text-align:center;'>
            <h2 style='color:#ef4444;'>Database Connection Failed</h2>
            <p>Please ensure your MySQL server is running and check your credentials in <code>db.php</code>.</p>
            <p style='color:#64748b; font-size:0.9rem;'>Error: " . ($conn ? $conn->connect_error : "Unknown") . "</p>
        </div>");
    }
}
?>
