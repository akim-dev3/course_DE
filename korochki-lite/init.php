<?php
session_start();

require 'includes/db.php';

$pdo = new PDO('mysql:host=localhost;dbname=korochki_est;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

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