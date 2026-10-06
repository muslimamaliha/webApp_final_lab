<?php
function e($v)
{
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}
function logged_in()
{
    return isset($_SESSION['user_id']);
}
function admin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
function need_admin()
{
    if (!admin()) {
        header('Location: ../login.php');
        exit;
    }
}

