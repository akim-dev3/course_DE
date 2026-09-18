<?php
require 'init.php';
require 'includes/validators.php';

if (!empty($_SESSION['user_id'])) {
    header('Location: cabinet.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass  = $_POST['password'] ?? '';
    $fio   = trim($_POST['fio'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!validLogin($login)) {
        $error = 'Логин от 6 символов, латиница и цифры';
    } elseif (!validPassword($pass)) {
        $error = 'Пароль не короче 8 символов';
    } elseif (!validFio($fio)) {
        $error = 'Укажите ФИО кириллицей';
    } elseif (!validPhone($phone)) {
        $error = 'Формат телефона: 8(999)123-45-67';
    } elseif (!validEmail($email)) {
        $error = 'Неверный e-mail';
    } elseif ($login == ADMIN_LOGIN || isLoginTaken($link, $login)) {
        $error = 'Такой логин уже занят';
    } else {
        registerUser($link, $login, $pass, $fio, $phone, $email);
        $_SESSION['flash'] = 'Регистрация прошла успешно. Войдите в систему.';
        header('Location: login.php');
        exit;
    }
}

$title = 'Регистрация';
require 'includes/header.php';
?>

<div class="form-box">
    <h1>Регистрация</h1>
    <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
    <form method="post" novalidate>
        <div class="mb-3">
            <label class="form-label">Логин</label>
            <input type="text" name="login" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">ФИО</label>
            <input type="text" name="fio" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Телефон</label>
            <input type="text" name="phone" placeholder="8(999)123-45-67" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="text" name="email" class="form-control">
        </div>
        <button class="btn btn-primary w-100">Зарегистрироваться</button>
        <a href="login.php" class="d-block text-center mt-3">Уже зарегистрированы? Вход</a>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
