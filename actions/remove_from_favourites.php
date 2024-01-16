<?php
include "db.php";
session_start();


if (!isset($_SESSION['user']['id'])) {
    die("Вы не авторизованы");
}
$userId = $_SESSION['user']['id'];

// Получение данных из AJAX-запроса
$theaterId = $_POST['theaterId'];

// Удаление из избранного
$query = "DELETE FROM favourites WHERE user_id = ? AND theater_id = ?";
$stmt = mysqli_prepare($mysql, $query);
mysqli_stmt_bind_param($stmt, "ii", $userId, $theaterId);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($mysql);

echo "Удалено из избранного";
