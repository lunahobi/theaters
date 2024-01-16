<?php

require_once __DIR__ . '/../helpers.php';

//Выносим данные из $_POST в отдельные переменные
$name = $_POST['fio'] ?? null;
$email = $_POST['e-mail'] ?? null;
$password = $_POST['pass'] ?? null;
$passwordConfirmation = $_POST['pass_conf'] ?? null;

//Валидация


if (empty($name)) {
    addValidationError('fio', 'Пустое имя');
}

if (empty($email)) {
    addValidationError('e-mail', 'Пустая почта');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email)) {
    addValidationError('e-mail', 'Указана неправильная почта');
}

if (empty($password)) {
    addValidationError('pass', 'Пароль пустой');
}

if ($password != $passwordConfirmation) {
    addValidationError('pass', 'Пароли не совпадают');
}


$pdo = getPDO();

// Проверка наличия пользователя с указанным email
$checkQuery = "SELECT COUNT(*) FROM users WHERE email = :email";
$checkStmt = $pdo->prepare($checkQuery);
$checkStmt->bindParam(':email', $email, PDO::PARAM_STR);
$checkStmt->execute();

if ($checkStmt->fetchColumn() > 0) {
    // Пользователь с таким email уже существует
    addValidationError('e-mail', 'Пользователь с такой почтой уже существует');
}

if (!empty($_SESSION['validation'])) {
    addOldValue('e-mail', $email);
    addOldValue('fio', $name);
    redirect("/registration.php");
}
// Продолжаем вставку, так как пользователя с таким email нет в базе
$insertQuery = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)";
$insertStmt = $pdo->prepare($insertQuery);
$insertStmt->bindParam(':name', $name, PDO::PARAM_STR);
$insertStmt->bindParam(':email', $email, PDO::PARAM_STR);
$insertStmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);

try {
    $insertStmt->execute();
} catch (\Exception $e) {
    die("Connection error {$e->getMessage()}");
}
redirect('/autorization.php');
