<?php
// Подключение к базе данных
include "mysql/Theaters_DB_Access.php";
session_start();

if (!isset($_SESSION['user']['id'])) {
    die("Вы не авторизованы");
}
$userId = $_SESSION['user']['id'];

// Получение данных из AJAX-запроса
$theaterId = $_POST['theaterId'];

$conn = new Theater_DB_Access;
$conn->prepare_query("INSERT INTO favourites (user_id, theater_id) VALUES (?, ?)");
$conn->issue_query(array($userId, $theaterId));

echo "Добавлено в избранное";
