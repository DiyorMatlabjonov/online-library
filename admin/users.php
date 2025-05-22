<?php
require '../includes/auth.php';
require '../includes/db.php';

$users = $pdo->query("SELECT id, name, email, role FROM users ORDER BY id DESC")->fetchAll();
?>

<h2>Зарегистрированные пользователи</h2>

<?php if (count($users) > 0): ?>
<table border="1" cellpadding="5">
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
    </tr>
    <?php foreach ($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= $user['role'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
    <p>Нет зарегистрированных пользователей.</p>
<?php endif; ?>

<a href="dashboard.php">← Назад</a>
