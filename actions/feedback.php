<?php
include "db.php";
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
    $query = "INSERT INTO `messages` (`name`, `email`, `message`) VALUES ('{$_POST['name']}', '{$_POST['email']}', '{$_POST['message']}')";

    $result = mysqli_query($mysql, $query);
}
header('Location: /');