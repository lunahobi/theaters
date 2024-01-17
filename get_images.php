<?php
include "mysql/Theaters_DB_Access.php";

$conn = new Theater_DB_Access;

$conn->prepare_query("SELECT `Дополнительные изображения`, `Изображение` FROM dataset WHERE id=?");
$conn->issue_query(array($_GET['id']));
$row = $conn->fetch_array();
$additional_images = json_decode($row['Дополнительные изображения'], true);
$main_image = json_decode($row['Изображение'], true);

// Объединяем два массива в один
$combined_images = array_merge(array($main_image), $additional_images);

header('Content-Type: application/json');
echo json_encode($combined_images);
?>
