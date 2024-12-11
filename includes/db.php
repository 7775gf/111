<?php
$host = 'localhost'; // Адрес сервера базы данных
$db   = 'food_planner'; // Имя базы данных
$user = 'root1'; // Имя пользователя базы данных
$pass = '1'; // Пароль пользователя базы данных
$charset = 'utf8mb4'; // Кодировка

// Строка подключения (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Опции для PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Включаем режим выброса исключений
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Устанавливаем режим выборки данных
    PDO::ATTR_EMULATE_PREPARES   => false, // Отключаем эмуляцию подготовленных выражений
];

try {
    // Создаем объект PDO для подключения к базе данных
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Обрабатываем ошибку подключения
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>