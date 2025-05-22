<?php
require 'includes/db.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Валидация
    if (empty($name) || empty($email) || empty($password)) {
        $errors[] = "Все поля обязательны для заполнения.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Неверный формат email.";
    } elseif ($password !== $confirm) {
        $errors[] = "Пароли не совпадают.";
    } else {
        // Проверка уникальности email
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $errors[] = "Email уже используется.";
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $hash]);
        header("Location: login.php?success=1");
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Регистрация</h2>
    <?php foreach ($errors as $e) echo "<div class='alert alert-danger'>$e</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Имя</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Повторите пароль</label>
            <input type="password" name="confirm" class="form-control" required>
        </div>
        <button class="btn btn-primary">Зарегистрироваться</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
