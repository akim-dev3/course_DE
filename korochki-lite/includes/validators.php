<?php

function validLogin($v)
{
    return preg_match('/^[a-zA-Z0-9]{6,}$/', $v);
}

function validPassword($v)
{
    return mb_strlen($v) >= 8;
}

function validFio($v)
{
    // ФИО - кириллица и пробелы
    return preg_match('/^[А-Яа-яЁё\s]{3,}$/u', $v);
}

function validPhone($v)
{
    return preg_match('/^8\(\d{3}\)\d{3}-\d{2}-\d{2}$/', $v);
}

function validEmail($v)
{
    return (bool) filter_var($v, FILTER_VALIDATE_EMAIL);
}

// дата в формате ДД.ММ.ГГГГ + проверка что реально существует
function validDate($v)
{
    if (!preg_match('/^(\d{2})\.(\d{2})\.(\d{4})$/', $v, $m)) {
        return false;
    }
    return checkdate((int)$m[2], (int)$m[1], (int)$m[3]);
}

function dateToSql($v)
{
    $p = explode('.', $v);
    return $p[2] . '-' . $p[1] . '-' . $p[0];
}
