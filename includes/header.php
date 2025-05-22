<?php
session_start();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Онлайн-библиотека</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="index.php">Библиотека</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a href="catalog.php" class="nav-link">Каталог</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="nav-link text-white">Привет, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">Выйти</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a href="login.php" class="nav-link">Вход</a></li>
                    <li class="nav-item"><a href="register.php" class="nav-link">Регистрация</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
