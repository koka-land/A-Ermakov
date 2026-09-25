<?php
session_start();

// ---------------------------------------------------------
// Подключение к MySQL (beget.tech)
// ---------------------------------------------------------
define('DB_HOST', 'localhost');       // сервер для подключения сайтов
define('DB_NAME', 'kokaland_ae');
define('DB_USER', 'kokaland_ae');

// Пароль базы НЕ храните в чате/переписке — впишите его прямо здесь,
// на сервере, вручную (или через переменную окружения хостинга).
define('DB_PASS', '@EaS05052020EmA!EmA%');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die('Ошибка подключения к базе данных: ' . $e->getMessage());
}

// ---------------------------------------------------------
// Логин администратора (временное простое решение — один аккаунт)
// ---------------------------------------------------------
define('ADMIN_USERNAME', 'admin');

// Хеш пароля. Сгенерируйте свой командой в терминале хостинга или локально:
//   php -r "echo password_hash('ваш_пароль', PASSWORD_DEFAULT);"
// и вставьте результат сюда вместо строки ниже.
define('ADMIN_PASSWORD_HASH', '$2y$10$3al1A7.umebZCnFzOEx7pu.eYerMBdJjjl2QkEZmP2vLYKj1UOzoq');
