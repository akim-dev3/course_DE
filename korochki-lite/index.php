<?php
require 'init.php';
$title = 'Курсы дополнительного образования';
require 'includes/header.php';
?>

<div class="slider" id="slider">
    <div class="slider-track">
        <img src="assets/img/slide1.jpg" alt="Курс 1">
        <img src="assets/img/slide2.jpg" alt="Курс 2">
        <img src="assets/img/slide3.jpg" alt="Курс 3">
        <img src="assets/img/slide4.jpg" alt="Курс 4">
    </div>
    <button class="slider-btn prev" id="prev">&#10094;</button>
    <button class="slider-btn next" id="next">&#10095;</button>
</div>

<div class="intro">
    <h1>Получите новую профессию</h1>
    <p>Онлайн-курсы дополнительного образования. Записывайтесь и учитесь в удобном темпе.</p>
    <?php if (empty($_SESSION['user_id']) && empty($_SESSION['admin'])): ?>
        <a href="register.php" class="btn btn-primary btn-lg">Начать обучение</a>
    <?php else: ?>
        <a href="request.php" class="btn btn-primary btn-lg">Оставить заявку</a>
    <?php endif; ?>
</div>

<div class="row courses">
    <?php foreach ($courses as $i => $c): ?>
    <div class="col-md-4 mb-4 fade-up">
        <div class="course-card">
            <div class="course-num"><?= $i + 1 ?></div>
            <h3><?= h($c) ?></h3>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php require 'includes/footer.php'; ?>
