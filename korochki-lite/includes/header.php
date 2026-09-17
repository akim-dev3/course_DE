<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? h($title) : 'Корочки.есть' ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<nav class="main-nav">
    <div class="container d-flex justify-content-between align-items-center flex-wrap py-2">
        <a class="navbar-brand text-white" href="index.php">Корочки<span>.есть</span></a>
        <div>
            <?php if (!empty($_SESSION['admin'])): ?>
                <a class="nav-link d-inline text-white" href="admin.php">Заявки</a>
                <a class="nav-link d-inline text-white" href="logout.php">Выйти</a>
            <?php elseif (!empty($_SESSION['user_id'])): ?>
                <a class="nav-link d-inline text-white" href="cabinet.php">Мои заявки</a>
                <a class="nav-link d-inline text-white" href="request.php">Оставить заявку</a>
                <a class="nav-link d-inline text-white" href="logout.php">Выйти</a>
            <?php else: ?>
                <a class="nav-link d-inline text-white" href="login.php">Вход</a>
                <a class="nav-link d-inline text-white" href="register.php">Регистрация</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container page">
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success"><?= h($_SESSION['flash']) ?></div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>