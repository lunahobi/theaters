<?php

include "mysql/Theaters_DB_Access.php";

if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['message'];
    $conn = new Theater_DB_Access;
    $conn->prepare_query("INSERT INTO `messages` (`name`, `email`, `message`) VALUES (?, ?, ?)");
    $conn->issue_query(array($name, $email, $msg));
}
header('Location: /');