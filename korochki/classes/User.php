<?php

class User
{
    private $link;

    public function __construct($link)
    {
        $this->link = $link;
    }

    public function isLoginTaken($login)
    {
        $st = mysqli_prepare($this->link, 'SELECT id FROM users WHERE login = ?');
        mysqli_stmt_bind_param($st, 's', $login);
        mysqli_stmt_execute($st);
        mysqli_stmt_store_result($st);
        return mysqli_stmt_num_rows($st) > 0;
    }

    public function register($login, $password, $fio, $phone, $email)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $st = mysqli_prepare($this->link, 'INSERT INTO users (login, password, fio, phone, email) VALUES (?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($st, 'sssss', $login, $hash, $fio, $phone, $email);
        mysqli_stmt_execute($st);
    }

    public function attemptLogin($login, $password)
    {
        $st = mysqli_prepare($this->link, 'SELECT * FROM users WHERE login = ?');
        mysqli_stmt_bind_param($st, 's', $login);
        mysqli_stmt_execute($st);
        $result = mysqli_stmt_get_result($st);
        $user = mysqli_fetch_assoc($result);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}
