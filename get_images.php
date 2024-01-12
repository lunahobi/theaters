<?php
include 'db.php';

$query_images = mysqli_query($mysql, 'SELECT `Дополнительные изображения`, `Изображение` FROM dataset WHERE id=' . $_GET['id'] . ';');
$row = mysqli_fetch_assoc($query_images);
$additional_images = json_decode($row['Дополнительные изображения'], true);
$main_image = json_decode($row['Изображение'], true);

mysqli_close($mysql);

// Объединяем два массива в один
$combined_images = array_merge(array($main_image), $additional_images);

header('Content-Type: application/json');
echo json_encode($combined_images);
?>
