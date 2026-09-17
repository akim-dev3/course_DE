<?php
require 'init.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = trim($_POST['login'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($login == ADMIN_LOGIN && $pass == ADMIN_PASS) {
        $_SESSION['admin'] = true;
        header('Location: admin.php');
        exit;
    }

    $user = attemptLogin($pdo, $login, $pass);
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fio'] = $user['fio'];
        header('Location: cabinet.php');
        exit;
    }

    $error = 'Неверный логин или пароль';
}

$title = 'Вход';
require 'includes/header.php';
?>

<div class="form-box">
    <h1>Вход</h1>
    <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Логин</label>
            <input type="text" name="login" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button class="btn btn-primary w-100">Войти</button>
        <a href="register.php" class="d-block text-center mt-3">Еще не зарегистрированы? Регистрация</a>
    </form>
</div>

<?php require 'includes/footer.php'; ?>