<?php
session_start();
require '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $pass = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($pass, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Неверный логин или пароль";
    }
}
?>

<form method="post">
  <h2>Вход администратора</h2>
  <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  <input type="email" name="email" placeholder="Email" required><br>
  <input type="password" name="password" placeholder="Пароль" required><br>
  <button type="submit">Войти</button>
</form>
