<?php

function isLoginTaken($link, $login)
{
    $st = mysqli_prepare($link, 'SELECT id FROM users WHERE login = ?');
    mysqli_stmt_bind_param($st, 's', $login);
    mysqli_stmt_execute($st);
    return (bool) mysqli_fetch_assoc(mysqli_stmt_get_result($st));
}

function registerUser($link, $login, $password, $fio, $phone, $email)
{
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $st = mysqli_prepare($link, 'INSERT INTO users (login, password, fio, phone, email) VALUES (?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($st, 'sssss', $login, $hash, $fio, $phone, $email);
    mysqli_stmt_execute($st);
}

function attemptLogin($link, $login, $password)
{
    $st = mysqli_prepare($link, 'SELECT * FROM users WHERE login = ?');
    mysqli_stmt_bind_param($st, 's', $login);
    mysqli_stmt_execute($st);
    $result = mysqli_stmt_get_result($st);
    $user = mysqli_fetch_assoc($result);
    if ($user && password_verify($password, $user['password'])) {
        return $user;
    }
    return null;
}

function createRequest($link, $userId, $course, $startDate, $payment)
{
    $status = 'Новая';
    $st = mysqli_prepare($link, 'INSERT INTO requests (user_id, course, start_date, payment, status) VALUES (?, ?, ?, ?, ?)');
    mysqli_stmt_bind_param($st, 'issss', $userId, $course, $startDate, $payment, $status);
    mysqli_stmt_execute($st);
}

function getRequestsByUser($link, $userId)
{
    $st = mysqli_prepare($link, 'SELECT * FROM requests WHERE user_id = ? ORDER BY id DESC');
    mysqli_stmt_bind_param($st, 'i', $userId);
    mysqli_stmt_execute($st);
    $result = mysqli_stmt_get_result($st);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// отзыв можно оставить только по завершённому обучению - проверка прямо в запросе
function addReview($link, $id, $userId, $text)
{
    $st = mysqli_prepare($link, "UPDATE requests SET review = ? WHERE id = ? AND user_id = ? AND status = 'Обучение завершено'");
    mysqli_stmt_bind_param($st, 'sii', $text, $id, $userId);
    mysqli_stmt_execute($st);
}

function changeRequestStatus($link, $id, $status, $validStatuses)
{
    if (in_array($status, $validStatuses, true)) {
        $st = mysqli_prepare($link, 'UPDATE requests SET status = ? WHERE id = ?');
        mysqli_stmt_bind_param($st, 'si', $status, $id);
        mysqli_stmt_execute($st);
    }
}

function getRequestsForAdmin($link, $filterStatus, $limit, $offset)
{
    $sql = 'SELECT r.*, u.fio, u.login FROM requests r JOIN users u ON u.id = r.user_id';
    if ($filterStatus != '') {
        $st = mysqli_prepare($link, $sql . ' WHERE r.status = ? ORDER BY r.id DESC LIMIT ? OFFSET ?');
        mysqli_stmt_bind_param($st, 'sii', $filterStatus, $limit, $offset);
    } else {
        $st = mysqli_prepare($link, $sql . ' ORDER BY r.id DESC LIMIT ? OFFSET ?');
        mysqli_stmt_bind_param($st, 'ii', $limit, $offset);
    }
    mysqli_stmt_execute($st);
    $result = mysqli_stmt_get_result($st);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function countRequestsForAdmin($link, $filterStatus)
{
    if ($filterStatus != '') {
        $st = mysqli_prepare($link, 'SELECT COUNT(*) AS cnt FROM requests WHERE status = ?');
        mysqli_stmt_bind_param($st, 's', $filterStatus);
    } else {
        $st = mysqli_prepare($link, 'SELECT COUNT(*) AS cnt FROM requests');
    }
    mysqli_stmt_execute($st);
    $result = mysqli_stmt_get_result($st);
    return (int) mysqli_fetch_assoc($result)['cnt'];
}
