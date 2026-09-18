<?php
require 'init.php';

if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['review_id'])) {
    $text = trim($_POST['review'] ?? '');
    if ($text != '') {
        addReview($link, (int)$_POST['review_id'], $_SESSION['user_id'], $text);
        $_SESSION['flash'] = 'Спасибо за отзыв!';
    }
    header('Location: cabinet.php');
    exit;
}

$list = getRequestsByUser($link, $_SESSION['user_id']);

$title = 'Мои заявки';
require 'includes/header.php';
?>

<h1>Мои заявки</h1>

<?php if (!$list): ?>
    <p>У вас пока нет заявок. <a href="request.php">Оставить первую</a>.</p>
<?php endif; ?>

<?php foreach ($list as $r): ?>
    <div class="card mb-3 fade-up">
        <div class="card-body">
            <h5 class="card-title"><?= h($r['course']) ?></h5>
            <p class="mb-1">Дата начала: <?= date('d.m.Y', strtotime($r['start_date'])) ?></p>
            <p class="mb-1">Оплата: <?= h($r['payment']) ?></p>
            <p class="mb-2">Статус:
                <span class="badge status-<?= array_search($r['status'], $statuses) ?>">
                    <?= h($r['status']) ?>
                </span>
            </p>

            <?php if ($r['status'] == 'Обучение завершено'): ?>
                <?php if ($r['review']): ?>
                    <div class="review">Ваш отзыв: «<?= h($r['review']) ?>»</div>
                <?php else: ?>
                    <form method="post" class="review-form">
                        <input type="hidden" name="review_id" value="<?= $r['id'] ?>">
                        <textarea name="review" class="form-control mb-2" rows="2"
                                  placeholder="Оставьте отзыв о курсе" required></textarea>
                        <button class="btn btn-outline-primary btn-sm">Отправить отзыв</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>

<?php require 'includes/footer.php'; ?>
