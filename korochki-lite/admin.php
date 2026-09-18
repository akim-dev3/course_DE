<?php
require 'init.php';

if (empty($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    changeRequestStatus($link, (int)$_POST['id'], $_POST['status'] ?? '', $statuses);
    $_SESSION['flash'] = 'Статус заявки #' . (int)$_POST['id'] . ' изменён';
    header('Location: admin.php?' . http_build_query($_GET));
    exit;
}

$fStatus = in_array($_GET['status'] ?? '', $statuses, true) ? $_GET['status'] : '';
$list = getRequestsForAdmin($link, $fStatus);

$title = 'Панель администратора';
require 'includes/header.php';
?>

<h1>Заявки</h1>

<form method="get" class="row g-2 mb-3">
    <div class="col-auto">
        <select name="status" class="form-select">
            <option value="">Все статусы</option>
            <?php foreach ($statuses as $s): ?>
                <option <?= $fStatus == $s ? 'selected' : '' ?>><?= h($s) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-auto">
        <button class="btn btn-outline-primary">Показать</button>
    </div>
</form>

<div class="table-responsive">
<table class="table table-hover align-middle">
    <thead>
        <tr><th>#</th><th>Пользователь</th><th>Курс</th><th>Дата</th><th>Оплата</th><th>Статус</th></tr>
    </thead>
    <tbody>
    <?php foreach ($list as $r): ?>
        <tr>
            <td><?= $r['id'] ?></td>
            <td><?= h($r['fio']) ?><br><small class="text-muted"><?= h($r['login']) ?></small></td>
            <td><?= h($r['course']) ?></td>
            <td><?= date('d.m.Y', strtotime($r['start_date'])) ?></td>
            <td><?= h($r['payment']) ?></td>
            <td>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $r['id'] ?>">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <?php foreach ($statuses as $s): ?>
                            <option <?= $r['status'] == $s ? 'selected' : '' ?>><?= h($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$list): ?>
        <tr><td colspan="6" class="text-center text-muted">Заявок нет</td></tr>
    <?php endif; ?>
    </tbody>
</table>
</div>

<?php require 'includes/footer.php'; ?>