<?php

class Request
{
    private $pdo;

    public static $statuses = ['Новая', 'Идёт обучение', 'Обучение завершено'];

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function create($userId, $course, $startDate, $payment)
    {
        $st = $this->pdo->prepare('INSERT INTO requests (user_id, course, start_date, payment, status) VALUES (?, ?, ?, ?, ?)');
        $st->execute([$userId, $course, $startDate, $payment, 'Новая']);
    }

    public function getByUser($userId)
    {
        $st = $this->pdo->prepare('SELECT * FROM requests WHERE user_id = ? ORDER BY id DESC');
        $st->execute([$userId]);
        return $st->fetchAll();
    }

    // отзыв можно оставить только по завершённому обучению - проверка прямо в запросе
    public function addReview($id, $userId, $text)
    {
        $st = $this->pdo->prepare("UPDATE requests SET review = ? WHERE id = ? AND user_id = ? AND status = 'Обучение завершено'");
        $st->execute([$text, $id, $userId]);
    }

    public function changeStatus($id, $status)
    {
        if (in_array($status, self::$statuses, true)) {
            $st = $this->pdo->prepare('UPDATE requests SET status = ? WHERE id = ?');
            $st->execute([$status, $id]);
        }
    }

    public function getForAdmin($filterStatus, $limit, $offset)
    {
        $sql = 'SELECT r.*, u.fio, u.login FROM requests r JOIN users u ON u.id = r.user_id';
        $params = [];
        if ($filterStatus != '') {
            $sql .= ' WHERE r.status = ?';
            $params[] = $filterStatus;
        }
        $sql .= ' ORDER BY r.id DESC LIMIT ' . (int)$limit . ' OFFSET ' . (int)$offset;

        $st = $this->pdo->prepare($sql);
        $st->execute($params);
        return $st->fetchAll();
    }

    public function countForAdmin($filterStatus)
    {
        $sql = 'SELECT COUNT(*) FROM requests';
        $params = [];
        if ($filterStatus != '') {
            $sql .= ' WHERE status = ?';
            $params[] = $filterStatus;
        }
        $st = $this->pdo->prepare($sql);
        $st->execute($params);
        return (int) $st->fetchColumn();
    }
}
