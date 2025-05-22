<?php include 'includes/db.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container mt-5">
    <div class="jumbotron text-center bg-light p-5 rounded">
        <h1 class="display-4">Добро пожаловать в Онлайн-библиотеку</h1>
        <p class="lead">Читайте и скачивайте книги бесплатно и без регистрации!</p>
        <form action="catalog.php" method="get" class="d-flex justify-content-center mt-4">
            <input type="text" name="search" class="form-control w-50 me-2" placeholder="Поиск по названию или автору">
            <button type="submit" class="btn btn-primary">Найти</button>
        </form>
    </div>

    <h2 class="mt-5 mb-4">Популярные книги</h2>
    <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC LIMIT 6");
        while ($book = $stmt->fetch()) {
            echo '
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="assets/images/' . htmlspecialchars($book['cover_image']) . '" class="card-img-top" alt="Обложка">
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($book['title']) . '</h5>
                        <p class="card-text">Автор: ' . htmlspecialchars($book['author']) . '</p>
                        <a href="book.php?id=' . $book['id'] . '" class="btn btn-outline-primary">Подробнее</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
