<?php

class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function isLoginTaken($login)
    {
        $st = $this->pdo->prepare('SELECT id FROM users WHERE login = ?');
        $st->execute([$login]);
        return (bool) $st->fetch();
    }

    public function register($login, $password, $fio, $phone, $email)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $st = $this->pdo->prepare('INSERT INTO users (login, password, fio, phone, email) VALUES (?, ?, ?, ?, ?)');
        $st->execute([$login, $hash, $fio, $phone, $email]);
    }

    public function attemptLogin($login, $password)
    {
        $st = $this->pdo->prepare('SELECT * FROM users WHERE login = ?');
        $st->execute([$login]);
        $user = $st->fetch();
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
