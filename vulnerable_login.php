<?php
// vulnerable_login.php

// Database connection (adjust as needed)
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "testdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // ❌ Vulnerable SQL query (no parameterization, direct string concatenation)
    $sql = "SELECT * FROM users WHERE username = '$user' AND password = '$pass'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<h2>Login Successful! Welcome " . htmlspecialchars($user) . "</h2>";
    } else {
        echo "<h2>Login Failed</h2>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Login Page</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
        <label>Username:</label>
        <input type="text" name="username"><br><br>
        
        <label>Password:</label>
        <input type="password" name="password"><br><br>
        
        <button type="submit">Login</button>
    </form>
</body>
</html>
