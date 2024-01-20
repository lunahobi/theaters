<?php

require_once __DIR__ . '/../helpers.php';

$email = $_POST['e-mail'] ?? null;
$password = $_POST['pass'] ?? null;

addOldValue('e-mail', $email);

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($email)) {

    addValidationError('e-mail', 'Неверный формат электронной почты');
    setMessage('error', 'Ошибка валидации');
    redirect('/autorization.php');
}

if (empty($password)) {
    addValidationError('pass', 'Пароль пустой');
}

$user = findUser($email);

if (!$user) {
    setMessage('error', "Пользователь $email не найден");
    redirect('/autorization.php');
}

if (!password_verify($password, $user['password'])) {
    setMessage('error', "Неверный пароль");
    redirect('/autorization.php');
}

$_SESSION['user']['id'] = $user['id'];

redirect('/lk.php');
