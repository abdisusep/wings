<?php

session_start();
include "config/db.php";

if (isset($_SESSION['user'])) {
    if (isset($_GET['p'])) {
        include "pages/" . $_GET['p'] . ".php";
    }else{
        include "pages/home.php";
    }
}else{
    include "pages/login.php";
}

?>