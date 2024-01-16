<?php
// Подключение к базе данных
include "db.php";
session_start();

if (!isset($_SESSION['user']['id'])) {
    die("Вы не авторизованы");
}
$userId = $_SESSION['user']['id'];

// Получение данных из AJAX-запроса
$theaterId = $_POST['theaterId'];

// Добавление в избранное
$query = "INSERT INTO favourites (user_id, theater_id) VALUES (?, ?)";
$stmt = mysqli_prepare($mysql, $query);
mysqli_stmt_bind_param($stmt, "ii", $userId, $theaterId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($mysql);

echo "Добавлено в избранное";
