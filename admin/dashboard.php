
<?php
require '../includes/auth.php';
require '../includes/db.php';



$stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
$books = $stmt->fetchAll()
?>


<a href="add_book.php">➕ Добавить книгу</a> |
<a href="logout.php">🚪 Выйти</a>

<h2>Все книги</h2>
<table border="1">
  <tr>
    <th>Название</th>
    <th>Автор</th>
    <th>Жанр</th>
    <th>Действия</th>
  </tr>
  <?php foreach ($books as $book): ?>
    <tr>
      <td><?= htmlspecialchars($book['title']) ?></td>
      <td><?= htmlspecialchars($book['author']) ?></td>
      <td><?= htmlspecialchars($book['genre']) ?></td>
      <td>
        <a href="edit_book.php?id=<?= $book['id'] ?>">✏️ Редактировать</a> |
        <a href="delete_book.php?id=<?= $book['id'] ?>" onclick="return confirm('Удалить эту книгу?')">🗑️ Удалить</a>
      </td>

    </tr>
  <?php endforeach; ?>
</table>