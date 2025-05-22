<?php
require 'includes/db.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Книга не найдена.</div></div>";
    include 'includes/footer.php';
    exit;
}

$filePath = "assets/books/" . $book['file_path'];
$text = file_exists($filePath) ? file_get_contents($filePath) : "Файл книги не найден.";
?>

<div class="container mt-5">
    <h3><?= htmlspecialchars($book['title']) ?> — <small><?= htmlspecialchars($book['author']) ?></small></h3>
    <hr>
    <div style="white-space: pre-wrap; font-family: serif; font-size: 18px; background-color: #f8f9fa; padding: 20px; border-radius: 10px;">
        <?= nl2br(htmlspecialchars($text)) ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
