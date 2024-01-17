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

$conn = connection();

$conn->prepare_query("SELECT COUNT(*) FROM users WHERE email = ?");
$conn->issue_query(array($email));
$cnt = $conn->fetch_row()[0];

if ($cnt > 0) {
    addValidationError('e-mail', 'Пользователь с такой почтой уже существует');
    echo $cnt;
}

if (!empty($_SESSION['validation'])) {
    addOldValue('e-mail', $email);
    addOldValue('fio', $name);
    redirect("/registration.php");
}

$conn->prepare_query("INSERT INTO users (`name`, `email`, `password`) VALUES (?, ?, ?)");
$conn->issue_query(array($name, $email, password_hash($password, PASSWORD_DEFAULT)));

redirect('/autorization.php');
