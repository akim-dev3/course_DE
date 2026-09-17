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
<nav class="navbar navbar-expand-lg navbar-dark main-nav">
    <div class="container">
        <a class="navbar-brand" href="index.php">Корочки<span>.есть</span></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <?php if (!empty($_SESSION['admin'])): ?>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Заявки</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                <?php elseif (!empty($_SESSION['user_id'])): ?>
                    <li class="nav-item"><a class="nav-link" href="cabinet.php">Мои заявки</a></li>
                    <li class="nav-item"><a class="nav-link" href="request.php">Оставить заявку</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Выйти</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="login.php">Вход</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container page">
<?php if (!empty($_SESSION['flash'])): ?>
    <div class="alert alert-success"><?= h($_SESSION['flash']) ?></div>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
