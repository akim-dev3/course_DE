<?php

class Request
{
    private $link;

    public static $statuses = ['Новая', 'Идёт обучение', 'Обучение завершено'];

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function create($userId, $course, $startDate, $payment)
    {
        $status = 'Новая';
        $st = mysqli_prepare($this->link, 'INSERT INTO requests (user_id, course, start_date, payment, status) VALUES (?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($st, 'issss', $userId, $course, $startDate, $payment, $status);
        mysqli_stmt_execute($st);
    }

    public function getByUser($userId)
    {
        $st = mysqli_prepare($this->link, 'SELECT * FROM requests WHERE user_id = ? ORDER BY id DESC');
        mysqli_stmt_bind_param($st, 'i', $userId);
        mysqli_stmt_execute($st);
        $result = mysqli_stmt_get_result($st);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    // отзыв можно оставить только по завершённому обучению - проверка прямо в запросе
    public function addReview($id, $userId, $text)
    {
        $st = mysqli_prepare($this->link, "UPDATE requests SET review = ? WHERE id = ? AND user_id = ? AND status = 'Обучение завершено'");
        mysqli_stmt_bind_param($st, 'sii', $text, $id, $userId);
        mysqli_stmt_execute($st);
    }

    public function changeStatus($id, $status)
    {
        if (in_array($status, self::$statuses, true)) {
            $st = mysqli_prepare($this->link, 'UPDATE requests SET status = ? WHERE id = ?');
            mysqli_stmt_bind_param($st, 'si', $status, $id);
            mysqli_stmt_execute($st);
        }
    }

    public function getForAdmin($filterStatus, $limit, $offset)
    {
        $sql = 'SELECT r.*, u.fio, u.login FROM requests r JOIN users u ON u.id = r.user_id';
        if ($filterStatus != '') {
            $st = mysqli_prepare($this->link, $sql . ' WHERE r.status = ? ORDER BY r.id DESC LIMIT ? OFFSET ?');
            mysqli_stmt_bind_param($st, 'sii', $filterStatus, $limit, $offset);
        } else {
            $st = mysqli_prepare($this->link, $sql . ' ORDER BY r.id DESC LIMIT ? OFFSET ?');
            mysqli_stmt_bind_param($st, 'ii', $limit, $offset);
        }
        mysqli_stmt_execute($st);
        $result = mysqli_stmt_get_result($st);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function countForAdmin($filterStatus)
    {
        if ($filterStatus != '') {
            $st = mysqli_prepare($this->link, 'SELECT COUNT(*) AS cnt FROM requests WHERE status = ?');
            mysqli_stmt_bind_param($st, 's', $filterStatus);
        } else {
            $st = mysqli_prepare($this->link, 'SELECT COUNT(*) AS cnt FROM requests');
        }
        mysqli_stmt_execute($st);
        $result = mysqli_stmt_get_result($st);
        return (int) mysqli_fetch_assoc($result)['cnt'];
    }
}
