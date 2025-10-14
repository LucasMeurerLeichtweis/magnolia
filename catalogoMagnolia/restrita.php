<?php
session_start();
if (!isset($_SESSION['idUsuario']) || $_SESSION['idUsuario'] != 1) {
    header("Location: fazerLogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM</title>
</head>
<body>
    
</body>
</html>
