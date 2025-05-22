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
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <img src="assets/images/<?= htmlspecialchars($book['cover_image']) ?>" class="img-fluid rounded shadow" alt="Обложка">
        </div>
        <div class="col-md-8">
            <h2><?= htmlspecialchars($book['title']) ?></h2>
            <p><strong>Автор:</strong> <?= htmlspecialchars($book['author']) ?></p>
            <p><strong>Жанр:</strong> <?= htmlspecialchars($book['genre']) ?></p>
            <p><?= nl2br(htmlspecialchars($book['description'])) ?></p>
            <div class="mt-4">
                <a href="read.php?id=<?= $book['id'] ?>" class="btn btn-success me-2">Читать онлайн</a>
                <a href="download.php?id=<?= $book['id'] ?>" class="btn btn-primary">Скачать</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
