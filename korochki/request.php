<?php
require 'init.php';
require 'includes/validators.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course  = $_POST['course'] ?? '';
    $date    = trim($_POST['start_date'] ?? '');
    $payment = $_POST['payment'] ?? '';

    if (!in_array($course, $courses, true)) {
        $error = 'Выберите курс из списка';
    } elseif (!validDate($date)) {
        $error = 'Дата в формате ДД.ММ.ГГГГ';
    } elseif (!in_array($payment, $payments, true)) {
        $error = 'Выберите способ оплаты';
    } else {
        (new Request($pdo))->create($_SESSION['user_id'], $course, dateToSql($date), $payment);
        $_SESSION['flash'] = 'Заявка отправлена. Ожидайте подтверждения.';
        header('Location: cabinet.php');
        exit;
    }
}

$title = 'Оставить заявку';
require 'includes/header.php';
?>

<div class="form-box">
    <h1>Заявка на курс</h1>
    <?php if ($error): ?><div class="alert alert-danger"><?= h($error) ?></div><?php endif; ?>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Курс</label>
            <select name="course" class="form-select">
                <option value="">— выберите курс —</option>
                <?php foreach ($courses as $c): ?>
                    <option><?= h($c) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Дата начала</label>
            <input type="text" name="start_date" placeholder="ДД.ММ.ГГГГ" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Способ оплаты</label>
            <select name="payment" class="form-select">
                <option value="">— выберите —</option>
                <?php foreach ($payments as $p): ?>
                    <option><?= h($p) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button class="btn btn-primary w-100">Отправить</button>
    </form>
</div>

<?php require 'includes/footer.php'; ?>
