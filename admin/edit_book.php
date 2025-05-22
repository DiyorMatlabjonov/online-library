<?php
require '../includes/auth.php';
require '../includes/db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: dashboard.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    echo "Книга не найдена.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];

    $filePath = $book['file_path'];
    $coverPath = $book['cover_image'];

    // Новая книга
    if (!empty($_FILES['book_file']['name'])) {
        $file = $_FILES['book_file'];
        $filePath = basename($file['name']);
        move_uploaded_file($file['tmp_name'], '../assets/books/' . $filePath);
    }

    // Новая обложка
    if (!empty($_FILES['cover_image']['name'])) {
        $cover = $_FILES['cover_image'];
        $coverPath = basename($cover['name']);
        move_uploaded_file($cover['tmp_name'], '../assets/images/' . $coverPath);
    }

    // Обновление книги
    $stmt = $pdo->prepare("UPDATE books SET title = ?, author = ?, genre = ?, description = ?, file_path = ?, cover_image = ? WHERE id = ?");
    $stmt->execute([$title, $author, $genre, $description, $filePath, $coverPath, $id]);

    header("Location: dashboard.php");
    exit;
}
?>

<h2>Редактировать книгу</h2>
<form method="post" enctype="multipart/form-data">
    <label>Название:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($book['title']) ?>" required><br><br>

    <label>Автор:</label><br>
    <input type="text" name="author" value="<?= htmlspecialchars($book['author']) ?>" required><br><br>

    <label>Жанр:</label><br>
    <input type="text" name="genre" value="<?= htmlspecialchars($book['genre']) ?>" required><br><br>

    <label>Описание:</label><br>
    <textarea name="description" rows="5" required><?= htmlspecialchars($book['description']) ?></textarea><br><br>

    <label>Файл книги (оставьте пустым, если не менять):</label><br>
    <input type="file" name="book_file" accept=".pdf,.txt"><br><br>

    <label>Обложка книги (оставьте пустым, если не менять):</label><br>
    <input type="file" name="cover_image" accept=".jpg,.jpeg,.png"><br><br>

    <button type="submit">Сохранить изменения</button>
</form>

<a href="dashboard.php">← Назад</a>
