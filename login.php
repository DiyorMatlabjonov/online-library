<?php
require 'includes/db.php';
session_start();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Неверный email или пароль.";
    }
}
?>

<?php include 'includes/header.php'; ?>
<div class="container mt-5">
    <h2>Вход</h2>
    <?php if ($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
    <?php if (isset($_GET['success'])) echo "<div class='alert alert-success'>Регистрация прошла успешно. Войдите.</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Войти</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
