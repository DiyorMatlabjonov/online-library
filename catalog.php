<?php
require 'includes/db.php';
include 'includes/header.php';

$limit = 6;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$search = $_GET['search'] ?? '';
$genre = $_GET['genre'] ?? '';
$author = $_GET['author'] ?? '';

// Сбор параметров фильтрации
$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(title LIKE ? OR author LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($genre)) {
    $where[] = "genre = ?";
    $params[] = $genre;
}

if (!empty($author)) {
    $where[] = "author = ?";
    $params[] = $author;
}

$whereSQL = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Получение книг
$stmt = $pdo->prepare("SELECT * FROM books $whereSQL ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
$stmt->execute($params);
$books = $stmt->fetchAll();

// Получение жанров и авторов для фильтров
$genres = $pdo->query("SELECT DISTINCT genre FROM books ORDER BY genre")->fetchAll(PDO::FETCH_COLUMN);
$authors = $pdo->query("SELECT DISTINCT author FROM books ORDER BY author")->fetchAll(PDO::FETCH_COLUMN);

// Получение общего количества книг
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM books $whereSQL");
$countStmt->execute($params);
$totalBooks = $countStmt->fetchColumn();
$totalPages = ceil($totalBooks / $limit);
?>

<div class="container mt-5">
    <h2>Каталог книг</h2>

    <form method="get" class="row g-3 my-4">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Поиск по названию или автору" value="<?= htmlspecialchars($search) ?>">
        </div>
        <div class="col-md-3">
            <select name="genre" class="form-select">
                <option value="">Все жанры</option>
                <?php foreach ($genres as $g): ?>
                    <option value="<?= htmlspecialchars($g) ?>" <?= $g == $genre ? 'selected' : '' ?>><?= htmlspecialchars($g) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3">
            <select name="author" class="form-select">
                <option value="">Все авторы</option>
                <?php foreach ($authors as $a): ?>
                    <option value="<?= htmlspecialchars($a) ?>" <?= $a == $author ? 'selected' : '' ?>><?= htmlspecialchars($a) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100">Фильтр</button>
        </div>
    </form>

    <div class="row">
        <?php if ($books): ?>
            <?php foreach ($books as $book): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="assets/images/<?= htmlspecialchars($book['cover_image']) ?>" class="card-img-top" alt="Обложка">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                            <p class="card-text">Автор: <?= htmlspecialchars($book['author']) ?></p>
                            <a href="book.php?id=<?= $book['id'] ?>" class="btn btn-outline-primary">Подробнее</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning">Книги не найдены.</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Пагинация -->
    <?php if ($totalPages > 1): ?>
    <nav class="mt-4">
        <ul class="pagination justify-content-center">
            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                <li class="page-item <?= $p == $page ? 'active' : '' ?>">
                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>"><?= $p ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
