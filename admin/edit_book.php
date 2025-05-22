<?php
require '../includes/auth.php';
require '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

// Получаем текущую информацию о книге
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    echo "Книга не найдена.";
    exit;
}

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];

    // Обновление книги
    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, genre = ?, description = ? WHERE id = ?");
    $stmt->execute([$title, $author, $genre, $description, $id]);

    header("Location: dashboard.php");
    exit;
}
?>

<h2>Редактировать книгу</h2>
<form method="post">
    <label>Название:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required><br><br>

    <label>Автор:</label><br>
    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required><br><br>

    <label>Жанр:</label><br>
    <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required><br><br>

    <label>Описание:</label><br>
    <textarea name="description" rows="5" required><?= htmlspecialchars($book['description']) ?></textarea><br><br>

    <button type="submit">Сохранить изменения</button>
</form>

<a href="dashboard.php">← Назад</a>
