<?php
require '../includes/auth.php';
require '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

// Удаляем книгу
$stmt = $pdo->prepare("DELETE FROM books WHERE id = ?");
$stmt->execute([$id]);

header("Location: dashboard.php");
exit;
