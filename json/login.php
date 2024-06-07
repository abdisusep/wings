<?php

    session_start();
    include "../config/db.php";

    header('Content-Type: application/json');

    $user     = $_POST['user'];
    $password = md5($_POST['password']);

    $sql    = "SELECT * FROM login WHERE user='$user' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $user;
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Login failed']);
    }
?>
