<?php
require '../includes/auth.php';
require '../includes/db.php';

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $description = $_POST['description'];

    // Загрузка файла книги
    $file = $_FILES['book_file'];
    $cover = $_FILES['cover_image'];

    $filePath = '../assets/books/' . basename($file['name']);
    $coverPath = '../assets/images/' . basename($cover['name']);

    move_uploaded_file($file['tmp_name'], $filePath);
    move_uploaded_file($cover['tmp_name'], $coverPath);

    // Сохраняем в БД
    $stmt = $pdo->prepare("INSERT INTO books (title, author, genre, description, file_path, cover_image, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
    $stmt->execute([
        $title,
        $author,
        $genre,
        $description,
        basename($file['name']),
        basename($cover['name'])
    ]);

    header("Location: dashboard.php");
    exit;
}
?>

<h2>Добавление книги</h2>
<form method="post" enctype="multipart/form-data">
    <label>Название:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Автор:</label><br>
    <input type="text" name="author" required><br><br>

    <label>Жанр:</label><br>
    <input type="text" name="genre" required><br><br>

    <label>Описание:</label><br>
    <textarea name="description" rows="5" required></textarea><br><br>

    <label>Файл книги (PDF или TXT):</label><br>
    <input type="file" name="book_file" accept=".pdf,.txt" required><br><br>

    <label>Обложка (JPG/PNG):</label><br>
    <input type="file" name="cover_image" accept=".jpg,.jpeg,.png" required><br><br>

    <button type="submit">Добавить книгу</button>
</form>

<a href="dashboard.php">← Назад</a>
