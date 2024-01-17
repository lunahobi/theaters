<?php

include "mysql/Theaters_DB_Access.php";
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $conn = new Theater_DB_Access;
    $conn->prepare_query("INSERT INTO `messages` (`name`, `email`, `message`) VALUES (?, ?, ?)");
    $conn->issue_query(array($_POST['name'], $_POST['email'], $_POST['message']));
}
header('Location: /');