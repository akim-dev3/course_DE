<?php

function isLoginTaken($pdo, $login)
{
    $st = $pdo->prepare('SELECT id FROM users WHERE login = ?');
    $st->execute([$login]);
    return (bool) $st->fetch();
}

function registerUser($pdo, $login, $password, $fio, $phone, $email)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $st = $pdo->prepare('INSERT INTO users (login, password, fio, phone, email) VALUES (?, ?, ?, ?, ?)');
    $st->execute([$login, $hash, $fio, $phone, $email]);
}

function attemptLogin($pdo, $login, $password)
{
    $st = $pdo->prepare('SELECT * FROM users WHERE login = ?');
    $st->execute([$login]);
    $user = $st->fetch();
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return null;
}

function createRequest($pdo, $userId, $course, $startDate, $payment)
{
    $st = $pdo->prepare('INSERT INTO requests (user_id, course, start_date, payment, status) VALUES (?, ?, ?, ?, ?)');
    $st->execute([$userId, $course, $startDate, $payment, 'Новая']);
}

function getRequestsByUser($pdo, $userId)
{
    $st = $pdo->prepare('SELECT * FROM requests WHERE user_id = ? ORDER BY id DESC');
    $st->execute([$userId]);
    return $st->fetchAll();
}

// отзыв можно оставить только по завершённому обучению - проверка прямо в запросе
function addReview($pdo, $id, $userId, $text)
{
    $st = $pdo->prepare("UPDATE requests SET review = ? WHERE id = ? AND user_id = ? AND status = 'Обучение завершено'");
    $st->execute([$text, $id, $userId]);
}

function changeRequestStatus($pdo, $id, $status, $validStatuses)
{
    if (in_array($status, $validStatuses, true)) {
        $st = $pdo->prepare('UPDATE requests SET status = ? WHERE id = ?');
        $st->execute([$status, $id]);
    }
}

function getRequestsForAdmin($pdo, $filterStatus)
{
    $sql = 'SELECT r.*, u.fio, u.login FROM requests r JOIN users u ON u.id = r.user_id';
    $params = [];
    if ($filterStatus != '') {
        $sql .= ' WHERE r.status = ?';
        $params[] = $filterStatus;
    }
    $sql .= ' ORDER BY r.id DESC';
    $st = $pdo->prepare($sql);
    $st->execute($params);
    return $st->fetchAll();
}