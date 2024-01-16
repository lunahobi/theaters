<?php
session_start();

require_once __DIR__ . '/config.php';


function redirect(string $path)
{
    header("Location: $path");
    die();
}

function addValidationError(string $fieldName, string $message)
{
    $_SESSION['validation'][$fieldName] = $message;
}

function clearValidation()
{
    $_SESSION['validation'] = [];
}

function hasValidationError(string $fieldName): bool
{
    return isset($_SESSION['validation'][$fieldName]);
}

function validationErrorAttr(string $fieldName)
{
    echo isset($_SESSION['validation'][$fieldName]) ? 'aria-invalid="true"' : '';
}

function validationErrorMessage(string $fieldName)
{
    $message = $_SESSION['validation'][$fieldName] ?? '';
    unset($_SESSION['validation'][$fieldName]);
    echo $message;
}

function addOldValue(string $key, mixed $value): void
{
    $_SESSION['old'][$key] = $value;
}

function old(string $key)
{
    $value = $_SESSION['old'][$key] ?? '';
    unset($_SESSION['old'][$key]);
    return $value;
}

function setMessage(string $key, string $message): void
{
    $_SESSION['message'][$key] = $message;
}

function hasMessage(string $key): bool
{
    return isset($_SESSION['message'][$key]);
}

function getMessage(string $key): string
{
    $message = $_SESSION['message'][$key] ?? '';
    unset($_SESSION['message'][$key]);
    return $message;
}

function getPDO(): PDO
{
    try {
        return new \PDO('mysql: host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
    } catch (\PDOException $e) {
        die("DB error {$e->getMessage()}");
    }
}

function findUser(string $email): array|bool
{
    $pdo = getPDO();

    $stmt = $pdo->prepare("SELECT * FROM users WHERE `email`=:email");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function currentUser(): array|false
{
    $pdo = getPDO();

    if (!isset($_SESSION['user'])) {
        return false;
    }

    $userId = $_SESSION['user']['id'] ?? null;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE `id`=:id");
    $stmt->execute([':id' => $userId]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

function logout()
{
    unset($_SESSION['user']['id']);
    redirect('/autorization.php');
}

function checkAuth(): void
{
    if(!isset($_SESSION['user']['id'])){
        redirect('/');
    }
}

function checkGuest(): void
{
    if(isset($_SESSION['user']['id'])){
        redirect('/lk.php');
    }
}
