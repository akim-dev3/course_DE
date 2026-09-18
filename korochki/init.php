<?php
session_start();

require 'includes/db.php';

$link = mysqli_connect('localhost', 'root', '', 'korochki_est');
if (!$link) {
    echo 'Ошибка подключения к базе данных: ' . mysqli_connect_error();
    exit;
}
mysqli_set_charset($link, 'utf8mb4');

define('ADMIN_LOGIN', 'Admin');
define('ADMIN_PASS', 'KorokNET');

$courses = [
    'Основы алгоритмизации и программирования',
    'Основы веб-дизайна',
    'Основы проектирования баз данных',
];

$payments = ['Наличными', 'Переводом по номеру телефона'];
$statuses = ['Новая', 'Идёт обучение', 'Обучение завершено'];

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
